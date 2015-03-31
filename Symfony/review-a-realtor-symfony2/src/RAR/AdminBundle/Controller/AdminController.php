<?php
namespace RAR\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RAR\AdminBundle\Entity\User;
use RAR\AdminBundle\Entity\Advertiesment;
use RAR\AdminBundle\Modals\Login;
use RAR\AdminBundle\Entity\fpdf;
use RAR\AdminBundle\Entity\Plan;
use RAR\AdminBundle\Entity\Claim;
use RAR\AdminBundle\Entity\CMS;
use RAR\WebBundle\Entity\Property;
use RAR\WebBundle\Entity\PropertyImages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \DateTime;
class AdminController extends Controller
{   
	// function for admin login
	public function indexAction(Request $request) 
	{ 
		//get value of session 
		$session = $this->getRequest()->getSession();
		if( $session->get('userId') && $session->get('userId') != '' )
		{
	        //if user is login then it will be redirect to login page    			
			return $this->redirect($this->generateUrl('RARAdminBundle_dashboard'));
		}       
		$em = $this->getDoctrine()
	    ->getEntityManager();
		$repository = $em->getRepository('RARAdminBundle:User');
		if ($request->getMethod() == 'POST')
	 	{
	   		$session->clear();
	    	$email = $request->get('email');
	    	$password = md5($request->get('password'));
	    	$remember = $request->get('remember');
	    	//find email, password type and status of admin
            $user = $repository->findOneBy(array('email' => $email, 'password' => $password,'type'=>1,'status'=>1 ));
            if ($user) 
            {
              	//set remember me cookies for admin
             	if(isset($_POST["remember"])) 
             	{
					$response = new Response();
					$response->headers->setCookie(new Cookie('email', $email, 0, '/', null, false, false)); 
					$response->headers->getCookies();
					echo $response;die();
				}
				//set session of admin login                        
                $session->set('userId', $user->getId());
                $session->set('userType', $user->getType());
          	/* if($user->getType()==1)
          			return $this->redirect($this->generateUrl('rar_web_homepage'));
          	 else                                        
   							return $this->redirect($this->generateUrl('RARAdminBundle_dashboard'));
   							
   						 if($user->getType()==2)
          			return $this->redirect($this->generateUrl('rar_web_home'));
          	 else                                        
   							return $this->redirect($this->generateUrl('RARAdminBundle_dashboard'));	*/	                                   
                return $this->redirect($this->generateUrl('RARAdminBundle_dashboard'));
            } 
            else 
            {
  
                return $this->render('RARAdminBundle:Login:login.html.twig', array('name' => 'Invalid Email/Password'));
            }
     
     	}
     
 			return $this->render('RARAdminBundle:Login:login.html.twig');
	}
    
    /*---- function for Admin Logout  -----*/ 
 	public function logoutAction(Request $request) 
 	{
    	$session = $this->getRequest()->getSession();
    		$session->remove('userId');
    	return $this->render('RARAdminBundle:Login:login.html.twig');
    }

	public function changeAction(Request $request) 
	{
		return $this->render('RARAdminBundle:Login:changePassword.html.twig');

	}			
		 
