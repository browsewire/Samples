<?php
namespace RAR\WebBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RAR\AdminBundle\Entity\User;
use RAR\AdminBundle\Entity\Plan;
use RAR\WebBundle\Entity\Requests;
use RAR\AdminBundle\Modals\Login;
use RAR\WebBundle\Entity\Review;
use RAR\WebBundle\Entity\Property;
use RAR\WebBundle\Entity\Claim;
use RAR\WebBundle\Entity\Payment;
use RAR\WebBundle\Entity\PropertyImages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class RealtorController extends Controller
{   

	/*----Start function - Realtor Login  -----*/
	public function loginAction(Request $request)
    {    
	    //get the value of session
    	$session = $this->getRequest()->getSession();  	
       	if( $session->get('userId') && $session->get('userId') != '' )
  		{
				//return $this->redirect($this->generateUrl('rar_web_homepage'));
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
            $user = $repository->findOneBy(array('email' => $email, 'password' => $password,'type'=>array(2,3) ,'status'=>1));	
            //echo'<pre>';print_r($user);die();
        	if ($user) 
        	{
            	if(isset($_POST["remember"])) 
            	{
					$response = new Response();
					$response->headers->setCookie(new Cookie('email', $email, 0, '/', null, false, false)); 
					$response->headers->getCookies();
					//secho $response;die();
				}     //  echo"<pre>";print_r( $user);die;
							$session->set('userId', $user->getId()); 
							$session->set('realtorName', $user->getFirstName());
          		$session->set('planId', $user->getPlanId()); 
          		$session->set('userEmail', $user->getEmail());
          	 	$session->set('userType', $user->getType());
          	//$a = 	$user->getPlanId();
          	
          	 	if($user->getType()==3)
          			return $this->redirect($this->generateUrl('rar_web_homepage'));
          	 	else                                        
   					return $this->redirect($this->generateUrl('rar_web_home',array('id'=>$session->get('userId'),'name'=>$session->get('realtorName'))));   						 
       		} 
        	else 
        	{
				return $this->render('RARWebBundle:Page:login.html.twig', array('name' => 'Invalid Email/Password'));
        	}
		}
		return $this->render('RARWebBundle:Page:login.html.twig');
	}
    /*----End function - Realtor Login  -----*/
    

    /*---- Start function - Realtor Logout  -----*/
	public function logoutAction(Request $request) 
	{   
    	$session = $this->getRequest()->getSession();
		//destroy the value of session
		$session->remove('userEmail');
        $session->clear();
        return $this->render('RARWebBundle:Page:login.html.twig');
    }
    /*----End function - Realtor Login  -----*/
  
	/*---- Start function - fetching all realtors  -----*/	
	public function getRealtorsAction()
	{
	$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}  
		$em = $this->getDoctrine()
		->getEntityManager();
		$realtors = $em->createQueryBuilder()
		->select('User')
		->from('RARAdminBundle:User',  'User')
		->where('User.id = :userId')
		->setParameter('userId', $session->get('userId'))
		->getQuery()
		->getResult();
		return $realtors;          

	}
	/*----End function - fetching all realtors   -----*/


	/*---- Start function for - show the  selected plan  of realtor  -----*/	
    public function managePlanAction(Request $request)
    {
    	$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}  
     	$em = $this->getDoctrine()->getEntityManager();
     	$plans = $em->createQueryBuilder()
		->select("Plan.name,Plan.description")
		->from("RARAdminBundle:User", "User")
		->innerJoin('RARAdminBundle:Plan', 'Plan', "WITH", "Plan.id=User.plan_id")
		->where('User.id = :userId')
		->setParameter('userId', $session->get('userId'))
		->getQuery()
		->getArrayResult();  
		$planss = $em->createQueryBuilder()
		->select("f.description")
		->from("RARAdminBundle:User", "User")
		->innerjoin('RARWebBundle:Features','f', "WITH", "f.code=User.plan_id")
		->where('User.id = :userId')
		->setParameter('userId', $session->get('userId'))
		->getQuery()
		->getArrayResult();  	 	
		return $this->render('RARWebBundle:Page:managePlan.html.twig',array('plans'=>$plans, 'planss'=>$planss)); 	
    
    }
    /*---- End function for - show the  selected plan  of realtor  -----*/

    /*---- function for  - show rating to realtors  -----*/
	public function feedbackAction(Request $request)
    	{  
          
       		$session = $this->getRequest()->getSession();                
       		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		} 
  		
  		$em = $this->getDoctrine()->getEntityManager();
     		$review = $em->createQueryBuilder()
   		 ->select("rev.sender,rev.id,rev.reviewer_id,rev.parent_id,rev.realtor_id,user.first_name,user.plan_id,user.last_name,rev.description,rev.status,rev.rating")
		->from("RARWebBundle:Review", "rev")
		->leftJoin('RARAdminBundle:User', 'user', "WITH", "user.id=rev.reviewer_id")
		->where('rev.realtor_id = :realtodId')
		//->andwhere('rev.status = 2')
		->setParameter('realtodId', $session->get('userId'))
		->getQuery()
		->getArrayResult(); 
		
		//echo"<pre>";print_r($review);die;
		$reviewDisable = $em->createQueryBuilder()
    		->select("user.plan_id")
		->from("RARAdminBundle:User", "user")
		->where('user.id = :realtodId')
		->setParameter('realtodId', $session->get('userId'))
		->getQuery()
		->getArrayResult(); 
		
		
    	$em = $this->getDoctrine()
        ->getEntityManager();
        $sender='REALTOR';
       	$reviewz = $em->createQueryBuilder()
		->select('review.id, review.parent_id, count(review.id) AS totalReview')
		->from('RARWebBundle:Review',  'review')
		->where('review.realtor_id = :realtodId')
		->andWhere('review.sender = :sender')
		->setParameter('sender', $sender)
		->setParameter('realtodId', $session->get('userId'))
		->groupBy('review.parent_id')		
	    ->getQuery()
	    ->getResult();
        $totalReviews = 0;
	
	$newRev = array();
	
	foreach($review as $rev)
	{
		$arrReply = array('replies'=>'0');
		foreach($reviewz as $revz)
		{
			if($rev['id'] == $revz['parent_id'])
				$arrReply['replies'] = $revz['totalReview'];
		}
		$newRev[] = array_merge($rev, $arrReply);	
	}

	//echo "<PRE>";print_r($newRev);echo "<PRE>";print_r($reviewz);die;

	$review = $newRev;
		return $this->render('RARWebBundle:Page:feedbacks.html.twig',array("review"=>$review,'totalReviews'=>$totalReviews,"reviewDisable"=>$reviewDisable));
	}
	/*---- End function for - show the rating of realtor  -----*/

	/*---- function  - reply the feedback-----*/	
	public function replyAction(Request $request)
	{
		$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
			return $this->redirect($this->generateUrl('rar_web_login'));
  		}    
	
		if ($request->getMethod() == 'POST') 
        {	
          	
        	$reply=$this->get('request')->request->get('reply');
        	$parentId=$this->get('request')->request->get('hidParentId');
        	$reviewerId=$this->get('request')->request->get('hidReviewerId');		
       		$review=new Review();
       		$review->setDescription($reply);
       		$review->setRealtorId($session->get('userId'));
       		$review->setReviewerId($reviewerId);
       		$review->setParentId($parentId);
       		$review->setStatus(1);
       		$review->setSender("REALTOR");
       		$em = $this->getDoctrine()->getEntityManager();
			$em->persist($review);
			$em->flush();       
        }
		return $this->redirect($this->generateUrl('rar_web_feedback',array('name'=>$session->get('realtorName'),'id'=>$session->get('userId'))));

	}
	/*---- End function for - reply feedback  -----*/

    /*----  - show Business listing of realtor detail  -----*/
	public function manageListingAction(Request $request)
    {
    	$session = $this->getRequest()->getSession();                  
      	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		$em = $this->getDoctrine()->getEntityManager();
		$realtors = $em->createQueryBuilder()
		->select('User.overview,User.business_name,User.fax,User.first_name,User.last_name,User.email,User.address,User.address2,User.pincode,User.country,User.phone,User.id,User.city, User.image,User.logo,state.state_name,city.city_name,User.plan_id')
		->from('RARAdminBundle:User',  'User')
		->leftJoin('RARAdminBundle:State', 'state', "WITH", "User.state=state.state_code")
		->leftJoin('RARAdminBundle:City', 'city', "WITH", "User.city=city.id")
		->where('User.id = :userId')
		->setParameter('userId', $session->get('userId'))
		->getQuery()
		->getArrayResult(); 

		return $this->render('RARWebBundle:Page:manageListing.html.twig',array('realtors'=>$realtors));
	}
    /*---- End function for - Business Listing  of realtor  -----*/

    /*---- Start - homepage of realtor login  -----*/
	public function dashboardAction(Request $request)
    {
		$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}    
    	$em = $this->getDoctrine()
        ->getEntityManager();
	  	$properties = $em->createQueryBuilder()
	    ->select('count(Property.id) AS totalProperties')
	    ->from('RARWebBundle:Property',  'Property')
	    ->where('Property.user_id = :userId')
	
		->setParameter('userId', $session->get('userId'))
	    ->getQuery()
	    ->getResult();
	   // echo "<pre>";print_r($properties);die;
    	$em = $this->getDoctrine()
	    ->getEntityManager();
		 $review = $em->createQueryBuilder()
	    ->select('count(Review.id) AS totalreview')
	    ->from('RARWebBundle:Review',  'Review')
	    ->where('Review.reviewer_id = :userId')
 	   ->andwhere('Review.sender = :sender')
	->setParameter('sender', 'REVIEWER')
	   // ->andWhere('Review.status= 1')
			->setParameter('userId', $session->get('userId'))
	    ->getQuery()
        ->getResult();
 //  echo "<pre>";print_r($review);die;
        $dashboardDetails = array('totalProperties' => $properties[0]['totalProperties'],'totalreview' => $review[0]['totalreview']);				
    	return $this->render('RARWebBundle:Page:dashboard.html.twig',array('dashboardDetails'=>$dashboardDetails));
    }
    /*---- End function for - homepage of realtor  -----*/

    /*---- Start - change plan of realtor  -----*/  
    public function changePlanAction(Request $request)  
    {   

   		$plans = $this->getPlanAction();
   	 	$em = $this->getDoctrine()
    	->getEntityManager();
		$repository = $em->getRepository('RARAdminBundle:User');
		$user = $repository->findOneBy(array());	
  		$session = $this->getRequest()->getSession();                  
   		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('rar_web_login'));
		}
	   
    	return $this->render('RARWebBundle:Page:changePlan.html.twig',array('plans'=>$plans,'name' => $user->getFirstName(),'userPlanId' => $user->getPlanId()));
    }
    /*---- End function for - change plan  of realtor  -----*/

