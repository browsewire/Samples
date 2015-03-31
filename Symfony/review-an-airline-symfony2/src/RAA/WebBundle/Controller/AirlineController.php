<?php
namespace RAA\WebBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RAA\AdminBundle\Entity\User;
use RAA\AdminBundle\Entity\Plan;
use RAA\WebBundle\Entity\Requests;
use RAA\AdminBundle\Modals\Login;
use RAA\WebBundle\Entity\Review;
use RAA\WebBundle\Entity\Property;
use RAA\WebBundle\Entity\Claim;
use RAA\WebBundle\Entity\Payment;
use RAA\WebBundle\Entity\PropertyImages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class AirlineController extends Controller
{   

	/*----Start function - Reviewer Login  -----*/
	public function loginAction(Request $request)
    	{   
    		$session = $this->getRequest()->getSession();  	
       		if( $session->get('userId') && $session->get('userId') != '' )
  		{
				//return $this->redirect($this->generateUrl('raa_web_homepage'));
  		}  
  		     
    		$em = $this->getDoctrine()
        	->getEntityManager();
		$repository = $em->getRepository('RAAAdminBundle:User');
		if ($request->getMethod() == 'POST') 
        	{
           		$session->clear();
			$email = $request->get('email');
			$password = md5($request->get('password'));
			$remember = $request->get('remember');
			$user = $repository->findOneBy(array('email' => $email, 'password' => $password,'type'=>3));	
        		if ($user) 
        		{
            			if(isset($_POST["remember"])) 
            			{
					$response = new Response();
					$response->headers->setCookie(new Cookie('email', $email, 0, '/', null, false, false)); 
					$response->headers->getCookies();
				}  
			if($user->status == 2)
          		{
          			return $this->render('RAAWebBundle:Page:login.html.twig', array('name' => 'Your account is inactive'));
          	
          	
          		}
          					
          	 	else
          		{
		  		$session->set('userId', $user->getId()); 
		  		$session->set('userEmail', $user->getEmail());
		  		$session->set('userName', $user->getFirstName());
		  	 	$session->set('userType', $user->getType());
          			return $this->redirect($this->generateUrl('raa_web_home'));   
          		}
          	 	if($user->getType()==3)
          			return $this->redirect($this->generateUrl('raa_web_home'));   
          	 	else                                        
   				return $this->redirect($this->generateUrl('raa_web_home'));   						 
       		} 
        	else 
        	{
				return $this->render('RAAWebBundle:Page:login.html.twig', array('name' => 'Invalid Email/Password'));
        	}
	}
		return $this->render('RAAWebBundle:Page:login.html.twig');
	}
    /*----End function - Reviewer Login  -----*/
    

    	/*---- Start function - Reviewer Logout  -----*/
	public function logoutAction(Request $request) 
	{   
    		$session = $this->getRequest()->getSession();
		$session->remove('userEmail');
        	return $this->render('RAAWebBundle:Page:login.html.twig');
    	}
    	/*----End function - Reviewer Login  -----*/
  
	/*---- Start function - fetching all Reviewers  -----*/	
	public function getAirlinesAction()
	{
		$session = $this->getRequest()->getSession();                  
       		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		}  
		$em = $this->getDoctrine()
		->getEntityManager();
		$airlineDetails = $em->createQueryBuilder()
		->select('User')
		->from('RAAAdminBundle:User',  'User')
		->where('User.id = :userId')
		->setParameter('userId', $session->get('userId'))
		->getQuery()
		->getResult();
		return $airlineDetails;          

	}
	/*----End function - fetching all Reviewers   -----*/


	
    	/*---- Start function  - show rating to Airlines  -----*/
	public function feedbackAction(Request $request)
    	{  
       		$session = $this->getRequest()->getSession();                  
       		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		} 
  		
  		$em = $this->getDoctrine()->getEntityManager();

		/*----Start fetch reviews of loggedIn Reviewer-----*/
     		$review = $em->createQueryBuilder()
   		 ->select("rev.sender,rev.id,rev.reviewer_id,rev.airline_id,rev.parent_id,rev.airline_id,user.first_name,rev.status,user.business_name,user.last_name,rev.description,rev.rating")
		->from("RAAAdminBundle:User", "user")
		->leftJoin('RAAWebBundle:Review', 'rev', "WITH", "user.id=rev.airline_id")
		->where('rev.reviewer_id = :airlineId')
		->setParameter('airlineId', $session->get('userId'))
		->getQuery()
		->getArrayResult(); 
		/*----End fetch reviews of loggedIn Reviewer-----*/

		$arrReview = array();
		foreach($review as $reviewDetail)
		{
			$arrReview[$reviewDetail['id']] = $reviewDetail;
			
			$filteredAirlineName = str_replace(' ', '-', $reviewDetail['business_name']);

			$filteredAirlineName = $filteredAirlineName.'-Reviews';

			$arrReview[$reviewDetail['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
		}

		if(!(count($arrReview)>0))
			$arrReview = $review;
    		
		return $this->render('RAAWebBundle:Page:feedbacks.html.twig',array("review"=>$arrReview,));
	}
	/*---- End function for - show the rating of Airlines  -----*/
	 
	/*---- Start function  - Delete Review of Airline  -----*/
	public function deleteReviewsAction($id)
	{	
		$em = $this->getDoctrine()
    		->getEntityManager();
		$review = $em->getRepository('RAAWebBundle:Review')->find($id);
		if (!$review)
		{
		throw $this->createNotFoundException('No airline found for id '.$id);
		}
		//remove review from database
		$em->remove($review);
		$em->flush();
		return $this->redirect($this->generateUrl('raa_web_feedback'));
	}
	/*---- End function  - Delete Review of Airline  -----*/

	/*---- Start function  - Edit Review of Airline  -----*/
	public function editReviewsAction(Request $request,$id)
	{
		$em = $this->getDoctrine()
	    	->getEntityManager();
		/*----Start-- fetch reviewer detail-----*/
		$reviewz = $em->createQueryBuilder()
		->select('review','User.logo,User.business_name')
		->from('RAAWebBundle:Review',  'review')
		->leftJoin('RAAAdminBundle:User', 'User', "WITH", "User.id=review.airline_id")
		->where('review.id = :airlineId')
		->setParameter('airlineId', $id)
		->getQuery()
	    	->getResult();
		/*----End --fetch reviewer detail-----*/

		/*----Start Update reviewer detail-----*/
		if ($request->getMethod() == 'POST') 
		{
			$status=2;
			$title=$this->get('request')->request->get('title');
			$description=$this->get('request')->request->get('description');
			$rating=$this->get('request')->request->get('stars');
			$review = $em->getRepository('RAAWebBundle:Review')->find($id);
			$review->setHeadline($title);
			$review->setDescription($description);
			$review->setRating($rating);
			$em->persist($review);
			$em->flush();
			return $this->redirect($this->generateUrl('raa_web_feedback'));
		}
		/*----End-- Update reviewer detail-----*/
		return $this->render('RAAWebBundle:Page:editReview.html.twig',array('reviewz'=>$reviewz));

      }
	/*---- End function  - Edit Review of Airline  -----*/

    	/*---- Start function  - Show profile of  Reviewer   -----*/
	public function manageListingAction(Request $request)
    	{
    		$session = $this->getRequest()->getSession();              
      		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		}
  		$em = $this->getDoctrine()->getEntityManager();
		/*----Start-- show profile when user loggedIn-----*/
		$airlines = $em->createQueryBuilder()
		->select('User.phone, User.image,User.logo,User.business_name,User.first_name,User.last_name,User.email,User.username')
		->from('RAAAdminBundle:User',  'User')
		->where('User.id = :userId')
		->setParameter('userId', $session->get('userId'))
		->getQuery()
		->getArrayResult(); 
		/*----End --show profile when user loggedIn-----*/
		$html='';

		$imageUrl = '';
		$image = $airlines[0]['image'];
		$imageUrl = $this->getImageUrlAction($image);

		return $this->render('RAAWebBundle:Page:manageListing.html.twig',array('airlines'=>$airlines, 'userProfileImageUrl' => $imageUrl));
	}
    	/*---- End function  - Show profile of  Reviewer   -----*/

    	/*---- Start function- Dashboard of Reviewer -----*/
	public function dashboardAction(Request $request)
   	{
		$session = $this->getRequest()->getSession();                  
       		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		}    
    	
    		$em = $this->getDoctrine()->getEntityManager();
		/*----Start-- show most recent reviews-----*/
     		$review = $em->createQueryBuilder()
   		 ->select("rev.sender,rev.id,rev.reviewer_id,rev.parent_id,rev.airline_id,rev.status,user.first_name,user.business_name,user.last_name,rev.description,rev.rating")
		->from("RAAAdminBundle:User", "user")
		->leftJoin('RAAWebBundle:Review', 'rev', "WITH", "user.id=rev.airline_id")
		->where('rev.reviewer_id = :airlineId')
		->setParameter('airlineId', $session->get('userId'))
		->addOrderBy('rev.id', 'DESC')
		->setMaxResults(5)
		->getQuery()
		->getArrayResult(); 
    		/*----End-- show most recent reviews-----*/
    	 	return $this->render('RAAWebBundle:Page:dashboard.html.twig',array('review'=>$review));
    	
    	}
       /*---- End function- Dashboard of Reviewer -----*/
 
	/*---- Start function - forgot password of Reviewer -----*/
    	public function forgotPasswordAction(Request $request)
    	{
		$email=$this->get('request')->request->get('email');
		$em = $this->getDoctrine()
		->getEntityManager();
		$repository = $em->getRepository('RAAAdminBundle:User');
		if ($request->getMethod() == 'POST') 
		{   
		   	$user = $repository->findOneBy(array('email' => $email,'type'=>3));//find reviewer email
		   	if ($user) 
		   	{
		       		$newPassword = $this->generateRandomString(8);//genrate random password
		       		$encPass=md5($newPassword);
		       		$passwordReset = $em->createQueryBuilder()
				->select('User')
				->update('RAAAdminBundle:User',  'User')
				->set('User.password', ':password')
				->setParameter('password', $encPass)
				->where('User.email=:email')
				->setParameter('email', $email)
				->getQuery()
				->getResult();
	    	        	 $firstname=$user->getFirstName();
	    	       		 $lastname=$user->getLastName();
				 /*----Start-- mail for forgot password-----*/
		  	         $message = \Swift_Message::newInstance()
			    	->setSubject('Password Reset')
			    	->setFrom('support@reviewanairline.com')
			    	->setTo($email)
			    	->setBody($this->renderView('RAAWebBundle:Email:passwordReset.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'email' => $email,'password'=>$newPassword)));
				$mailStatus = $this->get('mailer')->send($message);

				/*if($mailStatus)
		    	        {
					echo $mailStatus."-->Mail Sent !";die;
				} 
				else
				{
					echo $mailStatus."-->Failed !";die;
				}*/
				/*----End-- mail for forgot password-----*/

             		return $this->render('RAAWebBundle:Page:confirm.html.twig',array('name' => $email));
            } 
            else 
            {
                return $this->render('RAAWebBundle:Page:forgotPassword.html.twig', array('name1' => 'Invalid Email'));
            }
	}
 		return $this->render('RAAWebBundle:Page:forgotPassword.html.twig');
	}
  	/*---- End function - forgot password of Reviewer -----*/

   	/*---- Start function - editing information OF Reviewer -----*/
   	public function editListingAction(Request $request)
    	{
    		$airlineDetails = $this->getAirlinesAction();
     		$session = $this->getRequest()->getSession();                
    		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		}
  		if ($request->getMethod() == 'POST') 
       		 {   
			 $firstname=$this->get('request')->request->get('firstname');
			 $username=$this->get('request')->request->get('username');
			 $lastname=$this->get('request')->request->get('lastname');
			 $email=$this->get('request')->request->get('email');
			 $phone=$this->get('request')->request->get('phone');
			if( $this->get('request')->request->get('password') )
			 	$password = $this->get('request')->request->get('password');
				 $em = $this->getDoctrine()
				->getEntityManager();

			if( isset($password) && $password != '000000' )
			{
				$password = md5($password);
	       			$airlines = $em->createQueryBuilder()
				->select('User')
				->update('RAAAdminBundle:User',  'User')
				->set('User.first_name', ':firstname')
				->set('User.last_name', ':lastname')
				->set('User.email', ':email')
				->set('User.phone', ':phone')
				->set('User.username', ':username')
				->set('User.password', ':password')
				->setParameter('username', $username)
				->setParameter('password', $password)
				->setParameter('email', $email)
				->setParameter('firstname', $firstname)
				->setParameter('lastname', $lastname)
				->setParameter('phone', $phone)
				->where('User.id=:id')
				->setParameter('id', $session->get('userId'))
				->getQuery()
				->getResult();  
			}
			else
			{
	       			$airlines = $em->createQueryBuilder()
				->select('User')
				->update('RAAAdminBundle:User',  'User')
				->set('User.first_name', ':firstname')
				->set('User.last_name', ':lastname')
				->set('User.email', ':email')
				->set('User.phone', ':phone')
				->set('User.username', ':username')
				->setParameter('username', $username)
				->setParameter('email', $email)
				->setParameter('firstname', $firstname)
				->setParameter('lastname', $lastname)
				->setParameter('phone', $phone)
				->where('User.id=:id')
				->setParameter('id', $session->get('userId'))
				->getQuery()
				->getResult();  
			}
    			return $this->redirect($this->generateUrl('raa_web_manageListing'));	
		} 
    	return $this->render('RAAWebBundle:Page:editListing.html.twig',array('airlineDetails'=>$airlineDetails,));
    }
 	/*---- end function - editing information OF Reviewer -----*/

    /*---- Start function- change image of reviewer-----*/ 
    public function changeImageAction(Request $request)
    {
		$images = $this->getImageAction();
 		$em = $this->getDoctrine()
    		->getEntityManager();
		$session = $this->getRequest()->getSession();                
    		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		}
  		if ($request->getMethod() == 'POST') 
        	{   
     		$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"images/uploads/" . $_FILES["file"]["name"]);
     		 $hidImage=$this->get('request')->request->get('hidImage');
		
		if($file == '')
		{
     			$em = $this->getDoctrine()
			->getEntityManager();
       			$airlines = $em->createQueryBuilder()
			->select('User')
			->update('RAAAdminBundle:User',  'User')
			->set('User.image', ':image')
			->setParameter('image', $hidImage)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();
		}
		else
		{
			$em = $this->getDoctrine()
			->getEntityManager();
       			$airlines = $em->createQueryBuilder()
			->select('User')
			->update('RAAAdminBundle:User',  'User')
			->set('User.image', ':image')
			->setParameter('image', $file)
			->where('User.id=:id')
			->setParameter('id', $session->get('userId'))
			->getQuery()
			->getResult();
		
		}
		return $this->redirect($this->generateUrl('raa_web_manageListing'));	
	}
	$html='';

	$imageUrl = '';
	$image = $images[0]['image'];
	$imageUrl = $this->getImageUrlAction($image);
		
     	return $this->render('RAAWebBundle:Page:changeImage.html.twig',array('images'=>$images,'userProfileImageUrl' => $imageUrl));
    }
     /*---- End function- change image of reviewer-----*/ 
    
    /*---- Start function - fetching Images -----*/
    public function getImageAction()
	{
	 	$session = $this->getRequest()->getSession();          
	  	if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('raa_web_login'));
  		}
 
		$em = $this->getDoctrine()
		->getEntityManager();
		$images = $em->createQueryBuilder()
		->select('User')
		->from('RAAAdminBundle:User',  'User')
		->where('User.id=:id')
		->setParameter('id', $session->get('userId'))
		->getQuery()
		->getArrayResult();
		return $images;         
	}
	 /*---- End function- fetching Images -----*/
 
    
	/*----Start Function -  genrate random string  -----*/
	function generateRandomString($length) 
	{
	    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    	$randomString = '';
	    	for ($i = 0; $i < $length; $i++) 
	    	{
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
	    	}
	    	return $randomString;
	}
	/*----End Function -  genrate random string  -----*/
	
	/*----Start Function -  set default Image  -----*/
	function getImageUrlAction($image)
	{
		$rootPath = $_SERVER['DOCUMENT_ROOT'].$this->container->getParameter('gbl_root_dir');
		if( isset($image) && $image != '' )
		{
			if( strpos($image, '://') > 0 )
				$imageUrl = $image;
			else
			{
				if( file_exists($rootPath."images/uploads/".$image) )	
					$imageUrl = $this->container->getParameter('website_url').'/images/uploads/'.$image;
				else
					$imageUrl = $this->container->getParameter('website_url').'/images/uploads/default_user_image.jpeg';
			}
		}
		else
		{
			$imageUrl = $this->container->getParameter('website_url').'/images/Airline/default_user_image.jpeg';
		}
		return $imageUrl;
	}
	/*----End Function -  set default Image  -----*/

	/*----Start Function -  check username  -----*/
	public function checkUserAction(Request $request)
	{
		$username=$_POST['username'];
		$em = $this->getDoctrine()->getEntityManager();
		$repository = $em->getRepository('RAAAdminBundle:User');        
		$user = $repository->findOneBy(array('username' => $username));

		if($user)
		{
			return new response('SUCCESS');
		}	

		return new response('FAILURE');

	}
	/*----End Function -  check username  -----*/


}