	/*---- function for  - Admin Forgot Password  -----*/
	public function forgotAction(Request $request) 
	{
		$email=$this->get('request')->request->get('email');
		$em = $this->getDoctrine()
        ->getEntityManager();
    	$repository = $em->getRepository('RARAdminBundle:User');
    	if ($request->getMethod() == 'POST') 
        {
            $user = $repository->findOneBy(array('email' => $email,'type'=>1));
            if ($user) 
            {   
				//genrate a random number
				$newPassword=rand(100000,'999999');
				//echo $newPassword;
				$encPass=md5($newPassword);
				$realtors = $em->createQueryBuilder()
				->select('b')
				->update('RARAdminBundle:User',  'b')
				->set('b.password', ':password')
				->setParameter('password', $encPass)
				->where('b.email=:email')
				->setParameter('email', $email)
				->getQuery()
				->getResult();
				//genrate random number													
				$newPassword=rand(100000,999999);
				//password is encrypted into md5 
				$encPass=md5($newPassword); 
				$date=date("Y/m/d.");
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <support@review-a-realtor.com>' . "\r\n";
				$to = $email;
				$subject = "Password Reset";
				$txt='Hello '. $user->getFirstName().' '. $user->getLastName().',<br><br>Your password has been reset on '.$date.'<br><br>Your new Password is: <b>'.	$newPassword.'</b>';
				mail($to,$subject,$txt,$headers); //send mail                
				return $this->render('RARAdminBundle:Login:confirmPas.html.twig',array('name' => $email));
			} 
			else 
			{
                return $this->render('RARAdminBundle:Login:forgotPassword.html.twig', array('name1' => 'Invalid Email'));
			}
		}
 		return $this->render('RARAdminBundle:Login:forgotPassword.html.twig');
	}
  public function realtorAction( Request $request)
	{ 
		ini_set('display_errors', 1);
		ini_set('max_execution_time', 1000000000);
		ini_set('memory_limit','1000000000000000000M');
		$session = $this->getRequest()->getSession();           
		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_login'));
		}	 
		// fetch data of realtors
		$em = $this->getDoctrine()->getEntityManager();
		$realtors = $em->createQueryBuilder()
		->select('b.first_name,b.last_name,b.email,b.address,b.address2,b.pincode,b.country,b.phone,b.id,b.city,state.state_name,city.city_name')
		->from('RARAdminBundle:User',  'b')
		->leftJoin('RARAdminBundle:State', 'state', "WITH", "b.state=state.state_code")
		->leftJoin('RARAdminBundle:City', 'city', "WITH", "b.city=city.id")
		->Where('b.type = 2') //fetches data whose type=2
		//->andWhere('b.status=1')
		->getQuery()
		->getArrayResult();
		return $this->render('RARAdminBundle:Realtor:realtor.html.twig', array('realtors' => $realtors));   
	}
    

	/*---- Start - Delete realtor  -----*/ 
	public function deleteRealtorAction($id)
	{
		$em = $this->getDoctrine()
	    ->getEntityManager();
		$realtor = $em->getRepository('RARAdminBundle:User')->find($id);
		if (!$realtor)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($realtor);
		$em->flush();
		return $this->redirect($this->generateUrl('RARAdminBundle_realtor'));
	}

	/*---- Start - Update realtor  -----*/ 
	public function updateRealtorAction(Request $request,$id)
	{
		// get all states 
		$states = $this->getStatesAction();	
		$em = $this->getDoctrine()
		->getEntityManager();
		$realtorsPlan = $em->createQueryBuilder()
		->select('plan.name')
		->from('RARAdminBundle:Plan',  'plan')
		->leftJoin('RARAdminBundle:User', 'user', "WITH", "plan.id=user.plan_id")
		->where('user.id=:userId')
		->setParameter('userId', $id)
		
		 //fetches data whose type=2
		//->andWhere('b.status=1')
		->getQuery()
		->getArrayResult();
		
		
		$realtor = $em->getRepository('RARAdminBundle:User')->find($id);
		if (!$realtor) 
		{
		return $this->redirect($this->generateUrl('RARAdminBundle_error'));	
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$realtor = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$realtor = $em->getRepository('RARAdminBundle:User')->find($id);
			if(!$realtor)
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));				
		}
		//update realtors information
		if($request->getMethod() == 'POST') 
		{
		$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"uploads/" . $_FILES["file"]["name"]);
      			$logo  = $_FILES['logo']['tmp_name'];  
    		move_uploaded_file($_FILES["logo"]["tmp_name"],
      		"logo/" . $_FILES["logo"]["name"]);
			$firstname=$this->get('request')->request->get('firstname');
			$lastname=$this->get('request')->request->get('lastname');
			$email=$this->get('request')->request->get('email');
			$phone=$this->get('request')->request->get('phone');
			$state=$this->get('request')->request->get('state');
			$address=$this->get('request')->request->get('address');
			$city=$this->get('request')->request->get('city');
			$country=$this->get('request')->request->get('country');
			$company=$this->get('request')->request->get('company');
			$fax=$this->get('request')->request->get('fax');
			$overview=$this->get('request')->request->get('overview');
			$pincode=$this->get('request')->request->get('pincode');
			$twitter=$this->get('request')->request->get('twitter');
			$facebook=$this->get('request')->request->get('facebook');
			$google=$this->get('request')->request->get('google');
			$linkedin=$this->get('request')->request->get('linkedin');
			$video=$this->get('request')->request->get('video');
			$realtor->setFirstName($firstname);
			$realtor->setLastName($lastname);
			$realtor->setEmail($email);
			$realtor->setPhone($phone);
			$realtor->setState($state);
			$realtor->setAddress($address);
			$realtor->setCity($city);
			$realtor->setImage($file);
			$realtor->setLogo($logo);
			$realtor->setCountry($country);
			$realtor->setPinCode($pincode);
			$realtor->setFax($fax);
			$realtor->setOverview($overview);
			$realtor->setBusinessName($company);
			$realtor->setTwitter($twitter);
			$realtor->setFacebook($facebook);
			$realtor->setGoogle($google);
			$realtor->setLinkedin($linkedin);
			$realtor->setVideo($video);
			$em->persist($realtor);
			$em->flush();
			return $this->redirect($this->generateUrl('RARAdminBundle_realtor'));				
		}
			return $this->render('RARAdminBundle:Realtor:realtorUpdate.html.twig', array('realtor' => $realtor,'states' => $states,'realtorsPlan'=>$realtorsPlan));    
	}

	public function errorAction(Request $request)
	{
	return $this->render('RARAdminBundle:Error:error.html.twig');    
		}



	/*---- Start - Add new realtor  -----*/ 
	public function addrealtorAction(Request $request)
	{
		$plans = $this->getPlanAction();
		// get all states 
		$states = $this->getStatesAction();
		if ($request->getMethod() == 'POST') 
		{
  			$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"uploads/" . $_FILES["file"]["name"]);
      			$logo  = $_FILES['logo']['tmp_name'];  
    		move_uploaded_file($_FILES["logo"]["tmp_name"],
      		"logo/" . $_FILES["logo"]["name"]);
			$firstname=$this->get('request')->request->get('firstname');
			$lastname=$this->get('request')->request->get('lastname');
			$password=$this->get('request')->request->get('password');
			$email=$this->get('request')->request->get('email');
			$phone=$this->get('request')->request->get('phone');
			$state=$this->get('request')->request->get('state');
			$address=$this->get('request')->request->get('address');
			$address2=$this->get('request')->request->get('address2');
			$city=$this->get('request')->request->get('city');
			$id=$this->get('request')->request->get('id');
			$plan=$this->get('request')->request->get('plan');
			$planName=$this->get('request')->request->get('planName');
			$business=$this->get('request')->request->get('business');
			$overview=$this->get('request')->request->get('overview');
			$fax=$this->get('request')->request->get('fax');
			$twitter=$this->get('request')->request->get('twitter');
			$facebook=$this->get('request')->request->get('facebook');
			$google=$this->get('request')->request->get('google');
			$linkedin=$this->get('request')->request->get('linkedin');
			$video=$this->get('request')->request->get('video');
			//echo "<pre>";print_r($plan);die();
			$country='US'; // set country USA
			$type=2;
			$status=1;    	
			$pincode=$this->get('request')->request->get('pincode');
			$realtor=new User();
			$realtor->setFirstName($firstname);
			$realtor->setLastName($lastname);
			$realtor->setPassword(md5($password));
			$realtor->setEmail($email);
			$realtor->setPhone($phone);
			$realtor->setState($state);
			$realtor->setAddress($address);
			$realtor->setAddress2($address2);
			$realtor->setCity($city);
			$realtor->setCountry($country);
			$realtor->setType($type);
			$realtor->setStatus($status);
			$realtor->setPinCode($pincode);
			$realtor->setImage($file);
			$realtor->setLogo($logo);
			$realtor->setOverview($overview);
			$realtor->setFax($fax);
			$realtor->setTwitter($twitter);
			$realtor->setFacebook($facebook);
			$realtor->setGoogle($google);
			$realtor->setLinkedin($linkedin);
			$realtor->setVideo($video);	
			$realtor->setBusinessName($business);
			if($plan==1)
			{
			$realtor->setSubscriptionTypeId('NULL');
			}
			else
			{
			$realtor->setSubscriptionTypeId($plan);
			}
			$realtor->setPlanId($planName);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($realtor);
			$em->flush();
			
			$date=date("Y/m/d.");
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <support@review-a-realtor.com>' . "\r\n";
			$to = $email;
			$subject = "New Account Information";
			$txt='Hello '. $firstname.' '. $lastname.',<br><br>Your account has been created with review-a-realtor.com on '.$date.'<br><br>Your Account Details are as under: <br>Email Id: <b>'.	$email.'</b><br>Password: <b>'.	$password.'</b>';
			mail($to,$subject,$txt,$headers); //send mail   
			                   
			return $this->redirect($this->generateUrl('RARAdminBundle_realtor',array('states' => $states,'plans'=>$plans)));		
		}
			return $this->render('RARAdminBundle:Realtor:addRealtor.html.twig',array('states' => $states,'plans'=>$plans));         
	}
 
 	public function suspenedRealtorAction($id)
 	{
 	$em = $this->getDoctrine()->getEntityManager();
  	$suspenedRealtor = $em->createQueryBuilder()
				->select('realtor')
				->update('RARAdminBundle:User',  'realtor')
			//->set('b.status=1')
				->set('realtor.status', ':status')
				->setParameter('status', 2)
				->where('realtor.id=:id')
				->setParameter('id',$id)
				->getQuery()
				->getResult();
				
			return $this->redirect($this->generateUrl('RARAdminBundle_realtor'));		 
 	
 	}
 
 
 
 
 
	/*---- Start - Fetch all states  -----*/ 
	public function getStatesAction()
	{
		$em = $this->getDoctrine()
        ->getEntityManager();
		$states = $em->createQueryBuilder()
		->select('b')
		->from('RARAdminBundle:State',  'b')
		->getQuery()
		->getResult();
		return $states;          
	}
	// function-for-fetching plans
	public function getPlanAction()
	{
		$em = $this->getDoctrine()
        ->getEntityManager();
		$plans = $em->createQueryBuilder()
		->select('b')
		->from('RARAdminBundle:Plan',  'b')
		->getQuery()
		->getResult();
		return $plans;          
	}
	/*---- Start - Fetch all cities  -----*/ 
	public function getCitiesAction(Request $request)
	{   
		if( isset($_POST['stateCode']) && $_POST['stateCode'] != ''  ) 
		{
			$em = $this->getDoctrine()
			->getEntityManager();
			$cities = $em->createQueryBuilder()
			->select('tblCity')
			->from('RARAdminBundle:City',  'tblCity')
			->where('tblCity.state_code=:stateCode')
			->setParameter('stateCode', $_POST['stateCode'])
			->getQuery()
			->getResult();
			//display all cities  
			$html = '';
			foreach($cities as $city)
			{
				$html.='<option value="'.$city->id.'">'.$city->city_name.'</option>';
			}
			return new response($html);
		} 
		else
		{
			$em = $this->getDoctrine()->getEntityManager();
			$cities = $em->createQueryBuilder()
	        ->select('b')
			->from('RARAdminBundle:City',  'b')
			->getQuery()
			->getResult();                   
			return $cities;   
		}
	}
  
  public function claimAction(Request $request)
	{     
		$em = $this->getDoctrine()
		->getEntityManager();
		$claim = $em->createQueryBuilder()
		->select('claim.id, claim.claimed_by,claim.current_owner,claim.type,property.name,claim.property_id,claim.claimed_by,user.first_name,property.user_id')
		->from('RARWebBundle:Claim',  'claim')
		->leftJoin('RARWebBundle:Property', 'property', "WITH", "property.id=claim.property_id")
		->leftJoin('RARAdminBundle:User', 'user', "WITH", "user.id=claim.claimed_by")
		->where('claim.status = 2')
		//->setParameter('userId', $id)
		->getQuery()
		->getArrayResult();
			//echo "<pre>";print_r($claim);die;
				$arrReviewer = array();
				$repository = $em->getRepository('RARAdminBundle:User');
				foreach($claim as $reviewer)
				{
						$reviewId = $reviewer['id'];
						$arrReviewer[$reviewId]['id'] =  $reviewer['id'] ;
						$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
						$arrReviewer[$reviewId]['type'] =  $reviewer['type'] ;
						$arrReviewer[$reviewId]['name'] =  $reviewer['name'] ;
						//$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
						//$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
						$arrReviewer[$reviewId]['user_id'] =  $reviewer['user_id'] ;
						//echo"<pre>";print_r($arrReviewer);die;
						$user = $repository->findOneBy(array('id' =>  $reviewer['user_id']));
						if($user)	
							$realtorName=$user->getFirstName()." ".$user->getLastName();
						else
							$realtorName='';
						$arrReviewer[$reviewId]['realtor_name'] =  $realtorName ;
//	echo "<pre>";print_r($arrReviewer);die;
		
		}
		
		//echo"<pre>";print_r($arrReviewer);die;
		return $this->render('RARAdminBundle:Claim:claim.html.twig',array('claim'=>$arrReviewer));           
	}  