/*---- Start - fetching all plans  -----*/	
	public function getPlanAction()
	{
		$em = $this->getDoctrine()
		->getEntityManager();
		$plans = $em->createQueryBuilder()
		->select('Plan')
		->from('RARAdminBundle:Plan',  'Plan')
		->getQuery()
		->getResult();
		return $plans;          

	}
	/*---- End function for - show the  fetching plans  of realtor  -----*/ 
  	
  	/*---- Start - Fetch all states  -----*/ 
	public function getStatesAction()
	{
		$em = $this->getDoctrine()
		->getEntityManager();
		$states = $em->createQueryBuilder()
		->select('State')
		->from('RARAdminBundle:State',  'State')
		->getQuery()
		->getResult();
		return $states;          

	}
	/*---- End function for - show the states -----*/

  	/*---- Start - Fetch  city based on selected state  -----*/ 
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
			->select('City')
			->from('RARAdminBundle:City',  'City')
			->getQuery()
			->getResult();                   
			return $cities;   
		}
	}
	/*---- End - Fetch  city based on selected state  -----*/ 
    
    /*---- Start - fetching all features of plans  -----*/
    public function getFeaturesAction()
	{
       if( isset($_POST['planId']) && $_POST['planId'] != ''  ) 
		{
			$em = $this->getDoctrine()
			->getEntityManager();
			$features = $em->createQueryBuilder()
			->select('tblFeatures')
			->from('RARWebBundle:Features',  'tblFeatures')
			->where('tblFeatures.code=:id')
			->setParameter('id', $_POST['planId'])
			->getQuery()
			->getResult();
			$html = '<ul>';
			foreach($features as $feature)
			{   
			    // show the features of plan
				$html.='<li class="customList">'.$feature->description.'.<br></li>';
			}
			$html.='</ul>';
			return new response($html);
		} 
		else
		{
			$em = $this->getDoctrine()->getEntityManager();
			$features = $em->createQueryBuilder()
			->select('Features')
			->from('RARWebBundle:Features',  'Features')
			->getQuery()
			->getResult();                   
			return $features;   
		}
    }
    /*---- End - Fetching  city based on selected state  -----*/ 
	    
	/*---- Start - fetching description of plans  -----*/    
	public function getDescriptionAction()
	{
       if( isset($_POST['planId']) && $_POST['planId'] != ''  ) 
		{
			$em = $this->getDoctrine()
			->getEntityManager();
			$plan = $em->createQueryBuilder()
			->select('tblPlan')
			->from('RARAdminBundle:Plan',  'tblPlan')
			->where('tblPlan.id=:id')
			->setParameter('id', $_POST['planId'])
			->getQuery()
			->getResult();  
			$html = '';
			foreach($plan as $plan)
			{
				$html.=$plan->description.'.<br>';
			}
			return new response($html);
		} 
		else
		{
			$em = $this->getDoctrine()->getEntityManager();
			$plan = $em->createQueryBuilder()
			->select('Plan')
			->from('RARAdminBundle:Plan',  'Plan')
			->getQuery()
			->getResult();                   
			return $plan;   
			
		}
  
	}
	/*---- End -  fetching description of plans  -----*/ 
	
	/*---- Start - forgot password of realtor login  -----*/
    public function forgotPasswordAction(Request $request)
    {
		$gbl_email_support = $this->container->getParameter('gbl_email_support');
		$email=$this->get('request')->request->get('email');
		$em = $this->getDoctrine()
		->getEntityManager();
		$repository = $em->getRepository('RARAdminBundle:User');
		if ($request->getMethod() == 'POST') 
        {   
		    //checks the value of email and type
           	$user = $repository->findOneBy(array('email' => $email,'type'=>array(2,3)));
           	if ($user) 
           	{
               $newPassword=rand(100000,'999999');
               //echo $newPassword;
               $encPass=md5($newPassword);
               $realtors = $em->createQueryBuilder()
				->select('User')
				->update('RARAdminBundle:User',  'User')
				->set('User.password', ':password')
				->setParameter('password', $encPass)
				->where('User.email=:email')
				->setParameter('email', $email)
				->getQuery()
				->getResult();
				//genrate random number													
				
				//password is encrypted into md5 
				$encPass=md5($newPassword); 
				$firstname=$user->getFirstName();
				$lastname=$user->getLastName();
				/*$date=date("Y/m/d.");
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <support@review-a-realtor.com>' . "\r\n";
				$to = $email;
				$subject = "Password Reset";
				$txt='Hello '. $user->getFirstName().' '. $user->getLastName().',<br><br>Your password has been reset on '.$date.'<br><br>Your new Password is: 							<b>'.	$newPassword.'</b>';
    	        mail($to,$subject,$txt,$headers); //send mail  */
					$message = \Swift_Message::newInstance()
            				->setSubject('Password Reset')
            				->setFrom($gbl_email_support)
            				->setTo($email)
            				->setBody($this->renderView('RARWebBundle:Email:passwordReset.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'password'=>$newPassword)));
					$this->get('mailer')->send($message);
              
             	return $this->render('RARWebBundle:Page:confirm.html.twig',array('name' => $email));
            } 
            else 
            {
                return $this->render('RARWebBundle:Page:forgotPassword.html.twig', array('name1' => 'Invalid Email'));
            }
		}
 		return $this->render('RARWebBundle:Page:forgotPassword.html.twig');
	}
  	/*---- End - forgot password of realtor login  -----*/

   	/*---- Start - editing information OF REALTOR -----*/
   public function editListingAction(Request $request)
    {
  		$states = $this->getStatesAction();
    	$realtors = $this->getRealtorsAction();
     
     	$session = $this->getRequest()->getSession();                
    	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		if ($request->getMethod() == 'POST') 
        {   
			 $firstname=$this->get('request')->request->get('firstname');
			 $lastname=$this->get('request')->request->get('lastname');
			 $email=$this->get('request')->request->get('email');
			 $phone=$this->get('request')->request->get('phone');
			 $address=$this->get('request')->request->get('address');
			 $address2=$this->get('request')->request->get('address2');
			 $pin=$this->get('request')->request->get('pin');
			 $company=$this->get('request')->request->get('company');
			 $overview=$this->get('request')->request->get('overview');
			 $fax=$this->get('request')->request->get('fax');
			 $state=$this->get('request')->request->get('state');
			 $city=$this->get('request')->request->get('city');
			 $em = $this->getDoctrine()
			->getEntityManager();
       		$realtors = $em->createQueryBuilder()
			->select('User')
			->update('RARAdminBundle:User',  'User')
			->set('User.first_name', ':firstname')
			->set('User.last_name', ':lastname')
			->set('User.email', ':email')
			->set('User.phone', ':phone')
			->set('User.address', ':address')
			->set('User.address2', ':address2')
			->set('User.pincode', ':pin')
			->set('User.business_name', ':business')
			->set('User.overview', ':overview')
			->set('User.fax', ':fax')
			->set('User.state', ':state')
			->set('User.city', ':city')
			->setParameter('state', $state)
			->setParameter('city', $city)
			->setParameter('business', $company)
			->setParameter('overview', $overview)
			->setParameter('fax', $fax)
			->setParameter('pin', $pin)
			->setParameter('address2', $address2)
			->setParameter('address', $address)
			->setParameter('email', $email)
			->setParameter('firstname', $firstname)
			->setParameter('lastname', $lastname)
			->setParameter('phone', $phone)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();  
    		return $this->redirect($this->generateUrl('rar_web_manageListing'));	
		} 
    	return $this->render('RARWebBundle:Page:editListing.html.twig',array('realtors'=>$realtors,'states'=>$states));
    }
 	/*---- Start -  editing information OF REALTOR  -----*/

    /*---- Start - change image of realtor-----*/ 
    public function changeImageAction(Request $request)
    {
		$images = $this->getImageAction();
 		$em = $this->getDoctrine()
    	->getEntityManager();
		$session = $this->getRequest()->getSession();                
    	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		if ($request->getMethod() == 'POST') 
        {   
        $hidimage=$this->get('request')->request->get('hidImage');  
   
     		$file = $_FILES['file']['name'];
     	
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"uploads/" . $_FILES["file"]["name"]);
        
  			if($file == "")
  			{
     		$em = $this->getDoctrine()
			->getEntityManager();
       		$realtors = $em->createQueryBuilder()
			->select('User')
			->update('RARAdminBundle:User',  'User')
			->set('User.image', ':image')
			->setParameter('image', $hidimage)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();
			}
			else
			{
				$em = $this->getDoctrine()
			->getEntityManager();
       		$realtors = $em->createQueryBuilder()
			->select('User')
			->update('RARAdminBundle:User',  'User')
			->set('User.image', ':image')
			->setParameter('image', $file)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();
			
			}
			return $this->redirect($this->generateUrl('rar_web_manageListing'));	    	
    	}
     	return $this->render('RARWebBundle:Page:changeImage.html.twig',array('images'=>$images));
    }
    /*---- End - change image of realtor-----*/ 
    
    /*---- Start - fetching Images -----*/
    public function getImageAction()
	{
	 	$session = $this->getRequest()->getSession();          
	  	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
		$em = $this->getDoctrine()
		->getEntityManager();
		$images = $em->createQueryBuilder()
		->select('User')
		->from('RARAdminBundle:User',  'User')
		->where('User.id=:id')
		->setParameter('id', $session->get('userId'))
		->getQuery()
		->getResult();
		return $images;         
	}
	 /*---- End - fetching Images -----*/
 
    /*---- Start - change logo   -----*/	
    public function changeLogoAction(Request $request)
    {
    
    
		$images = $this->getImageAction();
 		$em = $this->getDoctrine()
    	->getEntityManager();
		$session = $this->getRequest()->getSession();                
    	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		if ($request->getMethod() == 'POST') 
        {
        
       $hidlogo=$this->get('request')->request->get('hidLogo');   
     		$logo = $_FILES['logo']['name'];
   			$logo1  = $_FILES['logo']['tmp_name'];  
    		move_uploaded_file($_FILES["logo"]["tmp_name"],
      		"logo/" . $_FILES["logo"]["name"]);
        
        
  			if($logo == "")
  			{
     		$em = $this->getDoctrine()
			->getEntityManager();
       		$realtors = $em->createQueryBuilder()
			->select('User')
			->update('RARAdminBundle:User',  'User')
			->set('User.logo', ':logo')
			->setParameter('logo', $hidlogo)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();
			}
			
			else
			{
				$em = $this->getDoctrine()
			->getEntityManager();
       		$realtors = $em->createQueryBuilder()
			->select('User')
			->update('RARAdminBundle:User',  'User')
			->set('User.logo', ':logo')
			->setParameter('logo', $logo)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();
			
			}
			return $this->redirect($this->generateUrl('rar_web_manageListing'));	    	
    	}
     	return $this->render('RARWebBundle:Page:changeLogo.html.twig',array('images'=>$images));
    }
  	 /*---- End - Change Logo -----*/

    /*--Start funcion -- show property listing  -----*/	  
  	public function propertyAction(Request $request)
  	{
  		$em = $this->getDoctrine()
        ->getEntityManager();	
  		$propertyImages = $this->getpropertyImageAction();
  		//echo"<pre>";print_r($propertyImages);die;
    	$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		
    	$repository = $em->getRepository('RARWebBundle:Property');
		$em = $this->getDoctrine()->getEntityManager();
     	$property = $em->createQueryBuilder()
		->select("property.name,property.id,property.description,property.address,property.zip,property.state,property.city,property.video_url,property.price,property.additional_information,state.state_name,city.city_name,images.image_url")
		->from("RARWebBundle:Property", "property")
		->leftJoin('RARAdminBundle:User', 'user', "WITH", "user.id=property.user_id")
		->leftJoin('RARAdminBundle:State', 'state', "WITH", "property.state=state.state_code")
		->leftJoin('RARAdminBundle:City', 'city', "WITH", "property.city=city.id")
		->leftJoin('RARWebBundle:PropertyImages', 'images', "WITH", "property.id=images.property_id")
		->where('user.id = :userId')
		->andwhere('images.is_main = :mainImg')
		->setParameter('userId', $session->get('userId'))
		->setParameter('mainImg', 1)		
		->getQuery()
		->getArrayResult();
		
		$arrPropertyId = array();
		$arrProperty = array();
		foreach($property as $propertyDetail)
		{
			if( !in_array($propertyDetail["id"], $arrPropertyId) )
			{
				$arrProperty[] = $propertyDetail;
				$arrPropertyId[] = $propertyDetail["id"];
			}
		}
		//echo $arrProperty[0]["id"]."<pre>";print_r($arrProperty);die();   


    	return $this->render('RARWebBundle:Page:property.html.twig',array('property'=>$arrProperty,'propertyImages'=>$propertyImages));
  
  	}

  	/*--End funcion -- show property listing  -----*/	 	  

  	/*---- Start - add a new property  -----*/	
	public function addPropertyAction(Request $request)
  	{
  		$em = $this->getDoctrine()
        ->getEntityManager();
  		$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  
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
				
				$a=@explode("watch?v=",$videourl);
				if(@$a[1]!="")
				{
					$b="embed/";
					@$videourl=$a[0].$b.$a[1];
				}
				
				$zip=$this->get('request')->request->get('zip');
				$mainImageId = $this->get('request')->request->get('hidMainImageId');

				$property=new Property();
				$property->setName($name);
				$property->setUserId($session->get('userId'));
				$property->setDescription($description);
				$property->setPhone($phone);
				$property->setState($state);
				$property->setAddress($address);
				$property->setAdditionalInformation($additional);
				$property->setCity($city);
				$property->setVideoUrl($videourl);
				$property->setprice($price);
				$property->setZip($zip);
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($property);
				$em->flush();
				$propertyId=$property->getId();
			
			foreach($_FILES as $file);
 			for($i=0 ; $i<count($file['name']); $i++)
 			{
 				$main=0;

				if( $i == $mainImageId || $i == 0 )
				{
					$main=1;
				}
 			
 				if( isset($_POST['main'.$i+1]) )
 				{
 					//echo $main = $_POST['main'.$i+1];
 				}
 			
 				//echo $file["tmp_name"][$i]."---".$file["name"][$i];
 				move_uploaded_file($file["tmp_name"][$i],"Property/" . $file["name"][$i]);
	 				
				$realtor=new PropertyImages();
				$realtor->setPropertyId($propertyId);
				$realtor->setImageUrl($file["name"][$i]);
				$realtor->setIsMain($main);
				
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($realtor);
				$em->flush();   
				
				//echo'<pre>';print_r($_POST);die;
   			//$mainNew[]=$_POST['main'.$i+1]$_POST['main'.$i+1];
   			//echo "-----";
   			
   			
				
			} 
			//die;               
			// echo "<PRE>";print_r($mainNew);die; 
  		return $this->redirect($this->generateUrl('rar_web_property',array('name'=>$session->get('userId'),'id'=>$session->get('realtorName'))));
  		}
    	return $this->render('RARWebBundle:Page:addProperty.html.twig',array('states'=>$states));
    
  	}
  	/*---- End - add a new property  -----*/

  	/*---- Start - update property of realtor  -----*/	
	public function updatePropertyAction(Request $request,$id)
	{

	 	$states = $this->getStatesAction();
 		$session = $this->getRequest()->getSession();                  
 		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		$em = $this->getDoctrine()
		->getEntityManager();
		$properties = $em->getRepository('RARWebBundle:Property')->find($id);
		if (!$properties) 
		{
			throw $this->createNotFoundException('Unable to find Blog post.');
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$properties = $postData['id'];
		}
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
			$zip=$this->get('request')->request->get('zip');
			$id=$session->get('userId');
  			$properties->setName($name);
			$properties->setUserId($session->get('userId'));
			$properties->setDescription($description);
			$properties->setPhone($phone);
			$properties->setState($state);
			$properties->setAddress($address);
			$properties->setAdditionalInformation($additional);
			$properties->setCity($city);
			$properties->setVideoUrl($videourl);
			$properties->setprice($price);
			$properties->setZip($zip);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($properties);
			$em->flush();
  			return $this->redirect($this->generateUrl('rar_web_property',array('name'=>$session->get('userId'),'id'=>$session->get('realtorName'))));
  		} 

  		return $this->render('RARWebBundle:Page:updateProperty.html.twig',array('states'=>$states,'properties'=>$properties));  	
  		  	
	}
	/*---- End - update property of realtor  -----*/	

  	/*---- Start - fetching all properties  -----*/	
	public function getPropertiesAction()
	{
		$session = $this->getRequest()->getSession();                  
       	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		} 
  		$id=$session->get('userId'); 
		$em = $this->getDoctrine()
		->getEntityManager();
		$property = $em->createQueryBuilder()
		->select('Property')
		->from('RARWebBundle:Property',  'Property')
		->where('Property.user_id = :userId')
		->setParameter('userId', $id)
		->getQuery()
		->getResult();
		return $property;          

	}
	/*---- End - fetching all properties  -----*/
	
	/*---- Start - delete property of realtor -----*/	
	public function deletePropertyAction($id)
	{
		$session = $this->getRequest()->getSession();
		$em = $this->getDoctrine()
	    ->getEntityManager();
		$property = $em->getRepository('RARWebBundle:Property')->find($id);
		if (!$property)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($property);
		$em->flush();	
		return $this->redirect($this->generateUrl('rar_web_property',array('name'=>$session->get('userId'),'id'=>$session->get('realtorName'))));
 	}
	/*---- End - delete property of realtor -----*/	
 	
 	/*---- Start - add images to slider  -----*/
	public function addSliderImageAction(Request $request)
	{
		$property = $this->getpropertyAction();
		if ($request->getMethod() == 'POST') 
    	{
    	 	$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"Property/" . $_FILES["file"]["name"]);
      		$propertyName=$this->get('request')->request->get('propertyName');
			$realtor=new PropertyImages();
			$realtor->setPropertyId($propertyName);
			$realtor->setImageUrl($file);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($realtor);
			$em->flush();                   
			return $this->redirect($this->generateUrl('rar_web_property'));
		}

		return $this->render('RARWebBundle:Page:propertyImages.html.twig',array('property'=>$property));
	}
	/*---- End - add images to slider  -----*/
	
	/*---- Start - fetching images of property -----*/ 
 	public function getpropertyImageAction()
	{
	 	$session = $this->getRequest()->getSession();          
	  	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		$id=$session->get('userId'); 
		$em = $this->getDoctrine()
		->getEntityManager();
		$propertyImages = $em->createQueryBuilder()
		->select('PropertyImages.image_url,PropertyImages.property_id')
		->from('RARWebBundle:PropertyImages',  'PropertyImages')
		->leftJoin('RARWebBundle:Property', 'property', "WITH", "property.id=PropertyImages.property_id")
		->where('property.user_id = :userId')
		->setParameter('userId', $id)
		->setMaxResults(1)
		->getQuery()
		->getResult();

		return $propertyImages;         
	}
	/*---- End - fetching images of property -----*/ 

	/*---- Start - fetch property of realtor -----*/
 	public function getpropertyAction()
 	{
 
 		$session = $this->getRequest()->getSession();          
	  	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		$id=$session->get('userId'); 
		$em = $this->getDoctrine()
		->getEntityManager();
		$property = $em->createQueryBuilder()
		->select('Property')
		->from('RARWebBundle:Property',  'Property')
		->where('Property.user_id = :userId')
		->setParameter('userId', $id)
		->getQuery()
		->getResult();
		return $property;         
 
 	}
 	/*---- End - fetch property of realtor -----*/

	/*---- Start - Show detail of property -----*/
	public function propertyDetailAction($id)
 	{

 

	 		$em = $this->getDoctrine()
		      ->getEntityManager();
			$propertyImages = $em->createQueryBuilder()
			->select('PropertyImages')
			->from('RARWebBundle:PropertyImages',  'PropertyImages')
			->leftJoin('RARWebBundle:Property', 'property', "WITH", "property.id=PropertyImages.property_id")
			->where('property.id = :userId')
			->setParameter('userId', $id)
			->getQuery()
			->getResult(); 
		
		
		//	echo "<pre>";print_r($propertyImages);die;		
        $property = $em->getRepository('RARWebBundle:Property')->find($id);
        if (!$property) 
        {

            throw $this->createNotFoundException('Unable to find  realtor.');
        }
        /*---- Start - Show map-----*/
		$ad= $property->address;
 		$latitude = '';
		$longitude = '';
		$iframe_width = '250px';
		$iframe_height = '250px';
		$address = $ad;
	
		$address = urlencode($address);
		//$key = "AIzaSyBWrzHwyPiksZMYSUcw1pAEIDGDrGjBRn8";
		$key="AIzaSyCrLkDN07F73NgDl0F7j5bxW7D_7f2wD-s";
		$url = "http://maps.google.com/maps/geo?q=".$address."&output=json&key=".$key;
		$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // Comment out the line below if you receive an error on certain hosts that have security restrictions
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		$geo_json = json_decode($data, true);
		if ($geo_json['Status']['code'] == '200') 
		{
		$latitude = $geo_json['Placemark'][0]['Point']['coordinates'][0];
		$longitude = $geo_json['Placemark'][0]['Point']['coordinates'][1]; 
	   	}
	   	/*---- End - Show map -----*/
	   	
	   	
	   	
	   	
	   		if( isset($propertyImages) && is_array($propertyImages) && count($propertyImages) > 0 )
		{
			$defaultPropertyImage = '';
		}
		else
		{
			$defaultPropertyImage = '<img src="http://www.bwcmultimedia.com/PS/review-a-realtor/web/Property/property_default.jpeg" alt="Property" style="height:40%;width:100%"/>';
		}
    
        return $this->render('RARWebBundle:Page:propertyDetail.html.twig', array(
            'property'      => $property,'propertyImages'=>$propertyImages,'latitude'=>$latitude,'longitude'=>$longitude,'iframe_width'=>$iframe_width,'iframe_height'=>$iframe_height,'address'=>$address,'key'=>$key,'url'=>$url,'ch'=>$ch,'defaultPropertyImage'=>$defaultPropertyImage
        ));
    }
    
    
    /*---- End - Show detail of property -----*/

    /*---- Start - Show detail of selected plan -----*/
	public function transactionDetailAction(Request $request)
	{
	$web_url = $this->container->getParameter('web_url');
	//echo"<PRE>";print_r($web_url);die;
	$planName=$this->get('request')->request->get('hidPlanName');
		$planSubscription=$this->get('request')->request->get('hidPlanSubscription');
		$planCharges=$this->get('request')->request->get('hidPlanCharges');

		$planId=$this->get('request')->request->get('plan');
		$em = $this->getDoctrine()
	    ->getEntityManager();
		$plan = $em->createQueryBuilder() 
		->select('Plan')
		->from('RARAdminBundle:Plan',  'Plan')
		->where('Plan.id = :planId')
		->setParameter('planId', $planId)
		->getQuery()
		->getArrayResult();  
		$name= $plan[0]['name'];
		$chargesH= $plan[0]['charges_half_yearly'];
		$chargesY= $plan[0]['charges_yearly'];
		$chargesM= $plan[0]['charges_monthly'];
		//"<pre>";print_r($plan);die();
		$planName = $name;
		if($planName=="Basic")
		{
			$session = $this->getRequest()->getSession();
			$id=$session->get('userId');           
	  	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  				
       	$id=$session->get('userId'); 
		$em = $this->getDoctrine()
		->getEntityManager();
		$plan = $em->createQueryBuilder() 
		->select('User')
		->update('RARAdminBundle:User',  'User')
		->set('User.plan_id', ':plan')
		->setParameter('plan', 1)
		->where('User.id = :userId')
		->setParameter('userId', $id)
		->getQuery()
		->getResult();
 		return $this->redirect($this->generateUrl('rar_web_managePlan'));
	}

	$planType=$this->get('request')->request->get('planS');
	if($planType=='M')
	{
		$subscriptionType="Monthly";
		$planCharges = $chargesM;
	}
	if($planType=='H')
	{
		$subscriptionType="Half-Yearly";
		$planCharges = $chargesH;
	}
	if($planType=='Y')
	{
		$subscriptionType="Yearly";
		$planCharges = $chargesY;	
	}
	 return $this->render('RARWebBundle:Page:planDetail.html.twig',array('planName'=> $planName,'subscriptionType'=>$subscriptionType,'planCharges'=>$planCharges,'web_url'=>$web_url));

	}
	/*---- End - Show detail of Plan -----*/

	/*---- Start - return to success if realton has done the payment -----*/	
	public function successAction()
	{
	$gbl_email_support = $this->container->getParameter('gbl_email_support');
	$raw_post_data = file_get_contents('php://input');
			//print_r($raw_post_data);die;		
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
			  $keyval = explode ('=', $keyval);
			  if (count($keyval) == 2)
				 $myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
			   $get_magic_quotes_exists = true;
			} 
			foreach ($myPost as $key => $value) {        
			   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
					$value = urlencode(stripslashes($value)); 
			   } else {
					$value = urlencode($value);
			   }
			   $req .= "&$key=$value";
			}
			// STEP 2: Post IPN data back to paypal to validate
			$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			if( !($res = curl_exec($ch)) ) {
				// error_log("Got " . curl_error($ch) . " when processing IPN data");
				curl_close($ch);
				exit;
			}
			curl_close($ch);
			// STEP 3: Inspect IPN validation result and act accordingly
		if (strcmp($res, "VERIFIED") == 0) {		

	
		$session = $this->getRequest()->getSession();          
	  	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('rar_web_login'));
  		}
  		
				$item_name = $_POST['item_name'];
				$item_number = $_POST['item_number'];
				$payment_status = $_POST['payment_status'];
				$payment_amount = $_POST['mc_gross'];
				$payment_currency = $_POST['mc_currency'];
				$txn_id = $_POST['txn_id'];
				$receiver_email = $_POST['receiver_email'];
				$payer_email = $_POST['payer_email'];
				$address= $_POST['address_street'];
				$zipcode = $_POST['address_zip'];
				$state = $_POST['address_state'];
				$city= $_POST['address_city'];
				$country = $_POST['address_country'];
				$datefields=$_POST["payment_date"];
   			$time=$datefields[0];
				if($item_name == 'Half-Yearly')
   			{
   			$recuringPeriod = 2;
   			}
   			elseif($item_name == 'Yearly')
   			{
   			$recuringPeriod = 3;
   			}
   			elseif($item_name == 'Monthly')
   			{
   			$recuringPeriod = 1;
   			}
   			
   		$id=$session->get('userId'); 
     	$em = $this->getDoctrine()
	   	->getEntityManager();
			$plan = $em->createQueryBuilder() 
			->select('Plan')
			->update('RARAdminBundle:User',  'Plan')
			//->leftJoin('RARAdminBundle:User',  'User', "WITH", "User.id=Review.reviewer_id");
			->set('Plan.plan_id', ':planId')
			->setParameter('planId', 2)
			->set('Plan.subscription_type_id', ':subId')
			->setParameter('subId', $recuringPeriod)
			->where('Plan.id = :id')
			->setParameter('id', $id)
			->getQuery()
			->getResult(); 
		 		
   		//	echo "<pre>";print_r( $datefields);die;
			$payment=new Payment();
			$payment->setAmount($payment_amount);
			$payment->setTransactionId($txn_id);
			$payment->setPlanId(2);
			$payment->setRecuringPeriod($recuringPeriod);
			$payment->setUserId($session->get('userId'));
			//$payment->setCreationTimeStamp($datefields);
			$em->persist($payment);
			$em->flush();

				
		$em = $this->getDoctrine()->getEntityManager();
		$userDetail = $em->createQueryBuilder()
		->select('user')
		->from('RARAdminBundle:User',  'user')
		->where('user.id=:userId')
		->setParameter('userId',$id)
		->getQuery()
		->getArrayResult();
			$firstname= $userDetail[0]['first_name'];
			$lastname= $userDetail[0]['last_name'];
			
			/*$date=date("Y/m/d.");
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <support@review-a-realtor.com>' . "\r\n";
			$to = $payer_email;
			$subject = "Payment detail/reviewarealtor.com";
			$txt='Hello '. $firstname.' '. $lastname.',<br><br>You have change the basic plan to premium plan on reviewarealtor.com on  '.$datefields.'<br><br>Your transaction Details are as under: <br>Amount: <b>'.'$'.$payment_amount.'</b><br>TransactionId: <b>'.	$txn_id.'</b>';
			mail($to,$subject,$txt,$headers); //send mail
			   	*/
					$message = \Swift_Message::newInstance()
            				->setSubject('Change Plan')
            				->setFrom($gbl_email_support)
            				->setTo($payer_email)
            				->setBody($this->renderView('RARWebBundle:Email:changePlan.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'paymentAmount'=>$payment_amount,'TransactionId'=>$txn_id,'datefields'=>$datefields)));
					$this->get('mailer')->send($message);

return $this->render('RARWebBundle:Page:success.html.twig');
	
		}
		return $this->render('RARWebBundle:Page:success.html.twig');
	}	

