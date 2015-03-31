<?php
namespace RAA\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RAA\AdminBundle\Entity\User;
use RAA\AdminBundle\Entity\Advertiesment;
use RAA\AdminBundle\Modals\Login;
use RAA\AdminBundle\Entity\fpdf;
use RAA\AdminBundle\Entity\Plan;
use RAA\AdminBundle\Entity\Claim;
use RAA\AdminBundle\Entity\CMS;
use RAA\WebBundle\Entity\Property;
use RAA\WebBundle\Entity\AirlineImages;
use RAA\WebBundle\Entity\AirlineDetail;
use RAA\WebBundle\Entity\PropertyImages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \DateTime;
class AdminController extends Controller
{   
	/*--- Start Function--- Admin login--*/
	public function indexAction(Request $request) 
	{ 
		//get value of session 
		$session = $this->getRequest()->getSession();
		if( $session->get('userId') && $session->get('userId') != '' )
		{
	        //if user is login then it will be redirect to login page    			
			return $this->redirect($this->generateUrl('RAAAdminBundle_dashboard'));
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
                return $this->redirect($this->generateUrl('RAAAdminBundle_dashboard'));
            } 
            else 
            {
                return $this->render('RAAAdminBundle:Login:login.html.twig', array('name' => 'Invalid Email/Password'));
            }
     	}
 			return $this->render('RAAAdminBundle:Login:login.html.twig');
	}
    	/*--- End Function--- Admin login--*/

    /*---- Start Function -- Admin Logout  -----*/ 
 	public function logoutAction(Request $request) 
 	{
    		$session = $this->getRequest()->getSession();
    		$session->remove('userId');
    		return $this->render('RAAAdminBundle:Login:login.html.twig');
    	}
	/*---- End Function -- Admin Logout  -----*/ 

	 
	/*---- Start Function   - Admin Forgot Password  -----*/
	public function forgotAction(Request $request) 
	{
		$email=$this->get('request')->request->get('email');
		$em = $this->getDoctrine()
       		 ->getEntityManager();
    		$repository = $em->getRepository('RAAAdminBundle:User');
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
				->update('RAAAdminBundle:User',  'b')
				->set('b.password', ':password')
				->setParameter('password', $encPass)
				->where('b.email=:email')
				->setParameter('email', $email)
				->getQuery()
				->getResult();
											
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
				return $this->render('RAAAdminBundle:Login:confirmPas.html.twig',array('name' => $email));
			} 
			else 
			{
                		return $this->render('RAAAdminBundle:Login:forgotPassword.html.twig', array('name1' => 'Invalid Email'));
			}
		}
 		return $this->render('RAAAdminBundle:Login:forgotPassword.html.twig');
	}
	/*---- End Function   - Admin Forgot Password  -----*/

  	/*---- Start Function   - Fetch all Airlines -----*/
	public function airlineAction( Request $request)
	{ 
		
		$session = $this->getRequest()->getSession();           
		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_login'));
		}	 
		
		$em = $this->getDoctrine()->getEntityManager();
		$airlines = $em->createQueryBuilder()
		->select('b.first_name,b.last_name,b.email,b.airline_tagline,b.address,b.address2,b.pincode,b.country,b.phone,b.id,b.city,state.state_name,city.city_name,b.business_name')
		->from('RAAAdminBundle:User',  'b')
		->leftJoin('RAAAdminBundle:State', 'state', "WITH", "b.state=state.state_code")
		->leftJoin('RAAAdminBundle:City', 'city', "WITH", "b.city=city.id")
		->Where('b.type = 2') //fetches data whose type=2
		//->andWhere('b.status=1')
		->getQuery()
		->getArrayResult();
		return $this->render('RAAAdminBundle:Airline:airline.html.twig', array('airlines' => $airlines));   
	}
	/*---- End Function   - Fetch all Airlines -----*/
    

	/*---- Start Function- Delete Airline  -----*/ 
	public function deleteAirlineAction($id)
	{
		$em = $this->getDoctrine()
	    	->getEntityManager();
		$realtor = $em->getRepository('RAAAdminBundle:User')->find($id);
		if (!$realtor)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		
		$em->remove($realtor);
		$em->flush();
		return $this->redirect($this->generateUrl('RAAAdminBundle_airline'));
	}
	/*---- End Function- Delete Airline  -----*/ 

	/*---- Start Function- Update Airline Images -----*/ 
	public function updateAirlineImagesAction(Request $request,$id)
	{
	
		$em = $this->getDoctrine()->getEntityManager();
			$airlineId = $em->getRepository('RAAWebBundle:AirlineImages')->find($id);
		$airlines = $em->createQueryBuilder()
		->select('airlineImages')
		->from('RAAWebBundle:AirlineImages',  'airlineImages')
		->Where('airlineImages.airline_id=:airId')
		->setParameter('airId',$id)
		->getQuery()
		->getArrayResult();
		//echo"<pre>";print_r($airlines );die;
		return $this->render('RAAAdminBundle:Airline:sliderImages.html.twig', array('airlines' => $airlines,'airlineId'=>$airlineId)); 

	}
	/*---- End Function- Update Airline Images -----*/

	/*---- Start Function- Update Airline  -----*/ 
	public function updateAirlineAction(Request $request,$id)
	{
	
		$em = $this->getDoctrine()
		->getEntityManager();
		$images = $em->createQueryBuilder()
		->select('User')
		->from('RAAAdminBundle:User',  'User')
		->where('User.id=:id')
		->setParameter('id', $id)
		->getQuery()
		->getResult();
		
		$detail = $em->createQueryBuilder()
		->select('detail')
		->from('RAAWebBundle:AirlineDetail',  'detail')
		->where('detail.airline_id = :airId')
		->andwhere('detail.left_tab_heading = :leftTabHeading')
		->setParameter('leftTabHeading', 'History')
		->setParameter('airId', $id)
		->getQuery()
		->getResult();
		$states = $this->getStatesAction();	
		$realtor = $em->getRepository('RAAAdminBundle:User')->find($id);
		if (!$realtor) 
		{
		return $this->redirect($this->generateUrl('RAAAdminBundle_error'));	
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$realtor = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$realtor = $em->getRepository('RAAAdminBundle:User')->find($id);
	
		if(!$realtor)
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_error'));				
		}
		if($request->getMethod() == 'POST') 
		{
		$file = $_FILES['file']['name'];
   		$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"images/Airline/" . $_FILES["file"]["name"]);
      		$j=$this->get('request')->request->get('profiles');	
		$airlineName=$this->get('request')->request->get('Airlinename');
		$tagline=$this->get('request')->request->get('tagline');
		$history=$this->get('request')->request->get('history');
		if($file == '')
		{
			$realtor->setLogo($j);
		} 
		else
		{
			$realtor->setLogo($file);
		}
		$realtor->setBusinessName($airlineName);
		$em->persist($realtor);
		$em->flush();			
		$updateHistory = $em->createQueryBuilder()
		->select('b')
		->update('RAAWebBundle:AirlineDetail',  'b')
		->set('b.tab_html', ':tabHtml')
		->setParameter('tabHtml', $history)
		->andwhere('b.left_tab_heading = :leftTabHeading')
		->setParameter('leftTabHeading', 'History')
		->getQuery()
		->getResult();
		return $this->redirect($this->generateUrl('RAAAdminBundle_airline'));				
		}
		return $this->render('RAAAdminBundle:Airline:airlineUpdate.html.twig', array('realtor' => $realtor,'states' => $states,'images'=>$images,'detail'=>$detail));    
	}
	/*---- End Function- Update Airline  -----*/ 

	/*---- Start Function- View Airline profile -----*/ 
	public function viewAirlineAction(Request $request,$id)
	{
	
		$em = $this->getDoctrine()->getEntityManager();
        	$airlineDetail = $em->getRepository('RAAAdminBundle:User')->find($id);
        	if (!$airlineDetail) 
        	{
            		throw $this->createNotFoundException('Unable to find  Airline.');
        	}
        
        	$em = $this->getDoctrine()
      		->getEntityManager();
		$detail = $em->createQueryBuilder()
		->select('detail')
		->from('RAAWebBundle:AirlineDetail',  'detail')
		->where('detail.airline_id = :airId')
		->andwhere('detail.left_tab_heading = :leftTabHeading')
		->setParameter('leftTabHeading', 'History')
		->setParameter('airId', $id)
		->getQuery()
		->getResult();
		return $this->render('RAAAdminBundle:Airline:viewAirline.html.twig',array('airlineDetail'=>$airlineDetail,'detail'=>$detail));    

	}
	/*---- End Function- View Airline profile -----*/ 

	public function errorAction(Request $request)
	{
	return $this->render('RAAAdminBundle:Error:error.html.twig');    
	}



	/*---- Start Function- Add new Airline  -----*/ 
	public function addAirlineAction(Request $request)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$states = $this->getStatesAction();	
		if($request->getMethod() == 'POST') 
		{
			$file = $_FILES['file']['name'];
   			$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"images/Airline/" . $_FILES["file"]["name"]);
	      		$airlineName=$this->get('request')->request->get('Airlinename');
			$tagline=$this->get('request')->request->get('tagline');
			$history=$this->get('request')->request->get('history');
			$type=2;
			$status=1;  			
			$airline=new User();
			$airline->setType($type);
			$airline->setStatus($status);
			$airline->setLogo($file);		
			$airline->setBusinessName($airlineName);			
			$em->persist($airline);
			$em->flush();
			$airId=$airline->getId();
			$airline=new AirlineDetail();
			$airline->setTabHtml($history);
			$airline->setairlineId($airId);
			$em->persist($airline);
			$em->flush();
	
			return $this->redirect($this->generateUrl('RAAAdminBundle_airline',array('states' => $states)));		
		}
			return $this->render('RAAAdminBundle:Airline:addAirline.html.twig',array('states' => $states));         
	}
 

 
	/*---- Start - Fetch all states  -----*/ 
	public function getStatesAction()
	{
		$em = $this->getDoctrine()
        ->getEntityManager();
		$states = $em->createQueryBuilder()
		->select('b')
		->from('RAAAdminBundle:State',  'b')
		->getQuery()
		->getResult();
		return $states;          
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
			->from('RAAAdminBundle:City',  'tblCity')
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
			->from('RAAAdminBundle:City',  'b')
			->getQuery()
			->getResult();                   
			return $cities;   
		}
	}
  

   	/*---- Start Function- Dashboard of Admin  -----*/ 
	public function dashboardAction()
	{
	
		$session = $this->getRequest()->getSession();
		if( !($session->get('userId')) || $session->get('userId') == '' )
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_login'));
		}
		//fetch total number of Airlines
	 	 $em = $this->getDoctrine()
   	 	->getEntityManager();
	  	$airlines = $em->createQueryBuilder()
	    	->select('count(c.id) AS totalairlines')
	    	->from('RAAAdminBundle:User',  'c')
	    	->Where('c.type=2')
	    	->getQuery()
	    	->getResult();
	    	$reviewers = $em->createQueryBuilder()
	    	->select('count(c.id) AS totalReviewers')
	    	->from('RAAAdminBundle:User',  'c')
	    	->where('c.type=3')
	    	->getQuery()
	   	->getResult();  
		$dashboardDetails = array('totalairlines' => $airlines[0]['totalairlines'],'totalReviewers' => $reviewers[0]  ['totalReviewers']);		
		
		$type='REVIEWER';
		$latestReviewer = $em->createQueryBuilder()
      		->select('user.first_name,user.last_name,user.business_name,latestReview.description,latestReview.rating,latestReview.creation_timestamp,latestReview.headline,latestReview.id,latestReview.id,latestReview.airline_id,latestReview.creation_timestamp')
	      	->from('RAAWebBundle:Review',  'latestReview')
	      	->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=latestReview.reviewer_id ")
	      	->where('latestReview.sender=:type')
	      	->andwhere('latestReview.status=1')
		->setParameter('type', $type)
	      	->addOrderBy('latestReview.id', 'DESC')
	      	 ->setMaxResults(5)
	      	->getQuery()
	      	->getArrayResult();   
		$repository = $em->getRepository('RAAAdminBundle:User');
		$arrReviewer = array();
		foreach($latestReviewer as $reviewer)
		{
			$reviewId = $reviewer['id'];
				$arrReviewer[$reviewId]['id']=  $reviewer['id'] ;
			$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
			$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
			$arrReviewer[$reviewId]['headline'] =  $reviewer['headline'] ;
			$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
			$arrReviewer[$reviewId]['rating'] =  $reviewer['rating'] ;
			$arrReviewer[$reviewId]['airline_id'] =  $reviewer['airline_id'] ;		
			$arrReviewer[$reviewId]['creation_timestamp'] =  $reviewer['creation_timestamp'] ;		
			$user = $repository->findOneBy(array('id' =>  $reviewer['airline_id']));
			if($user)	
				$businessName=$user->getBusinessName();
			else
				$businessName='';
			$arrReviewer[$reviewId]['business_name'] =  $businessName ;	
		}
	
		$latestUsers = $em->createQueryBuilder()
		->select('user.first_name,user.email,user.phone,count(review.rating) as totalReviews,review.airline_id,review.reviewer_id')
		->from('RAAAdminBundle:User',  'user')
		->leftJoin('RAAWebBundle:Review', 'review',"WITH", "user.id=review.reviewer_id ")
	    	->andwhere('user.type=3')
	    	->addOrderBy('user.id', 'DESC')
	    	->setMaxResults(5)
	    	->groupBy('user.id')
	    	->getQuery()
	    	->getResult();  
		return $this->render('RAAAdminBundle:Dashboard:dashboard.html.twig', array('dashboardDetails' => $dashboardDetails,'latestReview'=>$arrReviewer,'latestUsers'=>$latestUsers));    
    
	}

	/*---- End Function- Dashboard of Admin  -----*/ 

	/*---- Start Function- Manage Cms  -----*/ 
	public function manageCmsAction(Request $request)
	{
	
		$session = $this->getRequest()->getSession();                
		if( !($session->get('userId')) || $session->get('userId') == '' )
  		{
  			return $this->redirect($this->generateUrl('RAAAdminBundle_login'));
  		}
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RAAAdminBundle:CMS',  'cms')
		->getQuery()
		->getArrayResult();
		return $this->render('RAAAdminBundle:Cms:cms.html.twig',array('cms'=>$cms)); 

	}
	/*---- End Function- Manage Cms  -----*/ 

	/*---- Start Function- Add Cms  -----*/ 
	public function addCmsAction(Request $request)
	{	
		if($request->getMethod() == 'POST') 
		{
		$file = $_FILES['image']['name'];
		
   			$file1  = $_FILES['image']['tmp_name'];  
    			move_uploaded_file($_FILES["image"]["tmp_name"],
      			"images/Airline/" . $_FILES["image"]["name"]);
			$name=$this->get('request')->request->get('name');
			$type=$this->get('request')->request->get('type');
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
			return $this->redirect($this->generateUrl('RAAAdminBundle_manageCms'));
	}
	return $this->render('RAAAdminBundle:Cms:addCms.html.twig'); 

	}
	/*---- End Function- Manage Cms  -----*/ 

	/*---- Start Function- Edit Cms  -----*/ 
	public function editCmsAction(Request $request,$id)
	{

		$em = $this->getDoctrine()
		->getEntityManager();
		$cms = $em->getRepository('RAAAdminBundle:CMS')->find($id);
		if (!$cms) 
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_error'));			
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$cms = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->getRepository('RAAAdminBundle:CMS')->find($id);
			if(!$cms)
		{
		return $this->redirect($this->generateUrl('RAAAdminBundle_error'));			
		}
		if($request->getMethod() == 'POST') 
		{
			$file = $_FILES['image']['name'];
	
   			$file1  = $_FILES['image']['tmp_name'];  
    			move_uploaded_file($_FILES["image"]["tmp_name"],
      			"images/Airline/" . $_FILES["image"]["name"]);
      			$image=$this->get('request')->request->get('logos');
     
			$name=$this->get('request')->request->get('name');
			$url=$this->get('request')->request->get('url');
			$content=$this->get('request')->request->get('content');
			$cms->setName($name);
			$cms->setUrl($url);
			$cms->setContent($content);
			if($file == '')
			{
				$cms->setImage($image);
			}
			else
			{
				$cms->setImage($file);
			}
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($cms);
			$em->flush();
			return $this->redirect($this->generateUrl('RAAAdminBundle_manageCms'));
		}

	return $this->render('RAAAdminBundle:Cms:editcms.html.twig',array('cms'=>$cms)); 

	}
	/*---- End Function- Edit Cms  -----*/ 

	/*---- Start Function- Delete Cms  -----*/ 
	public function deleteCmsAction($id)
	{
		$em = $this->getDoctrine()
	    	->getEntityManager();
		$cms = $em->getRepository('RAAAdminBundle:CMS')->find($id);
		if (!$cms)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		$em->remove($cms);
		$em->flush();
	
		return $this->redirect($this->generateUrl('RAAAdminBundle_manageCms'));

	}
	/*---- End Function- Delete Cms  -----*/ 

	/*---- Start Function- View Cms  -----*/ 
	public function viewCmsAction($id)
	{

		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RAAAdminBundle:CMS',  'cms')
		->where('cms.id=:cmsId')
		->setParameter('cmsId', $id)
		->getQuery()
		->getResult();
		return $this->render('RAAAdminBundle:Cms:viewCms.html.twig',array('cms'=>$cms)); 

	}
	/*---- End Function- View Cms  -----*/ 
	
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
				return $this->render('RAAAdminBundle:Airline:importAirlines.html.twig',array('error'=>$error)); 
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
					}
					fclose($handle);