public function acceptedAction($id,Request $request)
{

	$em = $this->getDoctrine()->getEntityManager();
  	$claimDetail = $em->createQueryBuilder()
				->select('User')
				->from('RARAdminBundle:User',  'User')
				->leftJoin('RARWebBundle:Claim', 'claim', "WITH", "User.id=claim.claimed_by")
				->where('claim.id=:id')
				->setParameter('id',$id)
				->getQuery()
				->getArrayResult();
 $firstName= $claimDetail[0]['first_name'];
	$lastName= $claimDetail[0]['last_name'];
	$email= $claimDetail[0]['email'];
	
//echo "<pre>";print_r($claimDetail);die;
		     
	$em = $this->getDoctrine()->getEntityManager();
  	$claimDetail = $em->createQueryBuilder()
				->select('Claim')
				->from('RARWebBundle:Claim',  'Claim')
			->where('Claim.id=:id')
				->setParameter('id',$id)
				->getQuery()
				->getArrayResult();
					

				$date=date("Y/m/d.");
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <support@review-a-realtor.com>' . "\r\n";
				$to = $email;
				//echo $to;die;
				$subject = "Claim Listing";
				$txt='Hello '. $firstName.' '. $lastName.',<br><br>Your Request for claim property is accepted on  '.$date;
    	        mail($to,$subject,$txt,$headers); //send mail   
					//echo $claimDetail[0]['type']."<pre>";print_r($claimDetail);die;	
					
					
  	$updateProperty = $em->createQueryBuilder()
				->select('Property')
				->update('RARWebBundle:Property',  'Property')
			//->set('b.status=1')
				->set('Property.user_id', ':user_id')
				->setParameter('user_id', $claimDetail[0]['claimed_by'])
				->where('Property.id=:id')
				->setParameter('id',$claimDetail[0]['property_id'])
				->getQuery()
				->getResult();
					
		
	
	//$id= $request->request->get('id');
	$status=1;

  	$realtors = $em->createQueryBuilder()
				->select('b')
				->update('RARWebBundle:Claim',  'b')
			//->set('b.status=1')
				->set('b.status', ':status')
				->setParameter('status', $status)
				->where('b.id=:id')
				->setParameter('id',$id)
				->getQuery()
				->getResult();
				
				
  
				//echo'<pre>';print_r($id);die();
return $this->redirect($this->generateUrl('RARAdminBundle_claim'));
}
public function rejectedAction($id,Request $request)
{

	$queryClaim = $this->getDoctrine()->getEntityManager();
  	$claimDetail = $queryClaim->createQueryBuilder()
				->select('User')
				->from('RARAdminBundle:User',  'User')
				->leftJoin('RARWebBundle:Claim', 'claim', "WITH", "User.id=claim.claimed_by")
				->where('claim.id=:id')
				->setParameter('id',$id)
				->getQuery()
				->getArrayResult();

 //$firstName= $claimDetail[0]['first_name'];
	//$lastName= $claimDetail[0]['last_name'];
	//$email= $claimDetail[0]['email'];

		//print_r($request->request->get());die();
	$em = $this->getDoctrine()
	->getEntityManager();
	//$id= $request->request->get('id');
	$status=3;
	$em = $this->getDoctrine()->getEntityManager();
  	$realtors = $em->createQueryBuilder()
				->select('b')
				->update('RARWebBundle:Claim',  'b')
			//->set('b.status=1')
				->set('b.status', ':status')
				->setParameter('status', $status)
				->where('b.id=:id')
				->setParameter('id',$id)
				->getQuery()
				->getResult();
				
				/*
				$date=date("Y/m/d.");
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <support@review-a-realtor.com>' . "\r\n";
				$to = $email;
				//echo $to;die;
				$subject = "Claim Listing";
				$txt='Hello '. $firstName.' '. $lastName.',<br><br>Your Request for claim property is rejected on  '.$date;
    	        mail($to,$subject,$txt,$headers); //send mail   */
				
				//echo'<pre>';print_r($id);die();
return $this->redirect($this->generateUrl('RARAdminBundle_claim'));
}

   	/*---- function of  - Show data of Plan  -----*/ 
	public function planAction(Request $request)
	{     
		$session = $this->getRequest()->getSession();                
		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('RARAdminBundle_login'));
  		}
  		// fetch data of plan
		$em = $this->getDoctrine()->getEntityManager();
		$plans = $em->createQueryBuilder()
		->select('b')
		->from('RARAdminBundle:Plan',  'b')
		->getQuery()
		->getArrayResult();
		return $this->render('RARAdminBundle:Plan:plan.html.twig', array('plans' => $plans));           
	}  
	/*---- Start - Delete data of Plan  -----*/ 
	public function deletePlanAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		// find the id of plan
		$plan = $em->getRepository('RARAdminBundle:Plan')->find($id);
		if (!$plan) 
		{
			throw $this->createNotFoundException('No Plan found for id '.$id);
		}
		// delete the data of plan
		$em->remove($plan);
		$em->flush();
		return $this->redirect($this->generateUrl('RARAdminBundle_plan'));
	}
   
	/*---- function for - Update Plan  -----*/ 
	public function updatePlanAction(Request $request,$id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//find the id of plan
		$plan = $em->getRepository('RARAdminBundle:Plan')->find($id);
		if (!$plan) 
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		$request = $this->getRequest();
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$user = $postData['id'];
		}
			$em = $this->getDoctrine()->getEntityManager();
			$user = $em->getRepository('RARAdminBundle:Plan')->find($id);
			if(!$plan)
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		// update the data of plan
		if($request->getMethod() == 'POST') 
		{
			$name=$this->get('request')->request->get('name');
			$description=$this->get('request')->request->get('description');
			$charges=$this->get('request')->request->get('charges');   
			$charges=$this->get('request')->request->get('charges');
			$chargesHalf=$this->get('request')->request->get('chargesh');
			$chargesYear=$this->get('request')->request->get('chargesy');  			
			$user->setName($name);
			$user->setDescription($description);
			$user->setChargesMonthly($charges);
			$user->setChargesHalfYearly($chargesHalf);
			$user->setChargesYearly($chargesYear);
			$em->persist($user);
				$em->flush();
		return $this->redirect($this->generateUrl('RARAdminBundle_plan'));						
		}
			return $this->render('RARAdminBundle:Plan:planupdate.html.twig', array('plan' => $plan)); 	
	}
 		
 	/*---- function for  - Add new plan  -----*/ 			
 	public function addplanAction(Request $request)
	{
		// add the data of plan with their fields
		if ($request->getMethod() == 'POST') 
 		{
			$name=$this->get('request')->request->get('name');
			$description=$this->get('request')->request->get('description');
			$charges=$this->get('request')->request->get('charges');
			$chargesHalf=$this->get('request')->request->get('chargesh');
			$chargesYear=$this->get('request')->request->get('chargesy');
			$user=new Plan();     			
			$user->setName($name);
			$user->setDescription($description);
			$user->setChargesMonthly($charges);
			$user->setChargesHalfYearly($chargesHalf);
			$user->setChargesYearly($chargesYear);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($user);
			$em->flush();
			return $this->redirect($this->generateUrl('RARAdminBundle_plan'));		
		}
			return $this->render('RARAdminBundle:Plan:addplan.html.twig');
	}

   /*---- Start - Dashboard of Admin  -----*/ 
	public function dashboardAction()
	{
		$session = $this->getRequest()->getSession();
		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_login'));
		}
		//fetch total number of realtors
	  $em = $this->getDoctrine()
    ->getEntityManager();
	  $Realtors = $em->createQueryBuilder()
    ->select('count(c.id) AS totalRealtors')
    ->from('RARAdminBundle:User',  'c')
    ->Where('c.type = 2')
    ->getQuery()
    ->getResult();
    	  $Claims = $em->createQueryBuilder()
    ->select('count(c.id) AS totalClaims')
    ->from('RARWebBundle:Claim',  'c')
    ->where('c.status = 2')
    ->getQuery()
    ->getResult();
    	  $Properties = $em->createQueryBuilder()
    ->select('count(c.id) AS totalProperties')
    ->from('RARWebBundle:Property',  'c')
    ->getQuery()
    ->getResult();
		//fetch total number of categories
    $em = $this->getDoctrine()
    ->getEntityManager();
    $categories = $em->createQueryBuilder()
    ->select('count(c.id) AS totalCategories')
    ->from('RARAdminBundle:Category',  'c')
    ->getQuery()
    ->getResult();
		//fetch total number of plans     
    $em = $this->getDoctrine()
    ->getEntityManager();
		$plans = $em->createQueryBuilder()
    ->select('count(c.id) AS totalPlans')
    ->from('RARAdminBundle:Plan',  'c')
    ->getQuery()
    ->getResult();  
    $reviewer = $em->createQueryBuilder()
    ->select('count(c.id) AS totalReviewer')
    ->from('RARAdminBundle:User',  'c')
    ->where('c .type=3')
    ->getQuery()
    ->getResult();                    
		$dashboardDetails = array('totalRealtors' => $Realtors[0]['totalRealtors'],'totalClaims' => $Claims[0]['totalClaims'], 'totalProperties' => $Properties[0]['totalProperties'],'totalCategories' => $categories[0]['totalCategories'],'totalPlans' => $plans[0]  ['totalPlans'],'totalReviewer' => $reviewer[0]  ['totalReviewer']);			
		return $this->render('RARAdminBundle:Dashboard:dashboard.html.twig', array('dashboardDetails' => $dashboardDetails));    
    
	}