/*---- End - return to success if realtor has done the payment -----*/


public function showPropertyImagesAction(Request $request,$id)
{
if ($request->getMethod() == 'POST') 
    	{
    	 	$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"Property/" . $_FILES["file"]["name"]);
			$realtor=new PropertyImages();			
			$realtor->setPropertyId($id);
			$realtor->setImageUrl($file);	
			$realtor->setIsMain(0);	
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($realtor);
			$em->flush(); 
		
		
		}
		
		
		$em = $this->getDoctrine()
		      ->getEntityManager();
			$images = $em->createQueryBuilder()
			->select('PropertyImages')
			->from('RARWebBundle:PropertyImages',  'PropertyImages')
			->leftJoin('RARWebBundle:Property', 'property', "WITH", "property.id=PropertyImages.property_id")
			->where('property.id = :userId')
			->setParameter('userId', $id)
			->getQuery()
			->getResult(); 	
      $property = $em->getRepository('RARWebBundle:Property')->find($id);			
			return $this->render('RARWebBundle:Page:realtorPropertyImages.html.twig',array('images'=>$images,'property'=>$property));	
}

public function deleteRealtorImagesAction($id)
	{
		if( isset($_POST['imageId']) )
		{
			$em = $this->getDoctrine()
			  ->getEntityManager();
			$images = $em->getRepository('RARWebBundle:PropertyImages')->find($_POST['imageId']);
			if (!$images)
			{
				throw $this->createNotFoundException('No realtor found for id '.$_POST['imageId']);
			}
			//remove realtor from database
			$em->remove($images);
			$em->flush();
			return new response('SUCCESS');
		}
		

	}

	public function updatePropertyMainImageAction()
	{
		$em = $this->getDoctrine()
		->getEntityManager();
		$images1 = $em->createQueryBuilder()
		->select('b')
		->from('RARWebBundle:PropertyImages',  'b')
		->where('b.id = :imageId')
		->setParameter('imageId', $_POST['mainImageId'])
		->getQuery();
		$images1 = $images1->getArrayResult();
		//echo "<PRE>";print_r($images1[0]['property_id']);die;
		$propertyId = $images1[0]['property_id'];
	
		$em = $this->getDoctrine()
		->getEntityManager();
		$images2 = $em->createQueryBuilder()
		->select('b')
		->update('RARWebBundle:PropertyImages',  'b')
		->set('b.is_main', ':mainImg')
		->setParameter('mainImg', 0)
		->where('b.property_id = :propertyId')
		->setParameter('propertyId', $propertyId)
		->getQuery();
		$images2 = $images2->getResult();

		$em = $this->getDoctrine()
		->getEntityManager();
		$images3 = $em->createQueryBuilder()
		->select('b')
		->update('RARWebBundle:PropertyImages',  'b')
		->set('b.is_main', ':mainImg')
		->setParameter('mainImg', 1)
		->where('b.id = :imageId')
		->setParameter('imageId', $_POST['mainImageId'])
		->getQuery();
		//->getResult();
		//echo $_POST['mainImageId']."--".$images3->getSQL();die;
		$images3 = $images3->getResult();

		return new response('SUCCESS');
	}

