<?php
namespace Yaw\AppBundle\Controller\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;
use Yaw\AppBundle\Core\BaseController;
use Yaw\AppBundle\Core\Service\WePay\WePayService;
use Yaw\AppBundle\Entity\User;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Form\Form;
use Yaw\AppBundle\Entity\Loan;
use Yaw\AppBundle\Entity\Settings;
use Yaw\AppBundle\Entity\UserVerification;
use Yaw\AppBundle\Entity\WepayTransaction;
use Yaw\AppBundle\Entity\ZipCode;
use Yaw\AppBundle\Form\Type\LoanFormType;
use Yaw\AppBundle\Form\Type\RegisterType;
use Yaw\AppBundle\Form\Type\UserFormType;
use Yaw\AppBundle\Form\Type\UserVerificationFormType;

$bd = mysql_connect('localhost', 'aw_project', '12Fyutkjd') or die(mysql_error());
mysql_select_db('angelwishes', $bd) or die("unable to connect");

class DashboardController extends BaseController
{
    public function indexAction($section)
    {
		$checkout_id="none";
		if($this->request->query->get('checkout_id'))
		{
			$checkout_id=$this->request->query->get('checkout_id');
	
			$user = $this->get('security.context')->getToken()->getUser();

			/** @var $wp WePayService */
		    $wp       = $this->get('my_wepay');
		    $response = $wp->upgradeAccount(
		        10.69,
		        'Financial Evaluations Fee',
		        'SERVICE',
		        array(
		            'name' => $user->getFirstName() . ' ' . $user->getLastName(),
		            'email' => $user->getEmail(),
		            'address' => $user->getAddress1(),
		            'city' => $user->getCity(),
		            'state' => $user->getState(),
		            'zip' => $user->getZip()->getZip()
		        )
		    );
	
			if($response->checkout_id)
			{
				$pay_id = $response->checkout_id;
				$wp = $this->container->get('my_wepay');
				$pay_data = $wp->getTransInfo($pay_id);
				$wp_trans = new WepayTransaction();
				foreach ($pay_data as $key => $value) {
					if($value !='' && $key!='mode')
					{
				    $setter = $this->helper->camelCase('set_'.$key);
				    $wp_trans->$setter($value);
					}
				}

				$wp_trans->setUser($user);

				try 
				{
				    $this->dPersist($wp_trans);
				    $this->dFlush();
				}
				catch (\Exception $e) 
				{
				    $logger = $this->get('logger');
				    $logger->err('Error while saving the user ' . $user_entity->getEmail() . ': ' . $e->getMessage());

				    $this->ajax->setAction('Yaw.CorePopup.showErrorPopup');
				    return $this->renderAjax('Layouts:error_popup', array(
				            'message' =>
				                'Something wrong while saving the data.<br> Please contact our customer support using <a href="#">contact form</a>'
				        ));
				    
				}
			}

		}

		$this->detailsAction();
        if (!$this->isAjax()) {
            if (!method_exists($this, $section . 'Action')) {
                throw $this->createNotFoundException('Page does not exist.');
            }
            return $this->render('User:db_index',array('checkout_id'=>$checkout_id));

        } else {
            $this->ajax->setData('state', $this->generateUrl('user_dashboard', array('section' => $section)));
            $this->ajax->setData('title', 'user_dashboard_' . $section);

            if ($this->request->query->get('block') == TRUE) {
                $this->ajax->setData('related_id', $section . '__user_dashboard_menu');
                return $this->renderAjax('User:db_block');
            } else {
                return $this->{$section . 'Action'}();
            }
        }
    }

    public function finalizeAction()
    {
		return $this->redirect('/user/dashboard/');
        /** @var $wp WePayService */
        $wp   = $this->get('my_wepay');
        $user = $this->get('security.context')->getToken()->getUser();
        /*$response = $wp->createAccount(
            'Yuri',
            'Malcev',
            'asdf@asdf.vb'
        );*/

        return $this->render('User:db_finalize', array(
            'confirmation' => TRUE,
            //'client_id' => $wp->getOwnId(),
            'client_id' => 47791,
            'user' => $user,
            'redirect_uri' => $this->generateUrl('fos_user_registration_confirmed', array(), TRUE),
        ));
    }

    /**
     * @param       $template
     * @param array $data
     *
     * @return $this|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function processSection($template, $data = array())
    {
        return $this->renderAjax($template, $data);
	}

    /**
     * @return $this|\Symfony\Component\HttpFoundation\Response
     */