/*---- End - Dashboard of Admin  -----*/ 

   public function propertyAction(Request $request)
	{     
			$session = $this->getRequest()->getSession();           
		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_login'));
		}	 
		// fetch data of realtors
		$em = $this->getDoctrine()->getEntityManager();
		$property = $em->createQueryBuilder()
		->select('b.name,b.description,b.address,b.phone,b.zip,b.video_url,b.price,b.id,b.city,state.state_name,city.city_name')
		->from('RARWebBundle:Property',  'b')
		->leftJoin('RARAdminBundle:State', 'state', "WITH", "b.state=state.state_code")
		->leftJoin('RARAdminBundle:City', 'city', "WITH", "b.city=city.id")
		->getQuery()
		->getArrayResult();		
		return $this->render('RARAdminBundle:Property:property.html.twig',array('property'=>$property));           
	}  

    /*---- function for - add new  Property  -----*/ 
	public function addpropertyAction(Request $request)
	{
		$realtors = $this->getRealtorsAction();
		//echo "<pre>";print_r($realtors);die;
		$states = $this->getStatesAction();
		if ($request->getMethod() == 'POST') 
    		{ 	 	
				$name=$this->get('request')->request->get('name');			
				$description=$this->get('request')->request->get('description');
				$phone=$this->get('request')->request->get('phone');
				$state=$this->get('request')->request->get('state');
				$address=$this->get('request')->request->get('address');
				$city=$this->get('request')->request->get('city');
				$additional=$this->get('request')->request->get('additional');
				$price=$this->get('request')->request->get('price');
				$videourl=$this->get('request')->request->get('videourl');
				$realtors=$this->get('request')->request->get('realtors');
				$zip=$this->get('request')->request->get('zip');
				$property=new Property();
				$property->setName($name);
				$property->setDescription($description);
				$property->setPhone($phone);
				$property->setState($state);
				$property->setAddress($address);
				$property->setAdditionalInformation($additional);
				$property->setCity($city);
				$property->setVideoUrl($videourl);
				$property->setprice($price);
				$property->setZip($zip);
				$property->setUserId($realtors);
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($property);
				$em->flush();
				return $this->redirect($this->generateUrl('RARAdminBundle_property'));			
			}	
		return $this->render('RARAdminBundle:Property:addProperty.html.twig',array('states'=>$states,'realtors'=>$realtors));     
	
	}
	/*---- function for - delete Property  -----*/ 
	public function deletepropertyAction($id)
	{
		$em = $this->getDoctrine()
	    ->getEntityManager();
		$property = $em->getRepository('RARWebBundle:Property')->find($id);
		if (!$property)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove properties from database
		$em->remove($property);
		$em->flush();
		return $this->redirect($this->generateUrl('RARAdminBundle_property'));		
	}
    
    /*---- function for - update data of Plan  -----*/ 
	public function updatepropertyAction(Request $request,$id)
	{
		//get all states
		$states = $this->getStatesAction();
		$realtors = $this->getRealtorsAction();
		//echo "<pre>";print_r($realtors);die;
		$em = $this->getDoctrine()
		->getEntityManager();
		$property = $em->getRepository('RARWebBundle:Property')->find($id);
		if (!$property) 
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$realtor = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$property = $em->getRepository('RARWebBundle:Property')->find($id);
			if(!$property)
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		//update properties 
		if($request->getMethod() == 'POST') 
		{
			$name=$this->get('request')->request->get('name');
			//echo"<pre>";print_r($name);die();
			$description=$this->get('request')->request->get('description');
			$phone=$this->get('request')->request->get('phone');
			$state=$this->get('request')->request->get('state');
			$address=$this->get('request')->request->get('address');
			$city=$this->get('request')->request->get('city');
			$additional=$this->get('request')->request->get('additional');
			$price=$this->get('request')->request->get('price');
			$videourl=$this->get('request')->request->get('videourl');
			$zip=$this->get('request')->request->get('zip');
			$realtors=$this->get('request')->request->get('realtors');
			$property->setName($name);
			$property->setDescription($description);
			$property->setPhone($phone);
			$property->setState($state);
			$property->setAddress($address);
			$property->setAdditionalInformation($additional);
			$property->setCity($city);
			$property->setUserId($realtors);
			$property->setVideoUrl($videourl);
			$property->setprice($price);
			$property->setZip($zip);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($property);
			$em->flush();
			return $this->redirect($this->generateUrl('RARAdminBundle_property'));			
		}

		return $this->render('RARAdminBundle:Property:updateProperty.html.twig',array('states'=>$states,'property'=>$property,'realtors'=>$realtors));     

	}
	
	
	/*---- function for  - Fetch detail of  realtors  -----*/ 
	public function getRealtorsAction()
	{	
		$em = $this->getDoctrine()
		->getEntityManager();
		$realtors = $em->createQueryBuilder()
		->select('b')
		->from('RARAdminBundle:User',  'b')
		->getQuery()
		->getResult();
		return $realtors;          

	}

    /*---- function for  - Fetch images of properties  -----*/ 
	public function imagesAction(Request $request,$id)
	{
	//$images = $this->getImagesAction();
		$em = $this->getDoctrine()
		->getEntityManager();
		$images = $em->createQueryBuilder()
		->select('b')
		->from('RARWebBundle:PropertyImages',  'b')
		->where('b.property_id = :userId')
		->setParameter('userId', $id)
		->getQuery()
		->getResult();
		
		/*---- start  - update images of properties  -----*/ 
		$em = $this->getDoctrine()
		->getEntityManager();
		$property = $em->getRepository('RARWebBundle:Property')->find($id);
		if (!$property) 
		{
			throw $this->createNotFoundException('Unable to find Blog post.');
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$property = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$property = $em->getRepository('RARWebBundle:Property')->find($id);
			if(!$property)
		{
			$property=new Property();
			throw $this->createNotFoundException('No product found for idss '.$id);
		}
		if ($request->getMethod() == 'POST') 
    	{
    	 	$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"Property/" . $_FILES["file"]["name"]);
      		$propertyName=$this->get('request')->request->get('propertyName');
			$realtor=new PropertyImages();			
			$realtor->setPropertyId($id);
			$realtor->setImageUrl($file);	
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($realtor);
			$em->flush();                   
      	}	
		/*---- end - Update images of properties  -----*/ 
		return $this->render('RARAdminBundle:Property:images.html.twig',array('property'=>$property,'images'=>$images)); 

	}

