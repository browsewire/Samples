<?php
namespace RAA\WebBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RAA\AdminBundle\Entity\User;
use RAA\WebBundle\Entity\Subscriber;
use RAA\WebBundle\Entity\Contact;
use RAA\AdminBundle\Entity\Plan;
use RAA\WebBundle\Entity\Requests;
use RAA\AdminBundle\Modals\Login;
use RAA\WebBundle\Entity\Review;
use RAA\WebBundle\Entity\Property;
use RAA\WebBundle\Entity\Claim;
use RAA\WebBundle\Entity\Payment;
use RAA\WebBundle\Entity\AirlineDetail;
use RAA\WebBundle\Entity\PropertyImages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \DateTime;
class WebController extends Controller
{   
    	/*----- Start Function-- homepage -----*/
	public function indexAction()
    	{
		 /*----- Start -- Display Most Recent Reviews -----*/
     		$em = $this->getDoctrine()->getEntityManager();
      		$type='REVIEWER';
   	  	$latestReviewer = $em->createQueryBuilder()
      		->select('count(latestReview.reviewer_id) As totalReviewes,user.first_name,user.last_name,user.image,latestReview.description,latestReview.reviewer_image,latestReview.rating,latestReview.headline,latestReview.creation_timestamp,user.business_name,latestReview.id,latestReview.airline_id,latestReview.reviewer_id,latestReview.creation_timestamp')
	      	->from('RAAWebBundle:Review',  'latestReview')
	    	->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=latestReview.airline_id ")
	      	->where('latestReview.sender=:type')
	      	->andwhere('latestReview.status=1')
		->setParameter('type', $type)
	      	->addOrderBy('latestReview.id', 'DESC')
		->groupBy('latestReview.reviewer_id')
		->setMaxResults(4)
	      	->getQuery()
	      	->getArrayResult();
		$repository = $em->getRepository('RAAAdminBundle:User');
		$arrReviewer = array();
		foreach($latestReviewer as $reviewer)
		{
			$reviewId = $reviewer['id'];
			$arrReviewer[$reviewId]['id'] =  $reviewer['id'] ;
			$arrReviewer[$reviewId]['totalReviewes'] =  $reviewer['totalReviewes'] ;
			$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
			$arrReviewer[$reviewId]['headline'] =  $reviewer['headline'] ;
			$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
			$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
			$arrReviewer[$reviewId]['image'] =  $reviewer['image'] ;
			$arrReviewer[$reviewId]['business_name'] =  $reviewer['business_name'] ;
			$arrReviewer[$reviewId]['creation_timestamp'] =  $reviewer['creation_timestamp'] ;
			$arrReviewer[$reviewId]['reviewer_id'] =  $reviewer['reviewer_id'] ;
			$arrReviewer[$reviewId]['airline_id'] =  $reviewer['airline_id'] ;
			$arrReviewer[$reviewId]['rating'] =  $reviewer['rating'] ;
			$user = $repository->findOneBy(array('id' =>  $reviewer['reviewer_id']));
			if($user)	
			{
				$airlineName=$user->getFirstName()." ".$user->getLastName();
				$reviewerImage=$user->getImage();
			}
			else
			{
				$airlineName='';
				$reviewerImage='';
			}

			$arrReviewer[$reviewId]['airline_name'] =  $airlineName ;

			$imageUrl = '';
			$image = $reviewerImage;
			$imageUrl = $this->getImageUrlAction($image);
			//echo"<pre>";print_r($imageUrl);die;
			$arrReviewer[$reviewId]['reviewer_image'] =  $imageUrl;
		}

		foreach($arrReviewer as $reviewer)
		{
			$arrReviewers[$reviewer['id']] = $reviewer;
			
			$filteredAirlineName = str_replace(' ', '-', $reviewer['business_name']);
			$filteredHeadline = str_replace(' ', '-', $reviewer['headline']);

			$filteredAirlineName = $filteredAirlineName.'-Reviews';

			$arrReviewers[$reviewer['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
			$arrReviewers[$reviewer['id']]['filteredHeadline'] = strtolower($filteredAirlineName.'-'.$filteredHeadline);
		}

		 /*----- End -- Display Most Recent Reviews -----*/
      		return $this->render('RAAWebBundle:Page:index.html.twig', array('latestReviewer'=>$arrReviewers));
   	 }
   	/*----- End Function-- homepage -----*/

   	/*---Start Function-- Write ReviewPage---*/
	public function writeReviewAction()
    	{
		$id=0;
        	return $this->redirect($this->generateUrl('raa_web_review',array('id'=>$id)));
    	}
     	/*---End Function-- Write ReviewPage---*/
 	
	/*---Start Function-- Write ReviewPage for Dashboard---*/
  	public function writeReviewDashboardAction()
    	{
		$id=0;
        return $this->redirect($this->generateUrl('raa_web_reviewDashboard',array('id'=>$id)));
    	}
    
    	/*---End Function-- Write ReviewPage for Dashboard---*/
	
	/*---Start Function-- Airline Search ---*/	
	public function airlineAction(Request $request)
 	{ 


		$countAirline= $this->countAirlinesAction();//call function for count airlines
		/*--Start--Pagination--*/		
		$page = $request->get('page');
		$count_per_page = 15;
		$total_count = $countAirline;
		$total_pages=ceil($total_count/$count_per_page);
		if(!is_numeric($page))
		{
		    $page=1;
		}
		else
		{
		    $page=floor($page);
		}
		if($total_count<=$count_per_page)
		{
		    $page=1;
		}
		if(($page*$count_per_page)>$total_count)
		{
		    $page=$total_pages;
		}
		$offset=0;
		if($page>1)
		{
		    $offset = $count_per_page * ($page-1);
		}
		/*--End--Pagination--*/ 	
 		$alphabet='';
 		$em = $this->getDoctrine()->getEntityManager();
 		$type='REVIEWER';
 		/*--Start--Display latest Review--*/
		$latestReviewer = $em->createQueryBuilder()
	      	->select('user.first_name,user.last_name,latestReview.description,user.business_name,latestReview.id,latestReview.rating,latestReview.headline,latestReview.creation_timestamp,latestReview.airline_id,latestReview.reviewer_id,latestReview.creation_timestamp')
	      	->from('RAAWebBundle:Review',  'latestReview')
	      	->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=latestReview.airline_id")
	      	->where('latestReview.sender=:type')
	      	->andwhere('latestReview.status=1')
		->setParameter('type', $type)
	      	->addOrderBy('latestReview.id', 'DESC')
		->setMaxResults(3)
	      	->getQuery()
	      	->getArrayResult(); 
	      	
	 		
 		$repository = $em->getRepository('RAAAdminBundle:User');
		$arrReviewer = array();
		foreach($latestReviewer as $reviewer)
		{
			$reviewId = $reviewer['id'];
			$arrReviewer[$reviewId]['id'] =  $reviewer['id'] ;
			$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
			$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
			$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
			$arrReviewer[$reviewId]['business_name'] =  $reviewer['business_name'] ;
			$arrReviewer[$reviewId]['rating'] =  $reviewer['rating'] ;
			$arrReviewer[$reviewId]['headline'] =  $reviewer['headline'] ;
			$arrReviewer[$reviewId]['creation_timestamp'] =  $reviewer['creation_timestamp'] ;
			$arrReviewer[$reviewId]['reviewer_id'] =  $reviewer['reviewer_id'] ;
			$arrReviewer[$reviewId]['airline_id'] =  $reviewer['airline_id'] ;
			$user = $repository->findOneBy(array('id' =>  $reviewer['reviewer_id']));
			if($user)	
				$airlineName=$user->getFirstName()." ".$user->getLastName();
			else
				$airlineName='';
			$arrReviewer[$reviewId]['airline_name'] =  $airlineName ;
					
		}
		/*--End--Display latest Review--*/
		foreach($arrReviewer as $reviewer)
		{
			$arrReviewers[$reviewer['id']] = $reviewer;
			$filteredAirlineName = str_replace(' ', '-', $reviewer['business_name']);
			$filteredHeadline = str_replace(' ', '-', $reviewer['headline']);
			$filteredAirlineName = $filteredAirlineName.'-Reviews';
			$arrReviewers[$reviewer['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
			$arrReviewers[$reviewer['id']]['filteredHeadline'] = strtolower($filteredAirlineName.'-'.$filteredHeadline);
		}
			/*--Start--Display Advertiesment--*/
			$stateCode='';				
			$adv = $em->createQueryBuilder()
			->select('adv')
			->from('RAAAdminBundle:Advertiesment',  'adv')
			->where('adv.type=:type')
			->setParameter('type',"ADV")
			->getQuery()
			->getResult();	
			/*--End--Display Advertiesment--*/	
			
			/*--Start--Search Airline on basis of alphabets--*/
			if(isset($_POST['hidAlphabet']))
			{
		 		$alphabet=$_POST['hidAlphabet'];
				
			}
			
			if(isset($_REQUEST['state']))
			{
		 		$stateCode=$_REQUEST['state'];
			}
			 
			$totalAirlines = 0;
			$condition = 0; 	
			$page = 1;
			$totalPages = 1;
			if( isset($_POST['hidReviewFilter1']) && $_POST['hidReviewFilter1'] != '' && isset($_POST['hidReviewFilter2']) && $_POST['hidReviewFilter2'] != '' )
	    		{
	    			$reviewCountMin = $_POST['hidReviewFilter1'];
	    			$reviewCountMax = $_POST['hidReviewFilter2'];
	    		}
	    		$search = preg_replace('#[^a-z]#i', ' ', $this->get('request')->request->get('search'));
			$address=$this->get('request')->request->get('address'); 
			$state=$this->get('request')->request->get('state');  
			$company=$this->get('request')->request->get('company');
			$rating=$this->get('request')->request->get('ratings');  	 
			if( !(isset($search)) && !(isset($address)) && !(isset($company)) && !(isset($rating)) && !(isset($reviewCountMax)) && !(isset($reviewCountMin)) )
			{
					$airlines = '';
			}
			else
	  		{
  				
			$em = $this->getDoctrine()->getEntityManager()->createQueryBuilder();  		   		
			if( isset($reviewCountMin) && isset($reviewCountMax) )
			{
				$em->select('User.id, User.first_name, User.last_name, User.logo_tile,User.business_name, User.phone,  User.image,User.logo,  City.city_name, State.state_name,User.category1');
			}
			else
			{
				$em->select('User.id, User.first_name, User.last_name, User.logo_tile,User.business_name, User.phone,  User.image,User.logo,  City.city_name, State.state_name,User.category1');
				
				
			}
			$em->from('RAAAdminBundle:User', 'User');
		
			$em->leftJoin('RAAAdminBundle:City',  'City', "WITH", "User.city=City.id");
			$em->leftJoin('RAAAdminBundle:State',  'State', "WITH", "User.state=State.state_code");
			if(isset($alphabet))
			{
				$em->where('User.business_name like :airlineFirstAlphabet');
				$em->andwhere('User.type=2');
				$em->setParameter('airlineFirstAlphabet', $alphabet.'%');
				
			}
		  	if( isset($search) && $search != '' )
		   	{
		   	
		   		if( $condition == 1 )
		   		{
		   			$em->andwhere('User.business_name like :airlineName');
					
				}	
				else
				{
					if(isset($alphabet))
					{
						$em->andwhere('User.business_name like :airlineName');
					}
					else
					{
						$em->where('User.business_name like :airlineName');
					}
						$em->andwhere('User.type=2');
				}
					$em->setParameter('airlineName', '%'.$search.'%');
					$condition = 1;
				}
				if( isset($stateCode) && $stateCode != '' )
		   		{
		   			if( $condition == 1 )
		   			{
						$em->andwhere('User.state like :airlineName or State.state_name like :state');
						$em->andwhere('User.type=2');
				 
					}
					else
					{
						$em->andwhere('User.state like :airlineName or State.state_name like :state');
						$em->andwhere('User.type=2');
					}
					$em->setParameter('airlineName', '%'.$stateCode.'%');
					$em->setParameter('state', '%'.$stateCode.'%');
					$condition = 1;
				}
				if( isset($address) && $address != '' )
		   		{
		   			if( $condition == 1 )
		   			{
						$em->andwhere('User.address like :address or City.city_name like :address or State.state_name like :address');
						$em->andwhere('User.type=2');
					}
				else
				{
					$em->Where('User.address like :address or City.city_name like :address or State.state_name like :address');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('address', '%'.$address.'%');
				$condition = 1;
			}
				
			if( isset($company) && $company != '' )
		   	{
		   		if( $condition == 1 )
		   		{
					$em->andwhere('User.business_name like :business');
					$em->andwhere('User.type=2');
				}
				else
				{
					$em->Where('User.business_name like :business');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('business', '%'.$company.'%');
				$condition = 1;
			}
			 
			if( isset($state) && $state != '' )
		   	{		
	   			if( $condition == 1 )
	   			{
					$em->andwhere('User.state_code like :state or State.state_name like :stateName');
					$em->andwhere('User.type=2');
				}
				else
				{
					$em->Where('User.state like :state or State.state_name like :stateName');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('state', '%'.$state.'%');
				$em->setParameter('stateName', '%'.$state.'%');
				$condition = 1;
			}
			
			
				
			if( isset($reviewCountMin) && isset($reviewCountMax) )
			{
				if( $condition == 1 )
		   		{
					$em->andwhere('Review.sender like :sender');
						$em->andwhere('User.type=2');
				}
				else
				{
		  			$em->Where('Review.sender like :sender');
		  				$em->andwhere('User.type=2');
				}
				$em->setParameter('sender', 'REVIEWER');
		  	}
		  	$em->addOrderBy('User.id');
		  	$em->setFirstResult($offset);
       			$em->setMaxResults($count_per_page);
		  	$airlines = $em->getQuery()->getArrayResult(); 
		 	
		
		}
		/*--End--Search Airline on basis of alphabets--*/

		foreach($airlines as $airline)
		{
			$arrAirlines[$airline['id']] = $airline;
			
			$filteredAirlineName = str_replace(' ', '-', $airline['business_name']);

			$filteredAirlineName = $filteredAirlineName.'-Reviews';

			$arrAirlines[$airline['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
		}

        return $this->render('RAAWebBundle:Page:searchAirlines.html.twig',array('search'=>$search,'address'=>$address,'airlineDetails'=>$arrAirlines,'totalAirlines'=> $totalAirlines,'adv'=>$adv,'stateCode'=>$stateCode,'latestReviewer'=>$arrReviewers,'alphabet'=>$alphabet,'total_pages'=>$total_pages,'current_page'=> $page,'countAirline'=>$countAirline,'search'=>$search,'alphabet'=>$alphabet));
	}
	/*---End Function-- Airline Search ---*/


	/*---Start Function-- Airline Search ---*/	
	public function airlinePaginationAction(Request $request)
 	{ 


		$countAirline= $this->countAirlinesAction();//call function for count airlines
		//echo "<pre>";print_r($countAirline);die;
		/*--Start--Pagination--*/		
		$page = $request->get('page');
		$count_per_page = 15;
		$total_count = $countAirline;
		$total_pages=ceil($total_count/$count_per_page);
		if(!is_numeric($page))
		{
		    $page=1;
		}
		else
		{
		    $page=floor($page);
		}
		if($total_count<=$count_per_page)
		{
		    $page=1;
		}
		if(($page*$count_per_page)>$total_count)
		{
		    $page=$total_pages;
		}
		$offset=0;
		if($page>1)
		{
		    $offset = $count_per_page * ($page-1);
		}
		/*--End--Pagination--*/ 	
 		$alphabet='';
 		$em = $this->getDoctrine()->getEntityManager();
 		$type='REVIEWER';
 		/*--Start--Display latest Review--*/
		$latestReviewer = $em->createQueryBuilder()
	      	->select('user.first_name,user.last_name,latestReview.description,user.business_name,latestReview.id,latestReview.rating,latestReview.headline,latestReview.creation_timestamp,latestReview.airline_id,latestReview.reviewer_id,latestReview.creation_timestamp')
	      	->from('RAAWebBundle:Review',  'latestReview')
	      	->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=latestReview.airline_id")
	      	->where('latestReview.sender=:type')
	      	->andwhere('latestReview.status=1')
		->setParameter('type', $type)
	      	->addOrderBy('latestReview.id', 'DESC')
		->setMaxResults(3)
	      	->getQuery()
	      	->getArrayResult(); 
	      	
	 		
 		$repository = $em->getRepository('RAAAdminBundle:User');
		$arrReviewer = array();
		foreach($latestReviewer as $reviewer)
		{
			$reviewId = $reviewer['id'];
			$arrReviewer[$reviewId]['id'] =  $reviewer['id'] ;
			$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
			$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
			$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
			$arrReviewer[$reviewId]['business_name'] =  $reviewer['business_name'] ;
			$arrReviewer[$reviewId]['rating'] =  $reviewer['rating'] ;
			$arrReviewer[$reviewId]['headline'] =  $reviewer['headline'] ;
			$arrReviewer[$reviewId]['creation_timestamp'] =  $reviewer['creation_timestamp'] ;
			$arrReviewer[$reviewId]['reviewer_id'] =  $reviewer['reviewer_id'] ;
			$arrReviewer[$reviewId]['airline_id'] =  $reviewer['airline_id'] ;
			$user = $repository->findOneBy(array('id' =>  $reviewer['reviewer_id']));
			if($user)	
				$airlineName=$user->getFirstName()." ".$user->getLastName();
			else
				$airlineName='';
			$arrReviewer[$reviewId]['airline_name'] =  $airlineName ;
					
		}
		/*--End--Display latest Review--*/
		foreach($arrReviewer as $reviewer)
		{
			$arrReviewers[$reviewer['id']] = $reviewer;
			$filteredAirlineName = str_replace(' ', '-', $reviewer['business_name']);
			$filteredHeadline = str_replace(' ', '-', $reviewer['headline']);
			$filteredAirlineName = $filteredAirlineName.'-Reviews';
			$arrReviewers[$reviewer['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
			$arrReviewers[$reviewer['id']]['filteredHeadline'] = strtolower($filteredAirlineName.'-'.$filteredHeadline);
		}
			/*--Start--Display Advertiesment--*/
			$stateCode='';				
			$adv = $em->createQueryBuilder()
			->select('adv')
			->from('RAAAdminBundle:Advertiesment',  'adv')
			->where('adv.type=:type')
			->setParameter('type',"ADV")
			->getQuery()
			->getResult();	
			/*--End--Display Advertiesment--*/	
			
			/*--Start--Search Airline on basis of alphabets--*/
			if(isset($_REQUEST['hidAlphabet']))
			{
		 		$alphabet=$_REQUEST['hidAlphabet'];
				
			}
			
			if(isset($_REQUEST['state']))
			{
		 		$stateCode=$_REQUEST['state'];
			}
			 
			$totalAirlines = 0;
			$condition = 0; 	
			$page = 1;
			$totalPages = 1;
			if( isset($_POST['hidReviewFilter1']) && $_POST['hidReviewFilter1'] != '' && isset($_POST['hidReviewFilter2']) && $_POST['hidReviewFilter2'] != '' )
	    		{
	    			$reviewCountMin = $_POST['hidReviewFilter1'];
	    			$reviewCountMax = $_POST['hidReviewFilter2'];
	    		}
	    		$search = preg_replace('#[^a-z]#i', ' ', $this->get('request')->request->get('search'));
			$address=$this->get('request')->request->get('address'); 
			$state=$this->get('request')->request->get('state');  
			$company=$this->get('request')->request->get('company');
			$rating=$this->get('request')->request->get('ratings');  	 
			if( !(isset($search)) && !(isset($address)) && !(isset($company)) && !(isset($rating)) && !(isset($reviewCountMax)) && !(isset($reviewCountMin)) )
			{
					$airlines = '';
			}
			else
	  		{
  				
			$em = $this->getDoctrine()->getEntityManager()->createQueryBuilder();  		   		
			if( isset($reviewCountMin) && isset($reviewCountMax) )
			{
				$em->select('User.id, User.first_name, User.last_name, User.logo_tile,User.business_name, User.phone,  User.image,User.logo,  City.city_name, State.state_name,User.category1');
			}
			else
			{
				$em->select('User.id, User.first_name, User.last_name, User.logo_tile,User.business_name, User.phone,  User.image,User.logo,  City.city_name, State.state_name,User.category1');
				
				
			}
			$em->from('RAAAdminBundle:User', 'User');
		
			$em->leftJoin('RAAAdminBundle:City',  'City', "WITH", "User.city=City.id");
			$em->leftJoin('RAAAdminBundle:State',  'State', "WITH", "User.state=State.state_code");
			if(isset($alphabet))
			{
				$em->where('User.business_name like :airlineFirstAlphabet');
				$em->andwhere('User.type=2');
				$em->setParameter('airlineFirstAlphabet', $alphabet.'%');
				
			}
		  	if( isset($search) && $search != '' )
		   	{
		   	
		   		if( $condition == 1 )
		   		{
		   			$em->andwhere('User.business_name like :airlineName');
					
				}	
				else
				{
					if(isset($alphabet))
					{
						$em->andwhere('User.business_name like :airlineName');
					}
					else
					{
						$em->where('User.business_name like :airlineName');
					}
						$em->andwhere('User.type=2');
				}
					$em->setParameter('airlineName', '%'.$search.'%');
					$condition = 1;
				}
				if( isset($stateCode) && $stateCode != '' )
		   		{
		   			if( $condition == 1 )
		   			{
						$em->andwhere('User.state like :airlineName or State.state_name like :state');
						$em->andwhere('User.type=2');
				 
					}
					else
					{
						$em->andwhere('User.state like :airlineName or State.state_name like :state');
						$em->andwhere('User.type=2');
					}
					$em->setParameter('airlineName', '%'.$stateCode.'%');
					$em->setParameter('state', '%'.$stateCode.'%');
					$condition = 1;
				}
				if( isset($address) && $address != '' )
		   		{
		   			if( $condition == 1 )
		   			{
						$em->andwhere('User.address like :address or City.city_name like :address or State.state_name like :address');
						$em->andwhere('User.type=2');
					}
				else
				{
					$em->Where('User.address like :address or City.city_name like :address or State.state_name like :address');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('address', '%'.$address.'%');
				$condition = 1;
			}
				
			if( isset($company) && $company != '' )
		   	{
		   		if( $condition == 1 )
		   		{
					$em->andwhere('User.business_name like :business');
					$em->andwhere('User.type=2');
				}
				else
				{
					$em->Where('User.business_name like :business');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('business', '%'.$company.'%');
				$condition = 1;
			}
			 
			if( isset($state) && $state != '' )
		   	{		
	   			if( $condition == 1 )
	   			{
					$em->andwhere('User.state_code like :state or State.state_name like :stateName');
					$em->andwhere('User.type=2');
				}
				else
				{
					$em->Where('User.state like :state or State.state_name like :stateName');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('state', '%'.$state.'%');
				$em->setParameter('stateName', '%'.$state.'%');
				$condition = 1;
			}
			
			
				
			if( isset($reviewCountMin) && isset($reviewCountMax) )
			{
				if( $condition == 1 )
		   		{
					$em->andwhere('Review.sender like :sender');
						$em->andwhere('User.type=2');
				}
				else
				{
		  			$em->Where('Review.sender like :sender');
		  				$em->andwhere('User.type=2');
				}
				$em->setParameter('sender', 'REVIEWER');
		  	}
		  	$em->addOrderBy('User.id');
		  	$em->setFirstResult($offset);
       			$em->setMaxResults($count_per_page);
		  	$airlines = $em->getQuery()->getArrayResult(); 
		 	
		
		}
		/*--End--Search Airline on basis of alphabets--*/

		foreach($airlines as $airline)
		{
			$arrAirlines[$airline['id']] = $airline;
			
			$filteredAirlineName = str_replace(' ', '-', $airline['business_name']);

			$filteredAirlineName = $filteredAirlineName.'-Reviews';

			$arrAirlines[$airline['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
		}

        return $this->render('RAAWebBundle:Page:searchAirlines.html.twig',array('search'=>$search,'address'=>$address,'airlineDetails'=>$arrAirlines,'totalAirlines'=> $totalAirlines,'adv'=>$adv,'stateCode'=>$stateCode,'latestReviewer'=>$arrReviewers,'alphabet'=>$alphabet,'total_pages'=>$total_pages,'current_page'=> $page,'countAirline'=>$countAirline,'search'=>$search,'alphabet'=>$alphabet));
	}
	/*---End Function-- Airline Search ---*/
	

	/*---Start Function-- get All Airlines ---*/	
	public function getAirlineNameAction()
	{
		$searchAirline = $_POST['id'];
		$html='';
		$html.='<ul>';
		$em = $this->getDoctrine()->getEntityManager();
 		$airlineName = $em->createQueryBuilder()
	      	->select('user')
	      	->from('RAAAdminBundle:User',  'user')
		->where('user.business_name like :airName')
		->setParameter('airName', $searchAirline.'%')
	      	->getQuery()
	      	->getArrayResult(); 
		foreach($airlineName as $airline)
		{
			$html.='<li id="'.$airline['business_name'].'" class="ajx_li" onclick="javascript:updateSearchValue(this.id);">'.$airline['business_name'].'</li>';
		}

		$html.='</ul>';
		return new response($html);
	}

	/*---End Function-- get All Airlines ---*/	

	




	/*---Start Function--count Search Airlines ---*/	
	public function countAirlinesAction()
	{
 		$alphabet='';
 		$stateCode='';	
//echo"<pre>";print_r($_POST);die;
		if(isset($_REQUEST['hidAlphabet']))
		{
	 		$alphabet=$_REQUEST['hidAlphabet'];
		}
		if(isset($_REQUEST['state']))
		{
	 		$stateCode=$_REQUEST['state'];
		}
		 
		$totalAirlines = 0;
		$condition = 0; 	
		$page = 1;
		$totalPages = 1;
		if( isset($_POST['hidReviewFilter1']) && $_POST['hidReviewFilter1'] != '' && isset($_POST['hidReviewFilter2']) && $_POST['hidReviewFilter2'] != '' )
    		{
	    		$reviewCountMin = $_POST['hidReviewFilter1'];
	    		$reviewCountMax = $_POST['hidReviewFilter2'];
    		}
    		$search = preg_replace('#[^a-z]#i', ' ', $this->get('request')->request->get('search'));
		$address=$this->get('request')->request->get('address'); 
		$state=$this->get('request')->request->get('state');  		
		$company=$this->get('request')->request->get('company');
		$rating=$this->get('request')->request->get('ratings');  	 
		if( !(isset($search)) && !(isset($address)) && !(isset($company)) && !(isset($rating)) && !(isset($reviewCountMax)) && !(isset($reviewCountMin)) )
		{
				$airlines = '';
		}
		else
  		{
  				
			$em = $this->getDoctrine()->getEntityManager()->createQueryBuilder();  		   		
			if( isset($reviewCountMin) && isset($reviewCountMax) )
			{
				$em->select('count(User.id)');
			}
			else
			{
					$em->select('count(User.id)');
				
				
			}
			$em->from('RAAAdminBundle:User', 'User');		
			//$em->leftJoin('RAAAdminBundle:City',  'City', "WITH", "User.city=City.id");
			//$em->leftJoin('RAAAdminBundle:State',  'State', "WITH", "User.state=State.state_code");
			if(isset($alphabet))
			{
				$em->where('User.business_name like :airlineFirstAlphabet');
				$em->andwhere('User.type=2');
				$em->setParameter('airlineFirstAlphabet', $alphabet.'%');
				
			}
		  	if( isset($search) && $search != '' )
		   	{
		   	
		   		if( $condition == 1 )
		   		{
					$em->andwhere('User.business_name like :airlineName');
				}
					
				else
				{
					if(isset($alphabet))
					{
						$em->andwhere('User.business_name like :airlineName');
					}
					else
					{
						$em->where('User.business_name like :airlineName');
					}
					$em->andwhere('User.type=2');
				}
					$em->setParameter('airlineName', '%'.$search.'%');
					$condition = 1;
				}
				if( isset($stateCode) && $stateCode != '' )
		   		{
		   			if( $condition == 1 )
		   			{
						$em->andwhere('User.state like :airlineName or State.state_name like :state');
						$em->andwhere('User.type=2');
				 
					}
					else
					{
						$em->andwhere('User.state like :airlineName or State.state_name like :state');
						$em->andwhere('User.type=2');
					}
					$em->setParameter('airlineName', '%'.$stateCode.'%');
					$em->setParameter('state', '%'.$stateCode.'%');
					$condition = 1;
				}
				if( isset($address) && $address != '' )
		   		{
		   			if( $condition == 1 )
		   			{
						$em->andwhere('User.address like :address or City.city_name like :address or State.state_name like :address');
						$em->andwhere('User.type=2');
					}
				else
				{
					$em->Where('User.address like :address or City.city_name like :address or State.state_name like :address');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('address', '%'.$address.'%');
				$condition = 1;
			}
				
			if( isset($company) && $company != '' )
		   	{
		   		if( $condition == 1 )
		   		{
					$em->andwhere('User.business_name like :business');
					$em->andwhere('User.type=2');
				}
				else
				{
					$em->Where('User.business_name like :business');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('business', '%'.$company.'%');
				$condition = 1;
			}
			 
			if( isset($state) && $state != '' )
		   	{		
	   			if( $condition == 1 )
	   			{
					$em->andwhere('User.state_code like :state or State.state_name like :stateName');
					$em->andwhere('User.type=2');
				}
				else
				{
					$em->Where('User.state like :state or State.state_name like :stateName');
					$em->andwhere('User.type=2');
				}
				$em->setParameter('state', '%'.$state.'%');
				$em->setParameter('stateName', '%'.$state.'%');
				$condition = 1;
			}
			
			
				
			if( isset($reviewCountMin) && isset($reviewCountMax) )
			{
				if( $condition == 1 )
		   		{
					$em->andwhere('Review.sender like :sender');
					$em->andwhere('User.type=2');
				}
				else
				{
		  			$em->Where('Review.sender like :sender');
		  			$em->andwhere('User.type=2');
				}
				$em->setParameter('sender', 'REVIEWER');
		  	}
		  	//echo $em->getQuery()->getSQL();die;
		  	$airlines = $em->getQuery()->getArrayResult(); 

			$userCount = $em->getQuery();

        		$airlines = $userCount->getSingleScalarResult();

       			return $airlines; 
		echo $airlines;die;
		}

	}

	/*---End Function--count Search Airlines ---*/	
 
 	/*---Start Function--Registration of Airline ---*/	
 	public function registrationAction(Request $request)
    	{
    		$em = $this->getDoctrine()
	    	->getEntityManager();
		if ($request->getMethod() == 'POST') 
    		{
    
			$firstname=$this->get('request')->request->get('firstname');
			$username=$this->get('request')->request->get('username');
			$lastname=$this->get('request')->request->get('lastname');
			$password=$this->get('request')->request->get('password');
			$email=$this->get('request')->request->get('email');
			$phone=$this->get('request')->request->get('phone');
			$repository = $em->getRepository('RAAAdminBundle:User');
			$emailCheck=$repository->findOneBy(array('email' => $email));//check email exists
	
			$existUser='Email exists';
           		if($emailCheck)
           		{
           		return $this->render('RAAWebBundle:Page:registration.html.twig',array('email'=>$existUser)); 
           		
           		}
			
			$type=3;
			$status=2;    	
			$pincode=$this->get('request')->request->get('pincode');
			$airline=new User();
			$airline->setFirstName($firstname);
			$airline->setLastName($lastname);
			$airline->setPassword(md5($password));
			$airline->setEmail($email);
			$airline->setUsername($username);
			$airline->setPhone($phone);
			$airline->setImage('default_user_image.jpeg');
			$airline->setType($type);
			$airline->setStatus($status);		
			$em->persist($airline);
			$em->flush(); 
			
			$revId = $airline->getId();
			$website_url = $this->container->getParameter('website_url');
			$confirmationLink= $website_url."confirmed/registration/".$revId;//confirmation link for registration
			/*--Start--Swift mailer--*/			
			$message = \Swift_Message::newInstance()
			    ->setSubject('Registration')
			    ->setFrom('support@reviewanairline.com')
			    ->setTo($email)
			    ->setBody($this->renderView('RAAWebBundle:Email:registration.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'email' => $email,'password'=>$password,'confirmationLink'=>$confirmationLink)));	
			$this->get('mailer')->send($message);
			/*--End--Swift mailer--*/	

		return $this->render('RAAWebBundle:Page:confirmRegistration.html.twig');    
	
		}
	  	return $this->render('RAAWebBundle:Page:registration.html.twig');            
	}
  	


    	/*---Start Function- show full profile of Airline -----*/	
  	public function showProfileAction(Request $request,$id)
 	{
		$arrAirlineName = explode('-reviews', $id);
		$filteredAirlineName = $arrAirlineName[0];
		$airlineName = trim(ucwords(str_replace('-', ' ', $filteredAirlineName)));
		$fullUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$em = $this->getDoctrine()->getEntityManager();	
		
		/*--Start--fetch airline data--*/	
		$airlineData = $em->createQueryBuilder()
	     	->select("user")
	     	->from('RAAAdminBundle:User', 'user')
	     	->where('user.business_name like :airlineName')
		->setParameter('airlineName', $airlineName)
		->getQuery()
		->getArrayResult();
		/*--End--fetch airline data--*/	
		
		/*--Start--fetch history of all airlines--*/	
		$id = $airlineData[0]['id'];
//echo"<pre>";print_r($id);die;
		$detail = $em->createQueryBuilder()
	     	->select("detail")
	     	->from("RAAWebBundle:AirlineDetail", "detail")
	     	->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=detail.airline_id")
		->where('user.business_name like :airlineName')
		->andwhere('detail.left_tab_heading = :leftTabHeading')
		->setParameter('airlineName', $airlineName)
		->setParameter('leftTabHeading', 'History')
		->getQuery()
		->getArrayResult();
		/*--End--fetch history of all airlines--*/

		/*--Start--fetch airline Images for slider--*/
		$airlineImages = $em->createQueryBuilder()
	     	->select("Images")
	     	->from("RAAWebBundle:AirlineImages", "Images")
	     	->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=Images.airline_id")
		->where('user.business_name like :airlineName')
		->setParameter('airlineName', $airlineName)
		->getQuery()
		->getArrayResult();
		/*--End--fetch airline Images for slider--*/
	 	
		if( isset($airlineImages) && is_array($airlineImages) && count($airlineImages) > 0 )
		{
			$defaultAirlineImage = '';
		}
		else
		{
			$defaultAirlineImage = 'No information available';
		}
						
		$airline = $em->getRepository('RAAAdminBundle:User')->find($id);
		if (!$airline) 
		{
		    throw $this->createNotFoundException('Unable to find  airline.');
		}

      		/*--Start--count Reviews of airline--*/
		$senderType='REVIEWER';
		$countReview = $em->createQueryBuilder()
		->select("rev.sender,count(rev.id) AS totalReviews,rev.reviewer_id,rev.parent_id,rev.airline_id,user.first_name,user.last_name,rev.description,rev.rating,rev.creation_timestamp")
		->from("RAAWebBundle:Review", "rev")
		->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=rev.reviewer_id")
		->where('rev.airline_id = :airlineId')
		->andwhere('rev.status = 1')
		->andWhere('rev.sender = :senderType')
		->setParameter('senderType', $senderType)
		->setParameter('airlineId', $id)
		->getQuery()
		->getArrayResult(); 	
		$passengerReview = array('totalReviews' => $countReview[0]['totalReviews']);
		/*--End--count Reviews of airline--*/
		
		/*--Start--count Reviews of reviewer--*/
		$reviewCounta = $em->createQueryBuilder()
		->select("count(rev.id) as reviewsCount")
		->from("RAAWebBundle:Review", "rev")
		->where('rev.airline_id = :airlineId')
		->andwhere('rev.status = 1')
		->andWhere('rev.sender = :senderType')
		->setParameter('senderType', $senderType)
		->setParameter('airlineId', $id)
		->getQuery()
		->getArrayResult();
		$reviews = $reviewCounta[0]['reviewsCount'];
		/*--End--count Reviews of reviewer--*/
	
		/*--Start--pagination of airline reviews--*/
		$page = $request->get('page');
		$count_per_page = 5;
		$total_count = $reviews;
		$total_pages=ceil($total_count/$count_per_page);
		if(!is_numeric($page)){
		    $page=1;
		}
		else{
		    $page=floor($page);
		}
		if($total_count<=$count_per_page){
		    $page=1;
		}
		if(($page*$count_per_page)>$total_count){
		    $page=$total_pages;
		}
		$offset=0;
		if($page>1){
		    $offset = $count_per_page * ($page-1);
		}
		/*--Start--pagination of airline reviews--*/

		/*--Start--Shows reviews of all airlines--*/
		$reviewProcess = $em->createQueryBuilder()
		->select("count(rev.reviewer_id) As totalReviewes,rev.sender,rev.id,rev.reviewer_id,rev.parent_id,rev.airline_id,user.username,rev.headline,rev.reviewer_image,user.image,user.first_name,user.last_name,user.business_name,rev.description,rev.rating,rev.creation_timestamp")
		->from("RAAWebBundle:Review", "rev")
		->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=rev.reviewer_id")
		->where('rev.airline_id = :airlineId')
		->andwhere('rev.status = 1')
		->andWhere('rev.sender = :senderType')
		->setParameter('senderType', $senderType)
		->setParameter('airlineId', $id)
		->groupBy('rev.reviewer_id')
		->getQuery()
		->setFirstResult($offset)
        	->setMaxResults($count_per_page)
		->getArrayResult();
		//echo"<pre>";print_r($reviewProcess);die;
		$arrReviewer = array();
	
		if(count($reviewProcess)>0)	
		{	
			$rev_id =  $reviewProcess[0]['reviewer_id'];
			foreach($reviewProcess as $reviewerDetail)
			{
				$imageUrl = '';
				$image = $reviewerDetail['image'];
				$imageUrl = $this->getImageUrlAction($image);
				$arrReviewer[$reviewerDetail['id']] = $reviewerDetail;
				$arrReviewer[$reviewerDetail['id']]['reviewerImage'] = $imageUrl;
			}
		}
		else
		{
			$rev_id =  0;
		}
		/*--End--Shows reviews of all airlines--*/

		foreach($arrReviewer as $reviewer)
		{
			$arrReviewers[$reviewer['id']] = $reviewer;
			
			$filteredAirlineName = str_replace(' ', '-', $airline->business_name);
			$filteredHeadline = str_replace(' ', '-', $reviewer['headline']);

			$filteredAirlineName = $filteredAirlineName.'-Reviews';

			$airline->filteredAirlineName = strtolower($filteredAirlineName);

			$arrReviewers[$reviewer['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
			$arrReviewers[$reviewer['id']]['filteredHeadline'] = strtolower($filteredAirlineName.'-'.$filteredHeadline);
		}
		
		/*--Start--Get average rating of airline--*/
		$em = $this->getDoctrine()->getEntityManager();
	     	$review = $em->createQueryBuilder()
	     	->select("avg(rev.rating) as avgRating")
	     	->from("RAAWebBundle:Review", "rev")
		->where('rev.airline_id = :airlineId')
		->setParameter('airlineId', $id)
		->getQuery()
		->getArrayResult(); 
		/*--End --Get average rating of airline--*/

		if(isset($arrReviewers) && is_array($arrReviewers) && count($arrReviewers)>0)
		{}
		else
		{
			$arrReviewers = $arrReviewer;
		}

        	return $this->render('RAAWebBundle:Page:profile.html.twig', array(
            'airline'      => $airline,'review'=>$review,'passengerReview'=>$passengerReview,'reviewProcess'=>$arrReviewers,'total_pages'=>$total_pages,'current_page'=> $page,'detail'=>$detail,'airlineImages'=>$airlineImages,'defaultAirlineImage'=>$defaultAirlineImage,'fullUrl'=>$fullUrl
        ));
    }
  	/*---End Function- show full profile of Airline -----*/		
  	
  	
  	/*---Start Function- Write Review Page -----*/	
 	public function showReviewsAction($id)
 	{
		$em = $this->getDoctrine()->getEntityManager();
 		$airlineId=$id;
  		
 		$type='REVIEWER';

		/*---Start - Most recent reviews -----*/	
 		$reviews = $em->createQueryBuilder()
      		->select('user.first_name,user.last_name,latestReview.description,user.business_name,latestReview.id,latestReview.headline,latestReview.rating,latestReview.airline_id,latestReview.creation_timestamp,latestReview.reviewer_id,latestReview.creation_timestamp')
	      	->from('RAAWebBundle:Review',  'latestReview')
	      	->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=latestReview.airline_id")
	      	->where('latestReview.sender=:type')
	      	->andwhere('latestReview.status=1')
		->setParameter('type', $type)
	      	->addOrderBy('latestReview.id', 'DESC')
		->setMaxResults(3)
	      	->getQuery()
	      	->getArrayResult(); 
 		$arrReviewer = array();
		$repository = $em->getRepository('RAAAdminBundle:User');
		foreach($reviews as $reviewer)
		{
			$reviewId = $reviewer['id'];
			$arrReviewer[$reviewId]['id'] =  $reviewer['id'] ;
			$arrReviewer[$reviewId]['first_name'] =  $reviewer['first_name'] ;
			$arrReviewer[$reviewId]['last_name'] =  $reviewer['last_name'] ;
			$arrReviewer[$reviewId]['description'] =  $reviewer['description'] ;
			$arrReviewer[$reviewId]['business_name'] =  $reviewer['business_name'] ;
			$arrReviewer[$reviewId]['rating'] =  $reviewer['rating'] ;
			$arrReviewer[$reviewId]['headline'] =  $reviewer['headline'] ;
			$arrReviewer[$reviewId]['creation_timestamp'] =  $reviewer['creation_timestamp'] ;
			$arrReviewer[$reviewId]['airline_id'] =  $reviewer['airline_id'] ;
			$arrReviewer[$reviewId]['reviewer_id'] =  $reviewer['reviewer_id'] ;
			$user = $repository->findOneBy(array('id' =>  $reviewer['reviewer_id']));
			if($user)	
				$reviewerName=$user->getFirstName()." ".$user->getLastName();
			else
				$reviewerName='';
			$arrReviewer[$reviewId]['reviewer_name'] =  $reviewerName ;
		
		}
		/*---End - Most recent reviews -----*/
		foreach($arrReviewer as $reviewer)
		{
			$arrReviewers[$reviewer['id']] = $reviewer;
			$filteredAirlineName = str_replace(' ', '-', $reviewer['business_name']);
			$filteredHeadline = str_replace(' ', '-', $reviewer['headline']);
			$filteredAirlineName = $filteredAirlineName.'-Reviews';
			$arrReviewers[$reviewer['id']]['filteredAirlineName'] = strtolower($filteredAirlineName);
			$arrReviewers[$reviewer['id']]['filteredHeadline'] = strtolower($filteredAirlineName.'-'.$filteredHeadline);
		}
 
 		if($airlineId=='0')
 		{
  			return $this->render('RAAWebBundle:Page:writeReviews.html.twig', array('reviews'=>$arrReviewers,'airlineId'=>$airlineId
        ));
 		}
 	
        	$airline = $em->getRepository('RAAAdminBundle:User')->find($id);
       		if (!$airline) 
        	{
            	
        	}
        	
	
		return $this->render('RAAWebBundle:Page:writeReviews.html.twig', array(
            'airline'      => $airline,'reviews'=>$arrReviewers,'airlineId'=>$airlineId,
        ));
    } 
  /*---End Function- Write Review Page -----*/	

	/*---Start Function- Check Email of Reviewer-----*/		  
    	public function checkEmailExistanceAction(Request $request)
	 { 
 		$email = $_POST['email'];
 		$em = $this->getDoctrine()
        	->getEntityManager();
    		$repository = $em->getRepository('RAAAdminBundle:User');
    		 $user = $repository->findOneBy(array('email' => $email));
    		if($user)
    		{
    			$html = '';
			$html.='Email is already registered ';
			return new response($html);
    		}
    		else
    		{
    			return new response('SUCCESS');
    		}
 	}
       /*---End Function- Check Email of Reviewer-----*/	
   	 
	/*----Start Function- capture email of reviewr -----*/
 	public function captureEmailAction(Request $request,$id)
 	{ 
		$em = $this->getDoctrine()->getEntityManager();
		$gbl_email_administrator = $this->container->getParameter('gbl_email_administrator');//get email of administrator
		$website_url = $this->container->getParameter('website_url');//get url of website
		$reviewDateTime = new DateTime();
		$airlineId=$this->get('request')->request->get('airlineReview');
		$airlineName=$this->get('request')->request->get('search');
		$departureCity=$this->get('request')->request->get('departureCity');
		$destinationCity=$this->get('request')->request->get('destinationCity');
		$stars=$this->get('request')->request->get('stars');
		$starH=$this->get('request')->request->get('starH');
		$starR=$this->get('request')->request->get('starR');
		$starM=$this->get('request')->request->get('starM');
		$starL=$this->get('request')->request->get('starL');
	 	$starG=$this->get('request')->request->get('starG');
		$starQ=$this->get('request')->request->get('starQ');
		$travel=$this->get('request')->request->get('recagent');
		$trip=$this->get('request')->request->get('trip');
		$headline=$this->get('request')->request->get('headline');
		$writereview=$this->get('request')->request->get('writereview');
		$agent=$this->get('request')->request->get('agent');
		$receiveUpdates= $this->get('request')->request->get('receiveUpdates')=='on' ? 1 : 0;
		$recommend=$this->get('request')->request->get('recomend');
		
		/*----Start - When reviewr is Logged In-----*/
		$session = $this->getRequest()->getSession();
		if( $session->get('userId') && $session->get('userId') != '' )
		{	
			/*---Start - fetch detail of reviewer -----*/	
			$reviewerName = $em->createQueryBuilder()
		      	->select('user')
		      	->from('RAAAdminBundle:User',  'user')
		      	->where('user.id=:id')
			->setParameter('id',$session->get('userId'))
		      	->getQuery()
		      	->getArrayResult(); 
			$firstname = $reviewerName[0]['first_name'];
			$emailReviewer = $reviewerName[0]['email'];
			$lastname = $reviewerName[0]['last_name'];
			/*---End - fetch detail of reviewer -----*/

			/*---Start - Store a new review in database -----*/
			$file = $_FILES['revImage']['name'];
			$file1  = $_FILES['revImage']['tmp_name'];  
			move_uploaded_file($_FILES["revImage"]["tmp_name"],
			"images/Airline/" . $_FILES["revImage"]["name"]);
			$rating=new Review();
			$rating->setHeadline($headline);
			$rating->setDescription($writereview);
			$rating->setUseAgent($agent);
			$rating->setReceiveUpdates($receiveUpdates);
			$rating->setDepartureCity($departureCity);
	 		$rating->setDestinationCity($destinationCity);
			$rating->setRecomendAgent($recommend);
			$rating->setRating($stars);
			$rating->setReviewerId($session->get('userId'));
			$rating->setcreationTimestamp($reviewDateTime);
			if($airlineId)
			{
				$rating->setAirlineId($airlineId);
			}
			else
			{
				$rating->setAirlineId($id);
			}
			$rating->setHonesty($starH);
			$rating->setTravel($travel);
			$rating->setTrip($trip);
			$rating->setSender('REVIEWER');
			$rating->setStatus(2);
			$rating->setHonesty($starH);
			$rating->setMarketKnowldege($starL);
			$rating->setSoldPrice($starH);
			$rating->setResponsiveness($starR);
			$rating->setService($starM);
			$rating->setSoldQuickly($starQ);
			$rating->setReviewerImage($file);
			$em->persist($rating);
			$em->flush();
			/*---End - Store a new review in database -----*/
			$reviewId=$rating->getId();//get last inserted id of reviewer
			$confirmationLink= $website_url."approve/review/".$reviewId;//review link
			
			/*---Start - swift mailer for approve review -----*/
			$message = \Swift_Message::newInstance()
		    	->setSubject('Review')
		    	->setFrom($emailReviewer)
		    	->setTo($gbl_email_administrator)
		    	->setBody($this->renderView('RAAWebBundle:Email:review.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'writereview'=>$writereview,'airlineName'=>$airlineName,'confirmationLink'=>$confirmationLink,'stars'=>$stars)));
		$this->get('mailer')->send($message);
		/*---Start - swift mailer for approve review -----*/
			
		return $this->render('RAAWebBundle:Page:confirmationLink.html.twig');
		
	 	}
		/*----End - When reviewer is Logged In-----*/
 		$website_url = $this->container->getParameter('website_url');
		
		if ($request->getMethod() == 'POST') 
	    	{
		 	$file = $_FILES['revImage']['name'];
	   		$file1  = $_FILES['revImage']['tmp_name'];  
	    		move_uploaded_file($_FILES["revImage"]["tmp_name"],
	      		"images/Airline/" . $_FILES["revImage"]["name"]);
		    	$phone=$this->get('request')->request->get('phone');
			$fbFirstName=$this->get('request')->request->get('fbFirstName');
			$fbLastName=$this->get('request')->request->get('fbLastName');
			$fbUserFullName=$this->get('request')->request->get('fbUserFullName');
			$fbEmail=$this->get('request')->request->get('fbEmail');
			$fbUserprofpic=$this->get('request')->request->get('fbpimage');
			$fbId=$this->get('request')->request->get('user_form_email');

			/*----Start - When Guest is Register-----*/
			if($fbEmail=="")
			{
				$firstname=$this->get('request')->request->get('firstname');
				$lastname=$this->get('request')->request->get('lastname');
				$email=$this->get('request')->request->get('email');
				$phone=$this->get('request')->request->get('phone');
				$airlineId=$this->get('request')->request->get('airlineReview');
				$departureCity=$this->get('request')->request->get('departureCity');
				$destinationCity=$this->get('request')->request->get('destinationCity');
				$stars=$this->get('request')->request->get('stars');
				$starH=$this->get('request')->request->get('starH');
				$starR=$this->get('request')->request->get('starR');
				$starM=$this->get('request')->request->get('starM');
				$starL=$this->get('request')->request->get('starL');
			  	$starG=$this->get('request')->request->get('starG');
				$starQ=$this->get('request')->request->get('starQ');
				$travel=$this->get('request')->request->get('recagent');
				$trip=$this->get('request')->request->get('trip');
				$headline=$this->get('request')->request->get('headline');
				$writereview=$this->get('request')->request->get('writereview');
				$agent=$this->get('request')->request->get('agent');
				$receiveUpdates= $this->get('request')->request->get('receiveUpdates')=='on' ? 1 : 0;
				$recommend=$this->get('request')->request->get('recomend');
				$type=3;
				$status=1;
				$sysPwd= $this->generateRandomString(8);
		   		$repository = $em->getRepository('RAAAdminBundle:User');
		    		$user = $repository->findOneBy(array('email' => $email));

				/*---Start - Register new Reviewer -----*/
				$reviewer=new User();
				$reviewer->setFirstName($firstname);
				$reviewer->setLastName($lastname);
				$reviewer->setEmail($email);
				$reviewer->setPassword(md5($sysPwd));
				$reviewer->setPhone($phone);
				$reviewer->setType($type);
				$reviewer->setStatus($status);
				$em->persist($reviewer);
				$em->flush();
				/*---End - Register new Reviewer -----*/

				$reviewerId=$reviewer->getId();//last inserted id of reviewer
				$website_url = $this->container->getParameter('website_url');//get website url
				$confirmationLink= $website_url."confirmed/registration/".$reviewerId;//registration link
				/*---Start - Swift mailer for registration -----*/
				$message = \Swift_Message::newInstance()
			    	->setSubject('Registration')
			    	->setFrom('support@reviewanairline.com')
			    	->setTo($email)
			   	->setBody($this->renderView('RAAWebBundle:Email:registration.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'email' => $email,'password'=>$sysPwd,'confirmationLink'=>$confirmationLink)));
			$this->get('mailer')->send($message);	 
			/*---End - Swift mailer for registration -----*/
				
			/*---Start - add new Review -----*/			
			$reviewDateTime = new DateTime();
			
			$rating=new Review();
			$rating->setHeadline($headline);
			$rating->setDescription($writereview);
			$rating->setUseAgent($agent);
			$rating->setReceiveUpdates($receiveUpdates);
			$rating->setRecomendAgent($recommend);
		  	$rating->setDepartureCity($departureCity);
		   	$rating->setDestinationCity($destinationCity);
			$rating->setRating($stars);
			$rating->setReviewerId($reviewerId);
			$rating->setcreationTimestamp($reviewDateTime);
			if($airlineId)
			{$em = $this->getDoctrine()->getEntityManager();
			$rating->setAirlineId($airlineId);
			}
			else
			{
			$rating->setAirlineId($id);
			}
			$rating->setSender('REVIEWER');
			$rating->setStatus(2);
			$rating->setHonesty($starH);
			$rating->setTravel($travel);
			$rating->setTrip($trip);
			$rating->setMarketKnowldege($starL);
			$rating->setSoldPrice($starH);
			$rating->setResponsiveness($starR);
			$rating->setService($starM);
			$rating->setSoldQuickly($starQ);
			$rating->setReviewerImage($file);
			$em->persist($rating);
			$em->flush();
			/*---End - add new Review -----*/

			$reviewId=$rating->getId();
			if(!isset($emailReviewer))
			$emailReviewer = $email;
			
			$confirmationLink= $website_url."approve/review/".$reviewId;//review link

			/*---Start - swift mailer for approve review -----*/
			$messageAdmin = \Swift_Message::newInstance()
			    ->setSubject('Review')
			    ->setFrom($emailReviewer)
			    ->setTo($gbl_email_administrator)
			    ->setBody($this->renderView('RAAWebBundle:Email:review.txt.twig', array('firstname'=>$firstname,'lastname'=>	$lastname,'writereview'=>$writereview,'airlineName'=>$airlineName,'confirmationLink'=>$confirmationLink,'stars'=>$stars)));
			$this->get('mailer')->send($messageAdmin);
			/*---End - swift mailer for approve review -----*/

			return $this->render('RAAWebBundle:Page:reviewRegistration.html.twig'); 
			/*----End - When Guest is Register-----*/

			/*----Start - When Guest is Logged with facebook-----*/
			}
			else
			{
				$firstname=$fbFirstName;
				$lastname=$fbLastName;
				$email=$fbEmail;
				$fbUserprofpic=$this->get('request')->request->get('fbpimage');
				$fbId=$this->get('request')->request->get('user_form_email');
				$session->set('fbId', $fbId);
				$session->set('fbUserprofpic', $fbUserprofpic); 
			}
			$airlineId=$this->get('request')->request->get('airlineReview');
			$departureCity=$this->get('request')->request->get('departureCity');
			$destinationCity=$this->get('request')->request->get('destinationCity');
			$stars=$this->get('request')->request->get('stars');
			$starH=$this->get('request')->request->get('starH');
			$starR=$this->get('request')->request->get('starR');
			$starM=$this->get('request')->request->get('starM');
			$starL=$this->get('request')->request->get('starL');
		  	$starG=$this->get('request')->request->get('starG');
			$starQ=$this->get('request')->request->get('starQ');
			$travel=$this->get('request')->request->get('recagent');
			$trip=$this->get('request')->request->get('trip');
			$headline=$this->get('request')->request->get('headline');
			$writereview=$this->get('request')->request->get('writereview');
			$agent=$this->get('request')->request->get('agent');
			$receiveUpdates= $this->get('request')->request->get('receiveUpdates')=='on' ? 1 : 0;
			$recommend=$this->get('request')->request->get('recomend');
			$type=3;
			$status=1;
			$sysPwd= $this->generateRandomString(8);
	   		$repository = $em->getRepository('RAAAdminBundle:User');
	    		$user = $repository->findOneBy(array('email' => $email));
			/*---Start - Add Facebook User -----*/
			$reviewer=new User();
			$reviewer->setFirstName($firstname);
			$reviewer->setLastName($lastname);
			$reviewer->setEmail($email);
			$reviewer->setPassword(md5($sysPwd));
			$reviewer->setPhone($phone);
			$reviewer->setImage($fbUserprofpic);
			$reviewer->setfacebookId($fbId);
			$reviewer->setType($type);
			$reviewer->setStatus($status);
			$em->persist($reviewer);
			$em->flush();
			/*---End - Add Facebook User -----*/

			/*---Start - Login Facebook User -----*/
			$reviewerId=$reviewer->getId();
			$session = $this->getRequest()->getSession(); 
			$session->set('userId', $reviewerId);  
			$session->set('userEmail', $email);
          		$session->set('userName', $firstname);
          	 	$session->set('userType', $type);	
  			 $facebookRepository = $em->getRepository('RAAAdminBundle:User');
			$userLogin = $facebookRepository->findOneBy(array('email' => $email, 'facebook_id' =>$fbId,'type'=>3,'status'=>1));
			/*---End - Login Facebook User -----*/
			
			/*---Start - Add  a new Reviewer -----*/
			
			$website_url = $this->container->getParameter('website_url');
			$confirmationLink= $website_url."confirmed/registration/".$reviewerId;
			$reviewDateTime = new DateTime();
			$rating=new Review();
			$rating->setHeadline($headline);
			$rating->setDescription($writereview);
			$rating->setUseAgent($agent);
			$rating->setReceiveUpdates($receiveUpdates);
			$rating->setRecomendAgent($recommend);
		  	$rating->setDepartureCity($departureCity);
			$rating->setDestinationCity($destinationCity);
			$rating->setRating($stars);
			$rating->setReviewerId($reviewerId);
			$rating->setcreationTimestamp($reviewDateTime);
			if($airlineId)
			{
			$rating->setAirlineId($airlineId);
			}
			else
			{
			$rating->setAirlineId($id);
			}
			$rating->setSender('REVIEWER');
			$rating->setStatus(2);
			$rating->setHonesty($starH);
			$rating->setTravel($travel);
			$rating->setTrip($trip);
			$rating->setMarketKnowldege($starL);
			$rating->setSoldPrice($starH);
			$rating->setResponsiveness($starR);
			$rating->setService($starM);
			$rating->setSoldQuickly($starQ);
			$rating->setReviewerImage($file);
		
			$em->persist($rating);
			$em->flush();
			/*---End - Add  a new Reviewer -----*/

			/*---Start - swift mailer for approve review -----*/
			$reviewId=$rating->getId();
			$confirmationLink= $website_url."approve/review/".$reviewId;
			$messageAdmin = \Swift_Message::newInstance()
		   	->setSubject('Review')
		    	->setFrom($email)
		   	->setTo($gbl_email_administrator)
		   	->setBody($this->renderView('RAAWebBundle:Email:review.txt.twig', array('firstname'=>$firstname,'lastname'=>	$lastname,'writereview'=>$writereview,'airlineName'=>$airlineName,'confirmationLink'=>$confirmationLink,'stars'=>$stars)));
		$this->get('mailer')->send($messageAdmin);
			/*---End - swift mailer for approve review -----*/
			if($userLogin)
			{
				return $this->redirect($this->generateUrl('raa_web_home'));   
			}
		}
		
		return $this->render('RAAWebBundle:Page:reviewRegistration.html.twig');   
	 }
	/*----End - When Guest is Logged In with facebook-----*/

		/*----Start Function - Logged In With facebook-----*/
		function facebookLoginAction(Request $request)
		{
			$session = $this->getRequest()->getSession();
			$em = $this->getDoctrine()->getEntityManager();
			$type=1;
			$status=1;
			$fbFirstName=$this->get('request')->request->get('fbFirstName');
			$fbLastName=$this->get('request')->request->get('fbLastName');
			$fbUserFullName=$this->get('request')->request->get('fbUserFullName');
			$fbEmail=$this->get('request')->request->get('fbEmail');
			$fbUserprofpic=$this->get('request')->request->get('fbpimage');
			$fbId=$this->get('request')->request->get('user_form_email');
			$session->set('fbId', $fbId);
			$session->set('fbUserprofpic', $fbUserprofpic); 
			/*---Start - Add new Facebook User -----*/
			$reviewer=new User();
			$reviewer->setFirstName($fbFirstName);
			$reviewer->setLastName($fbLastName);
			$reviewer->setEmail($fbEmail);
			$reviewer->setImage($fbUserprofpic);
			$reviewer->setfacebookId($fbId);
			$reviewer->setType($type);
			$reviewer->setStatus($status);
			$em->persist($reviewer);
			$em->flush();
			/*---End - Add new Facebook User -----*/
			
			/*---Start - Facebook LoggedIn -----*/
			$reviewerId=$reviewer->getId();
			$session = $this->getRequest()->getSession(); 
			$session->set('userId', $reviewerId);  
			$session->set('userEmail', $fbEmail);
          		$session->set('userName', $fbFirstName);
          	 	$session->set('userType', $type);	
  			$facebookRepository = $em->getRepository('RAAAdminBundle:User');
			$userLogin = $facebookRepository->findOneBy(array('email' => $fbEmail, 'facebook_id' =>$fbId,'type'=>3,'status'=>1));
			if($userLogin)
			{
				return $this->redirect($this->generateUrl('raa_web_home'));   

			}
			/*---End - Facebook LoggedIn -----*/
			return $this->redirect($this->generateUrl('raa_web_home'));   

	}
	/*----End Function - Logged In With facebook-----*/

	/*----Start Function - Genrate Random Password-----*/
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
	/*----End Function - Genrate Random Password-----*/
	
	/*----Start Function - Approve Review -----*/
	public function confirmationEmailAction(Request $request,$id) 
	{	
      		$em = $this->getDoctrine()
	   	 ->getEntityManager();
		$plan = $em->createQueryBuilder() 
		->select('Review')
		->update('RAAWebBundle:Review',  'Review')
		->set('Review.status', ':status')
		->setParameter('status', 1)
		->where('Review.reviewer_id = :id')
		->setParameter('id', $id)
		->getQuery()
		->getResult(); 
		return $this->render('RAAWebBundle:Page:confirmationEmail.html.twig');
	}	
	/*----End Function - Approve Review -----*/
	
	/*----Start Function - Show Cms for navigation bar-----*/
	public function showCmsAction(Request $request)
	{  		
		$html='';
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RAAAdminBundle:CMS',  'cms')
		->where('cms.type=1')
		->getQuery()
		->getResult();
		
		foreach ($cms as $cms)
		{
  			$html.='<li>'.'<a href="/reviewanairline.com/web/page'.$cms->id.'">'.$cms->name.'</a>'.'</li>';
		}
				
		return new response($html); 

	}
	/*----End Function - Show Cms for navifgation bar-----*/

	/*----Start Function - Show content of Cms-----*/
	public function pageAction(Request $request,$id)
	{  
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms.content,cms.name')
		->from('RAAAdminBundle:CMS',  'cms')
		->where('cms.id=:id')			
		->setParameter('id',$id)
		->getQuery()
		->getArrayResult();
		return $this->render('RAAWebBundle:Page:page.html.twig',array('cms'=>$cms)); 

	}
	/*----End Function - Show content of Cms-----*/

	/*----Start Function -  Fetch Banner-----*/
	public function getBannerAction(Request $request)
	{
		$html='<div id="myGallery">';
		$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->createQueryBuilder()
		->select('adv')
		->from('RAAAdminBundle:Advertiesment',  'adv')
		->where('adv.type=:type')
		->setParameter('type',"BAN")
		->getQuery()
		->getResult();
		foreach($adv as $advertisement)
		{
			$html.='<a href="'.$advertisement->target_url.'"><img src="'.$this->container->getParameter('website_url').'/images/Airline/'.$advertisement->image.'" class="Cont_css AdvImg active1"   alt="Banner" class=""/></a>';
		
		}
		$html.='</div>';
		return new response($html);

	}
	/*----End Function -  Fetch Banner-----*/

	/*----Start Function -  Fetch Advertiesment-----*/

	public function getAdvertiesmentAction(Request $request)
	{
		$html='<div id="myGallery">';
		$em = $this->getDoctrine()->getEntityManager();
		$adv = $em->createQueryBuilder()
		->select('adv')
		->from('RAAAdminBundle:Advertiesment',  'adv')
		->where('adv.type=:type')
		->setParameter('type',"ADV")
		->getQuery()
		->getResult();
		foreach($adv as $advertisement)
		{
			$html.='<a href="'.$advertisement->target_url.'"><img src="'.$this->container->getParameter('website_url').'/images/Airline/'.$advertisement->image.'" class="Cont_css bannerImg active1"   alt="Advertisement" class=""/></a>';
		
		}
		$html.='</div>';
		return new response($html);

	}
	/*----End Function -  Fetch Advertiesment-----*/

	/*----Start Function -  Get All Airlines-----*/

	public function getAllAirlinesAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$airlines = $em->createQueryBuilder()
		->select("airline")
		->from("RAAAdminBundle:User", "airline")   	     	  	
		->getQuery()
		->getArrayResult();
		return $airlines;
	}

	/*----End Function -  Get All Airlines-----*/

	/*----Start Function -  Get Airline Detail-----*/
	public function airlineDetailAction()
	{
		$html='';
		$a = $_POST['stateCode'];
		$em = $this->getDoctrine()->getEntityManager();
		$airlines = $em->createQueryBuilder()
		->select("airline")
		->from("RAAAdminBundle:User", "airline") 
		->where('airline.business_name = :businessName')
		->setParameter('businessName', $a)
		->getQuery()
		->getArrayResult();
		$url = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
		$arrUrl = explode('airlineDetail', $url);
		$url = $arrUrl[0];
		
		$html.='
			<div class="image-box" id="divImgBox">
          		<div class="image" style="height:132px; width:171px;">';
	if( file_exists($url."Airline/".$airlines[0]['logo']) )
		$html.='<img id="airlineLogo" src="'.'/images/Airline/'.$airlines[0]['logo'].'"  alt="image not found" class="large" />';
		
	else
	{
		if( file_exists($url."images/Airline/".$airlines[0]['logo_tile']) )
			$html.='<img id="airlineLogo" src="'.'images/Airline/'.$airlines[0]['logo_tile'].'"  alt="image not found" class="large" />';
		else
			$html.='<img id="airlineLogo" src="'.'images/Airline/no_photo.jpg"  alt="image not found" class="large" />';
	}
 $html.='</div>
      </div>

	<div class="content-box" id="divRatingBox">
<input type=hidden  name="airlineReview" value='.$airlines[0]['id'].'>
     <div itemprop="name" id="agent-to-review-name">'.$airlines[0]['business_name'].'</div>
        <div id="agent-to-review-agency">'.$airlines[0]['category1'].'</div>
        <div id="agent-overall-rating-wrapper ">
          <div class="review-star-line " id="agent-overall-rating">
            <div class="star-group-left"> 
            <div id="ratingsForm">
							<div class="stars5">
								<input type="radio" name="stars" class="star-1" id="star-11" value=1 />
								<label class="star-1" for="star-11">1</label>
								<input type="radio" name="stars" class="star-2" id="star-12" value=2 />
								<label class="star-2" for="star-12">2</label>
								<input type="radio" name="stars" class="star-3" id="star-13" value=3 />
								<label class="star-3" for="star-13">3</label>
								<input type="radio" name="stars" class="star-4" id="star-14" value=4 />
								<label class="star-4" for="star-14">4</label>
								<input type="radio" name="stars" class="star-5" id="star-15" value=5 />
								<label class="star-5" for="star-15">5</label>
							
								<span></span>
								</div>
									</div>
			</div>
		  </div>
		  
		
          <div id="star-rating-text" style="font-size:14px;"><b>Click the stars to rate airline!</b></div>
        </div>
      </div>';
      

return new response($html);
}
/*----End Function -  Get Airline Detail-----*/

	/*----Start Function -  Show  Review Detail-----*/	
	public function detailsReviewAction($id)
	{
		$arrAirlineName = explode('-reviews-', $id);
		$filteredHeadline = $arrAirlineName[1];
		$reviewHeadline = ucwords(str_replace('-', ' ', $filteredHeadline));
		$reviewId = $id[0];
		$em = $this->getDoctrine()->getEntityManager();

		/*---Start - Fetch Reviewer Detail-----*/
		$reviewDetail = $em->createQueryBuilder()
	     	->select("rev.id, rev.airline_id,user.first_name")
	     	->from("RAAWebBundle:Review", "rev")
		->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=rev.reviewer_id")
		->where('rev.headline like :reviewHeadline')
		->setParameter('reviewHeadline', $reviewHeadline)
		->getQuery()
		->getArrayResult();
		$reviewId = $reviewDetail[0]['id'];
		$airlineId = $reviewDetail[0]['airline_id'];
		$reviewrName = $reviewDetail[0]['first_name'];
		/*---End - Fetch Reviewer Detail-----*/
		   		
		$airline = $em->getRepository('RAAAdminBundle:User')->find($airlineId);//get airline details 
          	$airlinesReview = $em->getRepository('RAAWebBundle:Review')->find($reviewId);//get reviewer details
        	if (!$airline) 
        	{
            		throw $this->createNotFoundException('Unable to find  airline.');
        	}
		$filteredAirlineName = str_replace(' ', '-', $airline->business_name);
		$filteredAirlineName = $filteredAirlineName.'-Reviews';
		$airline->filteredAirlineName = strtolower($filteredAirlineName);
		
		/*---Start - Fetch average rating of airline-----*/
		$em = $this->getDoctrine()->getEntityManager();
	     	$review = $em->createQueryBuilder()
	     	->select("avg(rev.rating) as avgRating")
	     	->from("RAAWebBundle:Review", "rev")
		->where('rev.airline_id = :airlineId')
		->setParameter('airlineId', $reviewId)
		->getQuery()
		->getArrayResult(); 
		/*---Start - average rating of airline-----*/

		/*---Start - fetch reviewer Detail-----*/
    		$senderType='REVIEWER';
      		$reviewerName = $em->createQueryBuilder()
		->select("count(rev.id) AS  totalReviews,rev.sender,rev.id,rev.reviewer_id,rev.parent_id,user.image,user.username,rev.airline_id,user.first_name,user.last_name,rev.description,rev.rating,rev.creation_timestamp")
		->from("RAAWebBundle:Review", "rev")
		->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=rev.reviewer_id")
		->andWhere('rev.id=:reveiwerId')
		->andwhere('rev.status = 1')
		->andWhere('rev.sender = :senderType')
		->setParameter('senderType', $senderType)
		->setParameter('reveiwerId', $reviewId)
		->getQuery()
		->getArrayResult(); 	
       		/*---End - fetch reviewer Detail-----*/

		/*---Start - Count reviewer review-----*/
		$senderType='REVIEWER';
		$countReview = $em->createQueryBuilder()
		->select("rev.sender,count(rev.id) AS  totalReviews,rev.reviewer_id,rev.parent_id,rev.airline_id,user.first_name,user.last_name,rev.description,rev.rating,rev.creation_timestamp")
		->from("RAAWebBundle:Review", "rev")
		->leftJoin('RAAAdminBundle:User', 'user', "WITH", "user.id=rev.reviewer_id")
		->where('rev.airline_id = :airlineId')
		->andwhere('rev.status = 1')
		->andWhere('rev.sender = :senderType')
		->setParameter('senderType', $senderType)
		->setParameter('airlineId', $airlineId)
		->getQuery()
		->getArrayResult();
		$fullUrl = $this->container->getParameter('current_url').$reviewId;//get url for social network 
		$passengerReview = array('totalReviews' => $countReview[0]['totalReviews']);
		/*---End - Count reviewer review-----*/
		$imageUrl='';
		if( strpos($reviewerName[0]['image'], '://') > 0 )
			$imageUrl = $reviewerName[0]['image'];
		return $this->render('RAAWebBundle:Page:detailReviews.html.twig',array('airline'=>$airline,'review'=>$review,'passengerReview'=>$passengerReview,'airlinesReview'=>$airlinesReview,'reviewerName'=>$reviewerName,'fullUrl'=>$fullUrl,'reviewrName'=>$reviewrName,'imageUrl'=>$imageUrl));

	}
	/*----End Function -  Show  Review Detail-----*/

		/*----Start Function -  Show  Cms for footer-----*/	
		public function showCmsFooterAction(Request $request)
		{  		
		$html='';
		$arrUrl = explode('web', $_SERVER['PHP_SELF']);
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RAAAdminBundle:CMS',  'cms')
		->where('cms.type=2')
		->getQuery()
		->getResult();	
		foreach ($cms as $cms)
		{
  			$html.='<li>'.'<a href="'.$this->container->getParameter('website_url').$cms->url.'">'.$cms->name.'</a>'.'</li>';
		}
	
		$html.='<li><a href="'.$this->container->getParameter('website_url').'contact-us">Contact Us </a></li>';
		return new response($html); 

	}
	/*----End Function -  Show  Cms for footer-----*/

	/*----Start Function -  Show  Content for footer Cms-----*/
	public function pageFooterAction(Request $request,$id)
	{  
		$url = $id;
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RAAAdminBundle:CMS',  'cms')
		->where('cms.url=:url')
		->setParameter('url', $url)
		->getQuery()
		->getResult();
			
		foreach ($cms as $cms);
		$id = $cms->id;
		$em = $this->getDoctrine()->getEntityManager();
		$cms = $em->createQueryBuilder()
		->select('cms')
		->from('RAAAdminBundle:CMS',  'cms')
		->where('cms.id=:id')			
		->setParameter('id',$id)
		->getQuery()
		->getArrayResult();

		return $this->render('RAAWebBundle:Page:footerPage.html.twig',array('cms'=>$cms)); 

	
	}
	/*----Start Function -  Show  Content for footer Cms-----*/
	
	/*----Start Function -  Show  Airline Reviews-----*/
	public function airlinesReviewsAction(Request $request,$id)
	{	
		$reviewId = $id;
		$em = $this->getDoctrine()->getEntityManager();

		/*---Start - fetch reviewer detail-----*/
		$reviewDetail = $em->createQueryBuilder()
	     	->select("rev")
	     	->from("RAAWebBundle:Review", "rev")
		->where('rev.id = :reviewId')
		->setParameter('reviewId', $reviewId)
		->getQuery()
		->getArrayResult();
		$airlineId= $reviewDetail[0]['airline_id'];
		/*---End - fetch reviewer detail-----*/

		if($airlineId=="")
		{
			$reviews = $em->createQueryBuilder()
			->select('user.business_name,airline.description,airline.headline,user.image,airline.rating,user.logo,user.first_name,airline.reviewer_image')
			->from('RAAWebBundle:Review',  'airline')
			->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=airline.airline_id ")
			->where('airline.reviewer_id=:id')		
			->andwhere('airline.status=1')		
			->andwhere('airline.sender=:sender')	
			->setParameter('id',$reviewDetail[0]['reviewer_id'])
			->setParameter('sender',$senderType)
			->getQuery()
			->getArrayResult();
		}
		else
		{
			$senderType='REVIEWER';
			$reviews = $em->createQueryBuilder()
			->select('user.business_name,airline.description,airline.headline,user.image,airline.airline_id,airline.reviewer_id,airline.rating,user.logo,user.first_name,airline.reviewer_image')
			->from('RAAWebBundle:Review',  'airline')
			->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=airline.airline_id ")
			->where('airline.reviewer_id=:id')		
			->andwhere('airline.status=1')	
			->andwhere('airline.airline_id=:airId')		
			->andwhere('airline.sender=:sender')	
			->setParameter('airId',$airlineId)
			->setParameter('id',$reviewDetail[0]['reviewer_id'])
			->setParameter('sender',$senderType)
			->getQuery()
			->getArrayResult();
		}

		$reviewerImage=$reviews[0]['image'];

		/*---Start - fetch reviewer detail of basis of review-----*/
		$reviewe = $em->createQueryBuilder()
		->select('user.business_name,airline.description,airline.headline,user.image,airline.rating,user.logo,user.username,user.first_name,user.last_name,airline.reviewer_id,user.first_name,user.phone,user.email')
		->from('RAAWebBundle:Review',  'airline')
		->leftJoin('RAAAdminBundle:User', 'user',"WITH", "user.id=airline.reviewer_id ")
		->where('airline.reviewer_id=:id')				
		->setParameter('id',$reviewDetail[0]['reviewer_id'])
		->getQuery()
		->getArrayResult();
		$name=$reviewe[0]['username'];
		$firstName=$reviewe[0]['first_name'];
		$lastName=$reviewe[0]['last_name'];
		$id=$reviewe[0]['reviewer_id'];
		$phone=$reviewe[0]['phone'];
		$email=$reviewe[0]['email'];
		$reviewerImage=$reviewe[0]['image'];
		/*---End - fetch reviewer detail basis of review-----*/
		$imageUrl='';
		if( strpos($reviewe[0]['image'], '://') > 0 )
			$imageUrl = $reviewe[0]['image'];

		return $this->render('RAAWebBundle:Page:airlinesReviews.html.twig',array('reviews'=>$reviews,'reviewerImage'=>$reviewerImage,'name'=>$name,'id'=>$id,'phone'=>$phone,'email'=>$email,'firstName'=>$firstName,'lastName'=>$lastName,'imageUrl'=>$imageUrl));
	}
	/*----End Function -  Show  Airline Reviews-----*/

	/*----Start Function -  Contact US-----*/
	public function contactUsAction(Request $request)
	{
		$em = $this->getDoctrine()->getEntityManager();
  		$gbl_email_administrator = $this->container->getParameter('gbl_email_administrator');// get admin email
		if ($request->getMethod() == 'POST') 
    		{
    			$firstname=$this->get('request')->request->get('firstname');
			$lastname=$this->get('request')->request->get('lastname');
			$phone=$this->get('request')->request->get('phone');
			$email=$this->get('request')->request->get('email');
			$messageE=$this->get('request')->request->get('message');

			/*---Start - insert new enquiry-----*/
			$message=new Contact();
			$message->setFirstName($firstname);
			$message->setLastName($lastname);
			$message->setEmail($email);
			$message->setPhone($phone);
			$message->setMessage($messageE);
			$em->persist($message);
			$em->flush(); 
			/*---Start - insert new enquiry-----*/

			/*---Start - swift mailer for contact-----*/
			$message = \Swift_Message::newInstance()
		       ->setSubject('Enquiry')
		       ->setFrom($email)
		       ->setTo($gbl_email_administrator)
		       ->setBody($this->renderView('RAAWebBundle:Email:enquiry.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'message'=>$messageE,'phone'=>$phone)));
		     $this->get('mailer')->send($message);
			return $this->render('RAAWebBundle:Page:enquiry.html.twig');
			/*---End - swift mailer for contact-----*/

		}
	return $this->render('RAAWebBundle:Page:ContactUs.html.twig');

	}
	/*----End Function---Contact US-----*/


	/*----Start Function--Approve Registration-----*/
	public function confirmedRegistrationAction($id)
	{
		$em = $this->getDoctrine()
	    	->getEntityManager();
		/*---Start --- Reviewer is confirmed the registration process-----*/
		$confirmedSubscribe = $em->createQueryBuilder() 
		->select('reg')
		->update('RAAAdminBundle:User',  'reg')
		->set('reg.status', ':status')
		->setParameter('status', 1)
		->where('reg.id = :id')
		->setParameter('id', $id)
		->getQuery()
		->getResult();
		/*---End --- Reviewer is confirmed the registration process-----*/

		/*---Start --- fetch user detail-----*/
 		$user = $em->createQueryBuilder()
      		->select('user')
      		->from('RAAAdminBundle:User',  'user')   	
      		->where('user.id=:id')
      		->setParameter('id', $id)
      		->getQuery()
      		->getArrayResult(); 	
		$email= $user[0]['email'];
		$password = $user[0]['password'];
		/*---End - fetch user detail-----*/

		/*---Start - login when reviewer confirmed registration-----*/
		$repository = $em->getRepository('RAAAdminBundle:User');
 		$user = $repository->findOneBy(array('email' => $email,'password' => $password,'status'=>1));	
		$session = $this->getRequest()->getSession();  	
           	$session->set('userId', $user->getId()); 
           	$session->set('userEmail', $user->getEmail());	
        	if ($user) 
        	{
			return $this->redirect($this->generateUrl('raa_web_home'));   

		}
		 return $this->redirect($this->generateUrl('raa_web_home'));   
		/*---End - login when reviewer confirmed registration-----*/

	}
	/*----End Function --- Approve Registration-----*/

	/*----Start Function --- Write Review for Dashboard-----*/
	public function showReviewDashboardAction($id)
 	{
		$em = $this->getDoctrine()->getEntityManager();
 		$airlineId=$id;
 		$airlines = $this->getAllAirlinesAction();
 		$type='REVIEWER';	     
 		$em = $this->getDoctrine()->getEntityManager();
 		if($airlineId=='0')
 		{
 		 
  			return $this->render('RAAWebBundle:Page:writeReviewDashboard.html.twig', array('airlineId'=>$airlineId,'airlines'=>$airlines,
        ));
     
 		}

    	} 
   
   	/*----End Function -  Write Review for Dashboard-----*/
	
	/*----Start Function -  Submit Review When Uder Logged In-----*/
    	function submitReviewDashboardAction()
   	{
   		$id=0;
   		$gbl_email_administrator = $this->container->getParameter('gbl_email_administrator');
   		$em = $this->getDoctrine()->getEntityManager();
		$website_url = $this->container->getParameter('website_url');
		$reviewDateTime = new DateTime();
		$airlineName=$this->get('request')->request->get('search');
		$airlineId=$this->get('request')->request->get('airlineReview');
		$departureCity=$this->get('request')->request->get('departureCity');
		$destinationCity=$this->get('request')->request->get('destinationCity');
		$stars=$this->get('request')->request->get('stars');
		$starH=$this->get('request')->request->get('starH');
		$starR=$this->get('request')->request->get('starR');
		$starM=$this->get('request')->request->get('starM');
		$starL=$this->get('request')->request->get('starL');
	  	$starG=$this->get('request')->request->get('starG');
		$starQ=$this->get('request')->request->get('starQ');
		$travel=$this->get('request')->request->get('recagent');
		$trip=$this->get('request')->request->get('trip');
		$headline=$this->get('request')->request->get('headline');
		$writereview=$this->get('request')->request->get('writereview');
		$agent=$this->get('request')->request->get('agent');
		$receiveUpdates= $this->get('request')->request->get('receiveUpdates')=='on' ? 1 : 0;
		$recommend=$this->get('request')->request->get('recomend');

		$session = $this->getRequest()->getSession();
		if( $session->get('userId') && $session->get('userId') != '' )
		{
			/*----Start fetch reviewer detail-----*/
			$reviewerName = $em->createQueryBuilder()
		      	->select('user')
		      	->from('RAAAdminBundle:User',  'user')
		      	->where('user.id=:id')
		      	->setParameter('id',$session->get('userId'))
		      	->getQuery()
		      	->getArrayResult(); 
			$firstname = $reviewerName[0]['first_name'];
			$lastname = $reviewerName[0]['last_name'];
			$emailReviewer=$reviewerName[0]['email'];
			/*----End fetch reviewer detail-----*/
			
			/*----Start Insert new Review-----*/
			$file = $_FILES['revImage']['name'];
   			$file1  = $_FILES['revImage']['tmp_name']; 		 
    			move_uploaded_file($_FILES["revImage"]["tmp_name"],
      			"images/Airline/" . $_FILES["revImage"]["name"]);
			$rating=new Review();
			$rating->setHeadline($headline);
			$rating->setDescription($writereview);
			$rating->setUseAgent($agent);
			$rating->setReceiveUpdates($receiveUpdates);
			$rating->setDepartureCity($departureCity);
			$rating->setDestinationCity($destinationCity);
			$rating->setRecomendAgent($recommend);
			$rating->setRating($stars);
			$rating->setReviewerId($session->get('userId'));
			$rating->setcreationTimestamp($reviewDateTime);
			if($airlineId)
			{
				$rating->setAirlineId($airlineId);
			}
			else
			{
				$rating->setAirlineId($id);
			}
			$rating->setHonesty($starH);
			$rating->setTravel($travel);
			$rating->setTrip($trip);
			$rating->setSender('REVIEWER');
			$rating->setStatus(2);
			$rating->setHonesty($starH);
			$rating->setMarketKnowldege($starL);
			$rating->setSoldPrice($starH);
			$rating->setResponsiveness($starR);
			$rating->setService($starM);
			$rating->setSoldQuickly($starQ);
			$rating->setReviewerImage($file);
			$em->persist($rating);
			$em->flush();
			/*----End Insert new Review-----*/

			$reviewId=$rating->getId();
			$confirmationLink= $website_url."approve/review/".$reviewId;//confirmation review link
			
			/*----Start mail for approve review-----*/
			$message = \Swift_Message::newInstance()
            		->setSubject('Review')
            		->setFrom($emailReviewer)
            		->setTo($gbl_email_administrator)
           		->setBody($this->renderView('RAAWebBundle:Email:review.txt.twig', array('firstname'=>$firstname,'lastname'=>$lastname,'writereview'=>$writereview,'airlineName'=>$airlineName,'confirmationLink'=>$confirmationLink,'stars'=>$stars)));
        		$this->get('mailer')->send($message);
			/*----End mail for approve review-----*/	
			return $this->render('RAAWebBundle:Page:confirmReviewDashboard.html.twig');
				
			}
		
	 	}
		/*----End Function -  Submit Review When User Logged In-----*/
   
	/*----Start Function -  Approve Review-----*/
   	function approveReviewAction($id)
   	{
		$em = $this->getDoctrine()
	   	 ->getEntityManager();
		$confirmedSubscribe = $em->createQueryBuilder() 
		->select('rev')
		->update('RAAWebBundle:Review',  'rev')
		->set('rev.status', ':status')
		->setParameter('status', 1)
		->where('rev.id = :id')
		->setParameter('id', $id)
		->getQuery()
		->getResult();
   		return $this->render('RAAWebBundle:Page:approveReview.html.twig');
   	}
	/*----End Function -  Approve Review-----*/

	/*----Start Function -  Thank You when email is Subscibed -----*/
	function thankYouAction()
	{
		return $this->render('RAAWebBundle:Page:thankYou.html.twig');

	}
	/*----End Function -  Thank You when email is Subscibed -----*/

	
	/*----Start Function -  Set Default Image -----*/
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
					$imageUrl = $this->container->getParameter('website_url').'images/uploads/'.$image;
				else
					$imageUrl = $this->container->getParameter('website_url').'images/uploads/default_user_image.jpeg';
			}
		}
		else
		{
			$imageUrl = $this->container->getParameter('website_url').'images/Airline/default_user_image.jpeg';
		}
		return $imageUrl;
	}
	/*----End Function -  Set Default Image -----*/

	/*----Start Function -  Check Headline  -----*/
	public function checkHeadlineAction(Request $request)
	{
		$reviewHeadline=$_POST['reviewHeadline'];
		$em = $this->getDoctrine()->getEntityManager();
		$repository = $em->getRepository('RAAWebBundle:Review');        
		$review = $repository->findOneBy(array('headline' => $reviewHeadline));

		if($review)
		{
			return new response('SUCCESS');
		}	

		return new response('FAILURE');

	}
	/*----End Function -  Check Headline  -----*/
}