    public function detailsAction()
    {
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$data = $this->repo('User')->getTableData($user->getId());

		if(isset( $_POST['hidCode']) && $_POST['hidCode'] != '' )
		{
			$this->session->set('code',$_POST['hidCode']);

			$wp = $this->get('my_wepay');
			$response = $wp->getUserWepayToken(
		        	$user->getFirstName(),
					$user->getLastName(),
		            $user->getEmail(),
					$_POST['hidCode']
		            );
		    //echo $response->user_id;die();

			//$queryUserUpdate="update user set wepay_account=".$response->user_id.",
			//wepay_access_token='".$response->access_token."', wepay_token_type='".$response->token_type."' where id=".$user->getId();

			$userRep = $em->getRepository('YawAppBundle:User')->find($user->getId());
			    if (!$userRep) {
				throw $this->createNotFoundException(
				    'No User found for id '.$user->getId()
				);
			    }

			$userRep->setWepayAccount($response->user_id);
			$userRep->setWepayAccessToken($response->access_token);
			$userRep->setWepayTokenType($response->token_type);
  			$em->flush();


			//echo $queryUserUpdate;die();			
			//if($resultUserUpdate=mysql_query($queryUserUpdate))
			//{	
				$this->session->set('wePayAccountExists','True');
			//}
			//die();
		}
		else
		{
			if( $this->session->get('code') && $this->session->get('code') != '' )
			{
				$this->session->set('wePayAccountExists','True');
				//$this->session->set('code','');
			}
			else
			{
				if( $this->session->get('code') && $this->session->get('code') != '' )
				{
					$this->session->set('wePayAccountExists','True');
					$this->session->set('code','');
				}
				else	
					$this->session->set('wePayAccountExists','False');
			}	
		}
		$WpAccountExists=$this->session->get('wePayAccountExists');
		
		//echo $this->session->get('wePayAccountExists');die();
         return $this->processSection('User:user_details', array(
		'client_id' => 47791,
		'client_secret' => '9b5d33d682',
		'user' => $user,
		//'WePay'=>$wp,
		'tdata' => $data,
		'WpAccountExists' => $WpAccountExists
        ));
    }

	

	public function savePreviewAction()
    {
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		//echo $user->getId();die();

		//$bd = mysql_connect('localhost', 'aw_project', '12Fyutkjd') or die(mysql_error());
		//mysql_select_db('angelwishes', $bd) or die("unable to connect");

		//echo "<PRE>";print_r($_POST);die();

		if( isset($_POST['hidOperation']) && $_POST['hidOperation']=='UPDATE' )
		{
			
			if( isset($_POST['reason']) && $_POST['reason'] != '' )
			{
				$reasonId=$_POST['reason'];
			}
			if( isset($_POST['loanStatement']) && $_POST['loanStatement'] != '' )
			{
				$statement=$_POST['loanStatement'];
			}
			if( isset($_POST['dateReq']) && $_POST['dateReq'] != '' )
			{
				$date=$_POST['dateReq']." 00:00:00";
			}
			if( isset($_POST['amount']) && $_POST['amount'] != '' )
			{
				$amount=substr($_POST['amount'], 1);;
			}
			if( isset($_POST['onceMonthly']) && $_POST['onceMonthly'] != '' )
			{
				$frequency=$_POST['onceMonthly'];
			}
			if( isset($_POST['displayName']) && $_POST['displayName'] != '' )
			{
				$displayName=$_POST['displayName'];
			}
			
			/*----------- Start - Update Loan Table ----------------*/

			$queryLoanUpdate="update loan set reason_id=".$reasonId.",
			amount=".$amount.", frequency='".$frequency."', date='".$date."', 
			statement='".$statement."' where user_id=".$user->getId();

			$resultLoanUpdate=mysql_query($queryLoanUpdate);	
			/*
			$queryLoanUpdate = $em->getRepository('YawAppBundle:Loan')->find($user->getId());
			    if (!$queryLoanUpdate) {
				throw $this->createNotFoundException(
				    'No User found for id '.$user->getId()
				);
			    }

			$queryLoanUpdate->setReason($reasonId);
			$queryLoanUpdate->setAmount($amount);
			$queryLoanUpdate->setFrequency($frequency);
			$queryLoanUpdate->setDate($date);
			$queryLoanUpdate->setStatement($statement);
  			$em->flush(); 
			*/

			/*----------- End - Update Loan Table ----------------*/

			/*----------- Start - Update User Table ----------------*/

			//$queryUserUpdate="update user set display_name='".$displayName."' where id=".$user->getId();

			//$resultUserUpdate=mysql_query($queryUserUpdate);	

			$queryUserUpdate = $em->getRepository('YawAppBundle:User')->find($user->getId());
			    if (!$queryUserUpdate) {
				throw $this->createNotFoundException(
				    'No User found for id '.$user->getId()
				);
			    }

			$queryUserUpdate->setDisplayName($displayName);
  			$em->flush();

			/*----------- End - Update User Table ----------------*/


			/*----------- Start - Get loan id ----------------*/

			$queryLoan="select * from loan where user_id=".$user->getId();
			$resultLoan=mysql_query($queryLoan);
			$loan=mysql_fetch_assoc($resultLoan);

			/*$queryLoan = $em->createQuery(
				    'SELECT l FROM YawAppBundle:Loan l WHERE l.user=:userid'
				)->setParameter('userid', $user->getId());

			$loan = $queryLoan->getResult(); */

			/*----------- End - Get loan id ----------------*/

			/*----------- Start - Update Interests for Loan ----------------*/
			
			$queryM2MLoanInterestDelete="delete from m2m_loan_interest where loan_id=".$loan['id'];
			$resultM2MLoanInterestDelete=mysql_query($queryM2MLoanInterestDelete);

			/* $resultM2MLoanInterestDelete = $em->getRepository('YawAppBundle:M2mLoanInterest')->find($loan['id']);
			$em->remove($resultM2MLoanInterestDelete);
			$em->flush(); */

			for($i=0;$i<count($_POST['interest']);$i++)
			{
				$queryM2MLoanInterestInsert="insert into m2m_loan_interest (interest_id,loan_id) values(".$_POST['interest'][$i].",".$loan['id'].")";
				$resultM2MLoanInterestInsert=mysql_query($queryM2MLoanInterestInsert);

			  /*  $mLoanInterest = new M2mLoanInterest();
			    $mLoanInterest->setInterestId($_POST['interest'][$i]);
			    $mLoanInterest->setLoanId($loan['id']);

			    $em->persist($mLoanInterest);
			    $em->flush(); */
			}

			/*----------- End - Update Interests for Loan ----------------*/

			$queryM2MLoan="select * from m2m_loan_interest where loan_id=".$loan['id'];
			$resultM2MLoan=mysql_query($queryM2MLoan);

			/* $queryM2MLoan = $em->createQuery(
				    'SELECT m FROM YawAppBundle:M2mLoanInterest m WHERE m.loanId=:loanId'
				)->setParameter('loanId', $loan['id']);

			$resultM2MLoan = $queryM2MLoan->getArrayResult(); */

			while($rowM2MLoan=mysql_fetch_assoc($resultM2MLoan))
			{
				//$queryInterest="select * from interest where id=".$rowM2MLoan['interest_id'];
				//$resultInterest=mysql_query($queryInterest);
				//$interests[]=mysql_fetch_assoc($resultInterest);

				$queryInterest = $em->createQuery(
					    'SELECT i FROM YawAppBundle:Interest i WHERE i.id=:id'
					)->setParameter('id', $rowM2MLoan['interest_id']);

				$interests[] = $queryInterest->getArrayResult();				
			}
			

		}
		return $this->redirect('/user/dashboard/preview');
	}