public function deleteImagesAction($id)
	{
	
		$em = $this->getDoctrine()
	    ->getEntityManager();
		$images = $em->getRepository('RARWebBundle:PropertyImages')->find($id);
		if (!$images)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($images);
		$em->flush();
	
		return $this->redirect($this->generateUrl('RARAdminBundle_images'));
	
	
	
	
	}










public function manageCmsAction(Request $request)
	{
	
	$session = $this->getRequest()->getSession();                
		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('RARAdminBundle_login'));
  		}
  		// fetch data of plan
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RARAdminBundle:CMS',  'cms')
		->getQuery()
		->getArrayResult();
	return $this->render('RARAdminBundle:Cms:cms.html.twig',array('cms'=>$cms)); 

	}

public function addCmsAction(Request $request)
	{	
		if($request->getMethod() == 'POST') 
		{
			$file = $_FILES['image']['name'];
		
   			$file1  = $_FILES['image']['tmp_name'];  
    			move_uploaded_file($_FILES["image"]["tmp_name"],
      			"uploads" . $_FILES["image"]["name"]);
			$type=$this->get('request')->request->get('type');
			$name=$this->get('request')->request->get('name');
			$url=$this->get('request')->request->get('url');
			$content=$this->get('request')->request->get('content');
			$cms=new CMS();
			$cms->setName($name);
			$cms->setUrl($url);
			$cms->setType($type);
			$cms->setImage($file);
			$cms->setContent($content);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($cms);
			$em->flush();
		return $this->redirect($this->generateUrl('RARAdminBundle_manageCms'));
	}
	return $this->render('RARAdminBundle:Cms:addCms.html.twig'); 

	}