/*---code Starts----*/
	/*---Start Function ----Delete Review---*/
	public function deleteReviewsAction($id)
	{
			
		$em = $this->getDoctrine()
    		->getEntityManager();
		$review = $em->getRepository('RARWebBundle:Review')->find($id);
		if (!$review)
		{
		throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		//remove realtor from database
		$em->remove($review);
		$em->flush();
		return $this->redirect($this->generateUrl('rar_web_feedback'));
	}

	/*---End Function ----Delete Review---*/


	/*---- Start function  - Edit Review of Realtor  -----*/
	public function editReviewsAction(Request $request,$id)
	{
		
		$em = $this->getDoctrine()
	    		->getEntityManager();
		$reviewz = $em->createQueryBuilder()
		->select('review','User.logo,User.business_name,User.first_name,User.last_name')
		->from('RARWebBundle:Review',  'review')
		->leftJoin('RARAdminBundle:User', 'User', "WITH", "User.id=review.realtor_id")
		->where('review.id = :realtorId')
		->setParameter('realtorId', $id)
		->getQuery()
	    	->getResult();
//echo"<pre>";print_R($reviewz);die;
		if ($request->getMethod() == 'POST') 
		{

			$status=2;
			$title=$this->get('request')->request->get('title');
			$description=$this->get('request')->request->get('description');
			$rating=$this->get('request')->request->get('stars');
			$review = $em->getRepository('RARWebBundle:Review')->find($id);
			$review->setHeadline($title);
			$review->setDescription($description);
			$review->setRating($rating);
			$em->persist($review);
			$em->flush();
			return $this->redirect($this->generateUrl('rar_web_feedback'));
		}
		return $this->render('RARWebBundle:Page:editReview.html.twig',array('reviewz'=>$reviewz));

      }

	/*---- End function  - Edit Review of Realtor  -----*/



/*---code Ends----*/
}