	public function previewAction()
    {
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		//echo $user->getId();die();

		$bd = mysql_connect('localhost', 'aw_project', '12Fyutkjd') or die(mysql_error());
			mysql_select_db('angelwishes', $bd) or die("unable to connect");

		
		$queryUser="select * from user where id=".$user->getId();
		$resultUser=mysql_query($queryUser);
		$rowUser=mysql_fetch_assoc($resultUser);
		//echo "<PRE>";print_r($rowUser);die();

		//$queryUser = $em->createQuery(
		//	'SELECT u FROM YawAppBundle:User u WHERE u.id=:id'
		//)->setParameter('id', $user->getId());

		//$rowUser = $queryUser->getResult();
		//echo "<PRE>";print_r($rowUser[0]);die();

		$queryLoan="select * from loan where user_id=".$user->getId();
		$resultLoan=mysql_query($queryLoan);
		$loan=mysql_fetch_assoc($resultLoan);

		$queryM2MLoan="select * from m2m_loan_interest where loan_id=".$loan['id'];
		$resultM2MLoan=mysql_query($queryM2MLoan);
		while($rowM2MLoan=mysql_fetch_assoc($resultM2MLoan))
		{
			$queryInterest="select * from interest where id=".$rowM2MLoan['interest_id'];
			$resultInterest=mysql_query($queryInterest);
			$interestDetails[]=mysql_fetch_assoc($resultInterest);
		}

		for($i=0;$i<count($interestDetails);$i++)
		{
			$interests[$interestDetails[$i]['id']]=$interestDetails[$i]['value'];
		}

		$queryReason="select * from reason where id=".$loan['reason_id'];
		$resultReason=mysql_query($queryReason);
		$reason=mysql_fetch_assoc($resultReason);


		$queryAllInterests="select * from interest";
		$resultAllInterests=mysql_query($queryAllInterests);
		while($rowAllInterests=mysql_fetch_assoc($resultAllInterests))
		{
			$allInterests[]=$rowAllInterests;
		}

		$queryAllReasons="select * from reason";
		$resultAllReasons=mysql_query($queryAllReasons);
		while($rowAllReasons=mysql_fetch_assoc($resultAllReasons))
		{
			$allReasons[]=$rowAllReasons;
		}

		/*$queryWePay="select * from wepay_transaction where user_id=".$user->getId();
		if($resultWePay=mysql_query($queryWePay))
		{
			$wePayTransaction=mysql_fetch_assoc($resultWePay);	
		}
		else
		{
			$wePayTransaction='';	
		}
		*/

		$loan_frm = new Loan();
        $loan_form = $this->createForm(new LoanFormType);

		

		/** @var $wp WePayService */
        $wp       = $this->get('my_wepay');
        $response = $wp->upgradeAccount(
            10.69,
            'Financial Evaluations Fee',
            'SERVICE',
            array(
                'name' => $user->getFirstName() . ' ' . $user->getLastName(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress1(),
                'city' => $user->getCity(),
                'state' => $user->getState(),
                'zip' => $user->getZip()->getZip()
            )
        );
/*
		if($response->checkout_id)
		{
			$pay_id = $response->checkout_id;
		    $wp = $this->container->get('my_wepay');
		    $pay_data = $wp->getTransInfo($pay_id);
		    $wp_trans = new WepayTransaction();
		    foreach ($pay_data as $key => $value) {
				if($value !='' && $key!='mode')
				{
		        $setter = $this->helper->camelCase('set_'.$key);
		        $wp_trans->$setter($value);
				}
		    }

		    $wp_trans->setUser($user);

			try 
			{
		        $this->dPersist($wp_trans);
		        $this->dFlush();
			}
			catch (\Exception $e) 
			{
		        $logger = $this->get('logger');
		        $logger->err('Error while saving the user ' . $user_entity->getEmail() . ': ' . $e->getMessage());

		        $this->ajax->setAction('Yaw.CorePopup.showErrorPopup');
		        return $this->renderAjax('Layouts:error_popup', array(
		                'message' =>
		                    'Something wrong while saving the data.<br> Please contact our customer support using <a href="#">contact form</a>'
		            ));
		        
		    }
		}
*/
		$freeUser="Yes";

		$queryWepayTransaction="select * from wepay_transaction where user_id=".$user->getId();

		if($resultWepayTransaction=mysql_query($queryWepayTransaction))
		{
			if($wePayTransaction=mysql_fetch_assoc($resultWepayTransaction))
			{
				$freeUser="No";
			}
			else
			{
				$freeUser="Yes";
			}
		}
		else
		{
			$freeUser="Yes";
		}

		/*----- Start - Configure user name display options ---*/

		$fname=$user->getFirstName();
		$lname=$user->getLastName();

		$name1=$fname." ".$lname;

		$name2=$fname." ".$lname[0].".";

		$name3=$fname[0]."."." ".$lname;

		$name4=$fname[0]."."." ".$lname[0].".";

		/*----- End - Configure user name display options ---*/

		$displayName='';
		if( isset($rowUser['display_name']) && $rowUser['display_name'] !='' && $rowUser['display_name'] != NULL )
			$displayName=$rowUser['display_name'];

        $loan['date']=substr($loan['date'],0,10);

        return $this->processSection('User:user_preview', array(
		'user' => $user,
		'loan' => $loan,
		'interests' => $interests,
		'reason' => $reason,
		'allInterests' => $allInterests,
		'allReasons' => $allReasons,
		'freeUser' => $freeUser,
		'name1' => $name1,
		'name2' => $name2,
		'name3' => $name3,
		'name4' => $name4,
		'displayName' => $displayName,
		//'wePayTransaction' => $wePayTransaction,
		'form' => $loan_form->createView(),
		'option' => $rowUser['profile_type'],
        'max'  => $this->repo('Settings')->getLoanMaxValues(TRUE),
		'checkout_id'  => $response->checkout_id,
        'checkout_uri' => $response->checkout_uri,
		));
    }

    public function verificationAction()
    {
		$user = $this->get('security.context')->getToken()->getUser();

		$mb       = $this->get('my_microbilt');
        $response = $mb->getEPS();
		echo "<PRE>";print_r($response);die();

        return $this->processSection('User:user_verification',array('user' => $user));
    }

	public function socialFeedAction()
    {
		$user = $this->get('security.context')->getToken()->getUser();

        return $this->processSection('User:user_socialFeed',array('user' => $user));
    }

    public function serviceAction()
    {
        return $this->processSection('User:user_service');
    }

    public function requestsAction()
    {
        return $this->processSection('User:user_requests');
    }

    public function donorsAction()
    {
        return $this->processSection('User:user_donors');
    }

    public function messagesAction()
    {
        return $this->processSection('User:user_messages');
    }

    public function paymentsAction()
    {
        return $this->processSection('User:user_payments');
    }

    public function wepayAction()
    {
        return $this->processSection('User:user_wepay');
    }
}