public function editCmsAction(Request $request,$id)
	{
	
		$em = $this->getDoctrine()
		->getEntityManager();
		$cms = $em->getRepository('RARAdminBundle:CMS')->find($id);
		if (!$cms) 
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$cms = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->getRepository('RARAdminBundle:CMS')->find($id);
			if(!$cms)
		{
		return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		if($request->getMethod() == 'POST') 
		{
			$file = $_FILES['image']['name'];
		
   			$file1  = $_FILES['image']['tmp_name'];  
    			move_uploaded_file($_FILES["image"]["tmp_name"],
      			"uploads" . $_FILES["image"]["name"]);
			$type=$this->get('request')->request->get('type');
			$name=$this->get('request')->request->get('name');
			$name=$this->get('request')->request->get('name');
			$url=$this->get('request')->request->get('url');
			$content=$this->get('request')->request->get('content');
			$cms->setName($name);
			$cms->setType($type);
			$cms->setImage($file);
			$cms->setUrl($url);
			$cms->setContent($content);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($cms);
			$em->flush();
			return $this->redirect($this->generateUrl('RARAdminBundle_manageCms'));
		}

	return $this->render('RARAdminBundle:Cms:editcms.html.twig',array('cms'=>$cms)); 

	}

public function deleteCmsAction($id)
	{
	$em = $this->getDoctrine()
	    ->getEntityManager();
		$cms = $em->getRepository('RARAdminBundle:CMS')->find($id);
		if (!$cms)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($cms);
		$em->flush();
	
		return $this->redirect($this->generateUrl('RARAdminBundle_manageCms'));

	}
	
	public function viewCmsAction($id)
	{

		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RARAdminBundle:CMS',  'cms')
		->where('cms.id=:cmsId')
		->setParameter('cmsId', $id)
		->getQuery()
		->getResult();
	//echo"<pre>";print_r($cms);die();
return $this->render('RARAdminBundle:Cms:viewCms.html.twig',array('cms'=>$cms)); 

	}
	
	/*
public function importRealtorsAction(Request $request)
{
$session = $this->getRequest()->getSession();
		$loggedInUserId = $session->get('userId') ;
		$currentTimestamp = new DateTime();
		
		if ($request->getMethod() == 'POST') 
    	{
    	
    	//echo $_FILES['file']['type'];die();
    	if (!($_FILES['file']['type'] == "text/comma-separated-values") && !($_FILES['file']['type'] == "application/vnd.ms-excel"))
				{
				$error ='Wrong file selected';
				return $this->render('RARAdminBundle:Realtor:importRealtors.html.twig',array('error'=>$error)); 
				}
				
				elseif ($_FILES["file"]["error"] > 0) 
				{
				return $this->render('RARAdminBundle:Realtor:importRealtors.html.twig',array('error'=>$error)); 
				}	
				
				else
				{
					if (is_uploaded_file($_FILES['file']['tmp_name'])) {
				//readfile($_FILES['file']['tmp_name']);
					}
					$handle = fopen($_FILES['file']['tmp_name'], "r");

			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{
					$firstName=$data[0];
					$lastName=$data[1];
					$email=$data[2];
					$password=$data[3];
					$phone=$data[4];
					$address=$data[5];
					$address2=$data[6];
					$city=$data[7];
					$state=$data[8];
					$country=$data[9];
					$pincode=$data[10];
					$fax=$data[11];
					$business=$data[12];
					$overview=$data[13];
					$twitter=$data[14];
					$google=$data[15];
					$linkedin=$data[16];
					$video=$data[17];
					$facebook=$data[18];
					
					$realtor=new User();
					$realtor->setFirstName($firstName);
					$realtor->setLastName($lastName);
					$realtor->setEmail($email);
					$realtor->setPassword(md5($password));
					$realtor->setPhone($phone);
					$realtor->setAddress($address);
					$realtor->setAddress2($address2);
					$realtor->setCity($city);
					$realtor->setState($state);
					$realtor->setCountry($country);
					$realtor->setPinCode($pincode);
					$realtor->setFax($fax);
					$realtor->setBusinessName($business);
					$realtor->setOverview($overview);
					$realtor->setTwitter($twitter);
					$realtor->setGoogle($google);
					$realtor->setLinkedin($linkedin);
					$realtor->setFacebook($facebook);
					$realtor->setVideo($video);
					
					$realtor->setType(2);
					$realtor->setPlanId(1);	
					$realtor->setStatus(1);
					$realtor->setCreatorId($loggedInUserId);
					$realtor->setModifierId($loggedInUserId);	
					$realtor->setCreationTimestamp($currentTimestamp);
					$realtor->setModificationTimestamp($currentTimestamp);		
					
					$em = $this->getDoctrine()->getEntityManager();
					$em->persist($realtor);
					$em->flush();

 					return $this->redirect($this->generateUrl('RARAdminBundle_realtor'));
					}
					fclose($handle);

//print "Import done";
    	}
    	}

 
 
return $this->render('RARAdminBundle:Realtor:importRealtors.html.twig'); 
}
 */
 	public function importRealtorsAction(Request $request)
	{
		ini_set('max_execution_time', 10000000); 
		$session = $this->getRequest()->getSession();
		$loggedInUserId = $session->get('userId') ;
		$currentTimestamp = new DateTime();
			
		if ($request->getMethod() == 'POST') 
    		{
    	
    			//echo $_FILES['file']['type'];die();
    			/*if (!($_FILES['file']['type'] == "text/comma-separated-values") && !($_FILES['file']['type'] == "application/vnd.ms-excel"))
			{
				$error ='Wrong file selected';
				return $this->render('RARAdminBundle:Realtor:importRealtors.html.twig',array('error'=>$error)); 
			}
			else
			{*/
				//echo"<pre>";print_r($_FILES);die;
				if (is_uploaded_file($_FILES['file']['tmp_name'])) 
				{
					//readfile($_FILES['file']['tmp_name']);
				}
				$handle = fopen($_FILES['file']['tmp_name'], "r");
			
				/*$i=0;
				while (($data = fgetcsv($handle, 10000000, ";")) !== FALSE) 
				{
					$arrFile[] = $data;
					$i++;
					if($i>50)
						break;
				}
				echo "<PRE>";print_r($arrFile);die;*/

				$stateCode = '';
				$cityName = '';	
				$companyName = '';
				$phone = '';	
				$businessUrl = '';
				$address = '';	
				$zipCode = '';
				$stateName = '';	
				$category1 = '';
				$category2 = '';	


				while (($data = fgetcsv($handle, 10000000, ";")) !== FALSE) 
				{
				$data = explode(';',$data[0]);
					if(isset($data[0]))
						$stateCode	=	ltrim($data[0]);
					if(isset($data[1]))
						$cityName	=	ltrim($data[1]);
					if(isset($data[2]))
						$companyName	=	ltrim($data[2]);
					if(isset($data[3]))
						$phone		=	ltrim($data[3]);
					if(isset($data[4]))
						$businessUrl	=	ltrim($data[4]);
					if(isset($data[5]))
						$address	=	ltrim($data[5]);
					if(isset($data[6]))
						$zipCode	=	ltrim($data[6]);
					if(isset($data[7]))
						$stateName	=	ltrim($data[7]);
					if(isset($data[8]))
						$category1	=	ltrim($data[8]);
					if(isset($data[9]))
						$category2	=	ltrim($data[9]);
					
					$em = $this->getDoctrine()->getEntityManager();
					$city = $em->createQueryBuilder()
					->select('City')
					->from('RARAdminBundle:City', 'City')
					->where('City.city_name = :cityName')
					->setParameter('cityName', $cityName)
					->getQuery()
					->getArrayResult();
					//echo $cityName."<PRE>";print_r($data);die;
					$cityId = $city[0]['id'];
					$country = 'US';

					$arrCat = explode(',,,,,', $category2);
					$category2 = $arrCat[0];

					$realtor=new User();

					$realtor->setState($stateCode);
					$realtor->setCity($cityId);
					$realtor->setBusinessName($companyName);
					$realtor->setPhone($phone);
					$realtor->setBusinessUrl($businessUrl);
					$realtor->setAddress($address);
					$realtor->setPinCode($zipCode);
					//$realtor->setStateName($stateName);
					$realtor->setCountry($country);
					$realtor->setCategory1($category1);
					$realtor->setCategory2($category2);
					
					$realtor->setImage('default_user_image.jpeg');
					$realtor->setLogo('company.jpeg');
					$realtor->setType(2);
					$realtor->setPlanId(1);	
					$realtor->setStatus(1);
					$realtor->setCreatorId($loggedInUserId);
					$realtor->setModifierId($loggedInUserId);	
					$realtor->setCreationTimestamp($currentTimestamp);
					$realtor->setModificationTimestamp($currentTimestamp);		
					
					$em = $this->getDoctrine()->getEntityManager();
					$em->persist($realtor);
					$em->flush();
				}
				fclose($handle);
			//}
    		}
		return $this->render('RARAdminBundle:Realtor:importRealtors.html.twig'); 
	}

public function manageAdvertiesmentAction(Request $request)
{
$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->createQueryBuilder()
		->select('adv')
		->from('RARAdminBundle:Advertiesment',  'adv')
		->getQuery()
		->getResult();
return $this->render('RARAdminBundle:Advertiesment:advertiesment.html.twig',array('adv'=>$adv)); 

}

public function addAdvertiesmentAction(Request $request)
{


if($request->getMethod() == 'POST') 
		{
		
			$file = $_FILES['image']['name'];
   			$file1  = $_FILES['image']['tmp_name'];  
    		move_uploaded_file($_FILES["image"]["tmp_name"],
      		"uploads/" . $_FILES["image"]["name"]);
			$title=$this->get('request')->request->get('title');
			$type=$this->get('request')->request->get('type');
			$description=$this->get('request')->request->get('description');
			$targetUrl=$this->get('request')->request->get('targetUrl');
			$adv=new Advertiesment();
			$adv->setTitle($title);
			$adv->setType($type);
			$adv->setImage($file);
			$adv->setDescription($description);
			$adv->setTargetUrl($targetUrl);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($adv);
			$em->flush();
		return $this->redirect($this->generateUrl('RARAdminBundle_advertiesment'));
	}

return $this->render('RARAdminBundle:Advertiesment:addAdvertiesment.html.twig'); 
}

public function editAdvertiesmentAction(Request $request,$id)
{

		$em = $this->getDoctrine()
		->getEntityManager();
		$adv = $em->getRepository('RARAdminBundle:Advertiesment')->find($id);
		if (!$adv) 
		{
	return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$adv = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->getRepository('RARAdminBundle:Advertiesment')->find($id);
			if(!$adv)
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_error'));			
		}
		//update realtors information
		if($request->getMethod() == 'POST') 
		{
				$hidadv=$this->get('request')->request->get('hidAdv');
			$file = $_FILES['image']['name'];
   			$file1  = $_FILES['image']['tmp_name'];  
    		move_uploaded_file($_FILES["image"]["tmp_name"],
      		"Property/" . $_FILES["image"]["name"]);
      		$type=$this->get('request')->request->get('type');
			$title=$this->get('request')->request->get('title');
			$description=$this->get('request')->request->get('description');
			$targetUrl=$this->get('request')->request->get('targetUrl');
			$adv->setTitle($title);
		  $adv->setType($type);
		  if($file == "")
		  {
				$adv->setImage($hidadv);
			}
			else
			{
				$adv->setImage($file);
			}
			$adv->setDescription($description);
			$adv->setTargetUrl($targetUrl);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($adv);
			$em->flush();
	
		return $this->redirect($this->generateUrl('RARAdminBundle_advertiesment'));
}

return $this->render('RARAdminBundle:Advertiesment:updateAdvertiesment.html.twig',array('adv'=>$adv)); 

}
public function deleteAdvertiesmentAction($id)
{
			$em = $this->getDoctrine()
	    ->getEntityManager();
		$adv = $em->getRepository('RARAdminBundle:Advertiesment')->find($id);
		if (!$adv)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($adv);
		$em->flush();
	
		return $this->redirect($this->generateUrl('RARAdminBundle_advertiesment'));

}
public function getCsvAction()
{
$output = "";
$em = $this->getDoctrine()
    ->getEntityManager();
	  $Realtors = $em->createQueryBuilder()
    ->select('c')
    ->from('RARAdminBundle:User',  'c')
    ->getQuery()
    ->getArrayResult();
    


	  $em = $this->getDoctrine()
    ->getEntityManager();
	  $Realtors1 = $em->createQueryBuilder()
    ->select('count(c.id)')
    ->from('RARAdminBundle:User',  'c')
    ->getQuery()
    ->getArrayResult();
    
    $Realtors1 = $Realtors1[0][1];

	//echo "<PRE>";print_r($Realtors);
	//echo "<PRE>";print_r($Realtors1);
	//die;
	$headings = array_keys($Realtors[0]);
	//echo "<PRE>";print_r($headings);die;
	for ($i = 0; $i < count($headings); $i++) 
	{
		$heading = $headings[$i];
		$output .= '"'.$heading.'",';
	}
	//echo $output;die;
	$output .="\n";
	
	for ($realtorCounter = 0; $realtorCounter < count($Realtors); $realtorCounter++) 
	{
		for ($i = 0; $i < count($headings); $i++) 
		{
			if( $headings[$i] == "creation_timestamp" || $headings[$i] == "modification_timestamp" )
			{
				$dateTime = $Realtors[$realtorCounter][$headings[$i]]->format('Y-m-d_H:i:s');
				if( $dateTime< 0 )
					$output .='"N.A.",';
				else
					$output .='"'.$dateTime.'",';
			}
			else
			{
				$output .='"'.$Realtors[$realtorCounter][$headings[$i]].'",';
			}
		}
		$output .="\n";
	}
	
// Download the file

$currentDateTime = date('Y-m-d_H:i:s');
$filename = "Realtors_".$currentDateTime.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
	
	return $this->redirect($this->generateUrl('RARAdminBundle_realtor'));

}
public function getPdfAction()
{
  
 $webRoot = $this->container->get('kernel')->getRootDir();
 $kpath= $webRoot."/pdf/fpdf.php";
 require_once($kpath);

$pdf =new FPDF();
$pdf->AddPage();
var_dump (get_class_methods($pdf));die;
$pdf->SetFont("Arial","B","20");

$pdf->Output();

//echo"<pre>";print_r($pdf);die;







	return $this->redirect($this->generateUrl('RARAdminBundle_realtor'));

}


/*public function getAdvertiesmentAction()
{
		$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->createQueryBuilder()
		->select('adv')
		->from('RARAdminBundle:Advertiesment',  'adv')
		->where('adv.type=:type')
		->setParameter('type',"ADV")
		->getQuery()
		->getResult();
return $adv;
}
public function getBannerAction()
{
		$em = $this->getDoctrine()->getEntityManager();
		$ban = $em->createQueryBuilder()
		->select('adv')
		->from('RARAdminBundle:Advertiesment',  'adv')
		->where('adv.type=:type')
		->setParameter('type',"BAN")
		->getQuery()
		->getResult();
return $ban;
}

*/
public function manageReviewerAction(Request $request)
{
$em = $this->getDoctrine()->getEntityManager();
		$rev = $em->createQueryBuilder()
		->select('rev')
		->from('RARAdminBundle:User',  'rev')
		->where('rev.type=3')
		->getQuery()
		->getResult();
return $this->render('RARAdminBundle:Reviewer:reviewer.html.twig',array('rev'=>$rev)); 

}
public function deleteReviewerAction($id)
{
			$em = $this->getDoctrine()
	    ->getEntityManager();
		$rev = $em->getRepository('RARAdminBundle:User')->find($id);
		if (!$rev)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($rev);
		$em->flush();
	
		return $this->redirect($this->generateUrl('RARAdminBundle_reviewer'));


}

public function AdminChangePasswordAction(Request $request)
{
		$session = $this->getRequest()->getSession();           
		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('RARAdminBundle_login'));
		}	 
		$em = $this->getDoctrine()
	   	 ->getEntityManager();
		$repository = $em->getRepository('RARAdminBundle:User');
		if ($request->getMethod() == 'POST')
	 	{
	   	$changePassword= md5($request->get('changePassword'));
	   	$newPassword=md5($request->get('newPassword'));
      $user = $repository->findOneBy(array('password' => $newPassword,'type'=>1,'status'=>1));
				
		if($user)
		{
		$em = $this->getDoctrine()->getEntityManager();
		$changePass = $em->createQueryBuilder()
				->select('change')
				->update('RARAdminBundle:User',  'change')
				->set('change.password', ':password')
				->setParameter('password', $newPassword)
				->where('change.id=:userId')
				->setParameter('userId',$session->get('userId'))
				->getQuery()
				->getResult();
		
		}
		else
		{
		$wrongDetail = 'Wrong Password Detail';
		return $this->render('RARAdminBundle:Realtor:changePassword.html.twig',array('wrongDetail'=>$wrongDetail)); 
		}
		
		
}


return $this->render('RARAdminBundle:Realtor:changePassword.html.twig'); 

}



}	