//print "Import done";
    	}
    	}

   
return $this->render('RAAAdminBundle:Airline:importAirlines.html.twig'); 
}
 
 	/*---- Start Function- Manage Advertiesment  -----*/ 
	public function manageAdvertiesmentAction(Request $request)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->createQueryBuilder()
		->select('adv')
		->from('RAAAdminBundle:Advertiesment',  'adv')
		->getQuery()
		->getResult();
		return $this->render('RAAAdminBundle:Advertiesment:advertiesment.html.twig',array('adv'=>$adv)); 

	}
	/*---- End Function- Manage Advertiesment  -----*/ 

	/*---- Start Function- Add Advertiesment  -----*/
	public function addAdvertiesmentAction(Request $request)
	{

		if($request->getMethod() == 'POST') 
		{
		
			$file = $_FILES['image']['name'];
   			$file1  = $_FILES['image']['tmp_name'];  
    			move_uploaded_file($_FILES["image"]["tmp_name"],
      			"images/Airline/" . $_FILES["image"]["name"]);
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
			return $this->redirect($this->generateUrl('RAAAdminBundle_advertiesment'));
		}

		return $this->render('RAAAdminBundle:Advertiesment:addAdvertiesment.html.twig'); 
	}
	/*---- End Function- Add Advertiesment  -----*/

	/*---- Start Function- Edit Advertiesment  -----*/
	public function editAdvertiesmentAction(Request $request,$id)
	{

		$em = $this->getDoctrine()
		->getEntityManager();
		$adv = $em->getRepository('RAAAdminBundle:Advertiesment')->find($id);
		if (!$adv) 
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_error'));			
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$adv = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->getRepository('RAAAdminBundle:Advertiesment')->find($id);
			if(!$adv)
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_error'));			
		}
		if($request->getMethod() == 'POST') 
		{
			
			$file = $_FILES['image']['name'];
   			$file1  = $_FILES['image']['tmp_name'];  
    			move_uploaded_file($_FILES["image"]["tmp_name"],
      			"images/Airline/" . $_FILES["image"]["name"]);
      			$type=$this->get('request')->request->get('type');
			$title=$this->get('request')->request->get('title');
			$description=$this->get('request')->request->get('description');
			$targetUrl=$this->get('request')->request->get('targetUrl');
			$adv->setTitle($title);
			$adv->setType($type);
			$adv->setImage($file);
			$adv->setDescription($description);
			$adv->setTargetUrl($targetUrl);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($adv);
			$em->flush();
			return $this->redirect($this->generateUrl('RAAAdminBundle_advertiesment'));
		}

		return $this->render('RAAAdminBundle:Advertiesment:updateAdvertiesment.html.twig',array('adv'=>$adv)); 

	}
	/*---- End Function- Edit Advertiesment  -----*/

	/*---- Start Function- Delete Advertiesment  -----*/
	public function deleteAdvertiesmentAction($id)
	{
		$em = $this->getDoctrine()
	    	->getEntityManager();
		$adv = $em->getRepository('RAAAdminBundle:Advertiesment')->find($id);
		if (!$adv)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		$em->remove($adv);
		$em->flush();
	
		return $this->redirect($this->generateUrl('RAAAdminBundle_advertiesment'));

	}
	/*---- End Function- Delete Advertiesment  -----*/
public function getCsvAction()
{
$output = "";
$em = $this->getDoctrine()
    ->getEntityManager();
	  $Realtors = $em->createQueryBuilder()
    ->select('c')
    ->from('RAAAdminBundle:User',  'c')
    ->getQuery()
    ->getArrayResult();
    


	  $em = $this->getDoctrine()
    ->getEntityManager();
	  $Realtors1 = $em->createQueryBuilder()
    ->select('count(c.id)')
    ->from('RAAAdminBundle:User',  'c')
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
	
	return $this->redirect($this->generateUrl('RAAAdminBundle_realtor'));

}

	/*---- Start Function- Manage Reviewer  -----*/
	public function manageReviewerAction(Request $request)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$rev  = $em->createQueryBuilder()
   		->select('user.id,user.last_name,user.first_name,user.email,user.phone,count(review.rating) as totalReviews,review.description')
    		->from('RAAAdminBundle:User',  'user')
    		->leftJoin('RAAWebBundle:Review', 'review',"WITH", "user.id=review.reviewer_id ")
    		->andwhere('user.type=3')
		->groupBy('user.id')
		->getQuery()
		->getResult();  
		return $this->render('RAAAdminBundle:Reviewer:reviewer.html.twig',array('rev'=>$rev)); 

	}
	/*---- End Function- Manage Reviewer  -----*/
	
	/*---- Start Function- Show Total Reviews  -----*/
	public function showTotalReviewsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$reviewsDetail  = $em->createQueryBuilder()
    		->select('user.id,user.last_name,user.first_name,user.email,user.phone,review.description,review.headline,user.business_name,user.logo')
    		->from('RAAWebBundle:Review',  'review')
    		->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=review.airline_id ")
    		->where('review.reviewer_id=:revId')
    		->setParameter('revId',$id)
   		->getQuery()
   		->getResult();  
		
		return $this->render('RAAAdminBundle:Reviewer:showRev.html.twig',array('reviewsDetail'=>$reviewsDetail)); 

	}
	/*---- End Function- Show Total Reviews  -----*/
	/*---- Start Function- Delete Reviewer -----*/
	public function deleteReviewerAction($id)
	{
		$em = $this->getDoctrine()
	    	->getEntityManager();
		$rev = $em->getRepository('RAAAdminBundle:User')->find($id);
		if (!$rev)
		{
			throw $this->createNotFoundException('No realtor found for id '.$id);
		}
		$em->remove($rev);
		$em->flush();	
		return $this->redirect($this->generateUrl('RAAAdminBundle_reviewer'));


	}
	/*---- End Function- Delete Reviewer  -----*/

	/*---- Start Function- Edit Reviewer -----*/
	public function editReviewerAction(Request $request,$id)
	{

		$em = $this->getDoctrine()
		->getEntityManager();
		$airline = $em->getRepository('RAAAdminBundle:User')->find($id);
		
		if (!$airline) 
		{
		return $this->redirect($this->generateUrl('RAAAdminBundle_error'));	
		}
		if (is_null($id)) 
		{
			$postData = $request->get('$id');
			$airline = $postData['id'];
		}
		$em = $this->getDoctrine()->getEntityManager();
		$airline = $em->getRepository('RAAAdminBundle:User')->find($id);
	
			if(!$airline)
		{
			return $this->redirect($this->generateUrl('RAAAdminBundle_error'));				
		}
		//update Reviewer information
		if($request->getMethod() == 'POST') 
		{	
			$firstname=$this->get('request')->request->get('firstname');		
			$lastname=$this->get('request')->request->get('lastname');
			$email=$this->get('request')->request->get('email');
			$phone=$this->get('request')->request->get('phone');			
			$password=md5($this->get('request')->request->get('password'));
			$airline->setFirstName($firstname);
			$airline->setLastName($lastname);
			$airline->setEmail($email);
			$airline->setPhone($phone);
			$em->persist($airline);
			$em->flush();
			return $this->redirect($this->generateUrl('RAAAdminBundle_reviewer'));
		}

		$reviews  = $em->createQueryBuilder()
   		->select('user.first_name,user.business_name,review.description,review.headline,review.creation_timestamp,user.logo')
    		->from('RAAWebBundle:Review',  'review')
    		->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=review.airline_id ")
    		->where('review.reviewer_id=:revId')
    		->setParameter('revId',$id)
    		->getQuery()
   		->getResult(); 

		return $this->render('RAAAdminBundle:Reviewer:editReviewer.html.twig',array('airline'=>$airline,'reviewes'=>$reviews)); 


	}
	/*---- End Function- Edit Reviewer -----*/

	/*---- Start Function- Update Slider Images-----*/	
	public function updateSliderAction(Request $request,$id)
	{
		$file = $_FILES['file']['name'];
   		$file1  = $_FILES['file']['tmp_name'];  
    		move_uploaded_file($_FILES["file"]["tmp_name"],
      		"images/Airline/" . $_FILES["file"]["name"]);
      		$airline=new AirlineImages();
		$airline->setAirlineId($id);
		$airline->setImageUrl($file);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($airline);
		$em->flush();	
		return $this->redirect($this->generateUrl('RAAAdminBundle_airlineImages',array('id'=>$id)));
					

	}
	/*---- End Function- Update Slider Images-----*/
	
	/*---- Start Function- Delete Slider Images-----*/	
	public function deleteSliderImagesAction($id)
	{
		if( isset($_POST['imageId']) )
		{
			$em = $this->getDoctrine()
			 ->getEntityManager();
			$images = $em->getRepository('RAAWebBundle:AirlineImages')->find($_POST['imageId']);
			if (!$images)
			{
				throw $this->createNotFoundException('No realtor found for id '.$_POST['imageId']);
			}
	
			$em->remove($images);
			$em->flush();
			return new response('SUCCESS');
		}
	}
	/*---- End Function- Delete Slider Images-----*/	

	/*---- Start Function- Show Complete Review-----*/
	public function ratingCompleteDetailAction()
	{
		$id=$_POST['id'];
		$em = $this->getDoctrine()
		->getEntityManager();
		$completeReview = $em->getRepository('RAAWebBundle:Review')->find($id);
		$a = $completeReview->description;
		return new response($a);

	}
	/*---- End Function-  Show Complete Review-----*/
	
	/*---- Start Function- Manage Reviews-----*/
	public function manageReviewsAction(Request $request)
	{
		$em = $this->getDoctrine()
		->getEntityManager();
		$type='REVIEWER';
		$reviews = $em->createQueryBuilder()
      		->select('user.first_name,user.last_name,user.business_name,latestReview.description,latestReview.rating,latestReview.reviewer_id,latestReview.status,latestReview.creation_timestamp,latestReview.headline,latestReview.id,latestReview.id,latestReview.airline_id,latestReview.creation_timestamp')
      		->from('RAAWebBundle:Review',  'latestReview')
      		->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=latestReview.airline_id ")
      		->where('latestReview.sender=:type')
		->setParameter('type', $type)
      		->addOrderBy('latestReview.creation_timestamp', 'asc')
      		->getQuery()
      		->getResult();   
//echo"<pre>";print_R($reviews);die;
		$arrReviewer = array();
		$repository = $em->getRepository('RAAAdminBundle:User');
		foreach($reviews as $reviewer)
		{
			$reviewId = $reviewer['id'];
			$arrReviewer[$reviewId]['id'] =  $reviewer['id'] ;
			$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
			$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
			$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
			$arrReviewer[$reviewId]['rating'] =  $reviewer['rating'] ;
			$arrReviewer[$reviewId]['status'] =  $reviewer['status'] ;
			$arrReviewer[$reviewId]['business_name'] =  $reviewer['business_name'] ;
			$arrReviewer[$reviewId]['airline_id'] =  $reviewer['airline_id'] ;
			$arrReviewer[$reviewId]['reviewer_id'] =  $reviewer['reviewer_id'] ;
			$user = $repository->findOneBy(array('id' =>  $reviewer['reviewer_id']));
			if($user)	
				$airlineName=$user->getFirstName()." ".$user->getLastName();
			else
				$airlineName='';
			$arrReviewer[$reviewId]['airline_name'] =  $airlineName ;
	
		}
//echo"<pre>";print_R($arrReviewer);die;	
		return $this->render('RAAAdminBundle:Reviewer:reviews.html.twig',array('reviews'=>$arrReviewer)); 

	}
	/*---- End Function- Manage Reviews-----*/

	/*---- Start Function- Publish Review -----*/
	public function publishReviewAction(Request $request)
	{
		$id= $_POST['id'];
		$status= $_POST['status'];
		$newStatus = 1;
		$em = $this->getDoctrine()
		->getEntityManager();
		if($status == 1)
		{
			$newStatus = 2;
		}
				
		$airlines = $em->createQueryBuilder()
		->select('rev')
		->update('RAAWebBundle:Review',  'rev')
		->set('rev.status', ':status')
		->setParameter('status', $newStatus)
		->where('rev.id=:id')
		->setParameter('id', $id)
		->getQuery()
		->getResult();
		return new response('SUCCESS');

	}
	/*---- End Function- Publish Review -----*/

	/*---- Start Function- Delete Review -----*/
	public function deleteReviewAction($id)
	{
	
		$em = $this->getDoctrine()
	    	->getEntityManager();
		$review = $em->getRepository('RAAWebBundle:Review')->find($id);
		if (!$review)
		{
			throw $this->createNotFoundException('No airline found for id '.$id);
		}
		$em->remove($review);
		$em->flush();
		return $this->redirect($this->generateUrl('RAAAdminBundle_manageReviews'));
	}
	/*---- End Function- Delete Review -----*/



}	
