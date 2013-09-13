<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ourclass {	
	var $ci;
	function __construct(){
		$this->ci =& get_instance();			
		}
	function isLoggedin()
	 {
		 $is_logged_in = $this->ci->session->userdata('isLoggedin');
        if(!isset($is_logged_in) || $is_logged_in == false)
        {
			redirect($this->ci->config->item('main_url'));
         die(); 
        }   
     }
	function title(){
		return $this->ci->options->getData('title');           
    	}
    function template(){
		return $this->ci->options->getByName('template');           
    	}
    function getUserType($id){
		return $this->ci->options->getById($id);           
    	}
    function paginationPerPage(){
		return $this->ci->options->getByName('paginationperpage');           
     }
    function setSession($id){
		$query = $this->ci->db->where('id',$id );
		$query = $this->ci->db->where('is_active',1);
		$query = $this->ci->db->get('users');
		$query1 = $query->row();
		$query2=$query->num_rows();		
			if($query2!=1){
				redirect($this->ci->config->item('main_url'));
			}
			else
			{
				$sess = array(
				'uid' => $id,
				'isLoggedin' => TRUE,
				'uname' => $query1->name, 
				'email'=> $query1->email,
				'userType'=>$query1->type
				);

				$this->ci->session->set_userdata($sess);
			}

		}
    		
    function getName(){
		$id = $this->ci->session->userdata('uid');
		$query = $this->ci->db->where('id',$id);
		$query = $this->ci->db->get('users');
		$query1 = $query->row();
		return $query1->name;
		}
	
	function sendEmail($from,$to,$subject,$message){
		$config['mailtype'] = "html";
		$this->ci->email->from($from);
		$this->ci->email->to($to);
		$this->ci->email->subject($subject);
		$this->ci->email->message($message);
		$this->ci->email->send();
	 	}	
	 	
	function getStateName(){
		$id = $this->ci->session->userdata('uid');
		$query = $this->ci->db->where('id',$id);
		$query = $this->ci->db->get('users');
		$query1 = $query->row();
		$state = $query1->state;
		$query2 = $this->ci->db->where('id',$state);
		$query2 = $this->ci->db->get('usstate');
		$query3 = $query2->row();
		return $query3->name;
		}	
		
	function getPagination($tableName,$uriSegment,$searchby=NULL,$keyword=NULL,$uesrid=NULL,$fieldName=NULL){
		$config = array();
		$config['full_tag_open'] = '<ul class="page-navigation">';
		$config['num_tag_open'] = '<li>';
		$config['cur_tag_open'] = '<li>';
		$config['prev_tag_open'] = '<li>';
		$config['next_tag_open'] = '<li>';
		$config['last_tag_open'] = '<li>';
		$config['first_tag_open'] = '<li>';
		
        $config["base_url"] = base_url() . $this->ci->uri->rsegment(1)."/".$this->ci->uri->rsegment(2);
        $config["num_links"] = 4;
        $config["total_rows"] = $this->counter($tableName,$searchby,$keyword,$uesrid,$fieldName);
        $config["per_page"] = 10;
        $config["uri_segment"] = $uriSegment;
        
        $config['first_tag_close'] = '</li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_close'] = '</li>';
        $config['num_tag_close'] = '</li>';
        $config['full_tag_close'] = '</ul>';
		$this->ci->pagination->initialize($config);
		return $this->ci->pagination->create_links();
		}	
		
		
		
	function counter($tableName,$searchby,$keyword,$uesrid,$fieldName){
		//echo $tableName.$searchby.$keyword;
		if(!empty($searchby) AND !empty($keyword)){
			
			$this->ci->db->like($searchby,$keyword,'after');
			
			$query = $this->ci->db->get($tableName);
			
		return  $query->num_rows();
			}
		elseif(!empty($uesrid) AND !empty($fieldName))
			{	
				$query = $this->ci->db->get_where($tableName,array($fieldName=>$uesrid));				
				return  $query->num_rows();
			}
			else{
		return $this->ci->db->count_all($tableName);
			}	
		}
		
	function getPaginationAll($tableName,$uriSegment,$count){
			$config = array();
			$config['full_tag_open'] = '<ul class="page-navigation">';
			$config['num_tag_open'] = '<li>';
			$config['cur_tag_open'] = '<li>';
			$config['prev_tag_open'] ='<li>';
			$config['next_tag_open'] = '<li>';
			$config['last_tag_open'] = '<li>';
			$config['first_tag_open'] = '<li>';					
			$config["base_url"] = base_url() . $this->ci->uri->rsegment(1)."/".$this->ci->uri->rsegment(2);
			$config["num_links"] = 4;
			$config["total_rows"] = $count;
			$config["per_page"] = 10;
			$config["uri_segment"] = $uriSegment;
			$config['first_tag_close'] = '</li>';
			$config['last_tag_close'] = '</li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_close'] = '</li>';
			$config['num_tag_close'] = '</li>';
			$config['full_tag_close'] = '</ul>';
			$this->ci->pagination->initialize($config);
			return $this->ci->pagination->create_links();
		}	
		
		
	function getPages($stateId=NULL){
		$this->ci->db->order_by('title','asc');
		$query = $this->ci->db->get('pages');
		echo '<select name="pageid">';
		foreach($query->result() as $stt):
			if($stateId == $stt->id){
			echo "<option value=".$stt->id." selected>".$stt->title."</option>";	
				}else{
			echo "<option value=".$stt->id.">".$stt->title."</option>";
		}
		endforeach;
		echo '</select>';
		} 	
	
	
	function getModule(){
				if($this->ci->session->userdata('userType') !== 'admin'){
				$typeId = $this->ci->options->getIdByValue($this->ci->session->userdata('userType'));
				$sl = $this->ci->sidebarlist;
				$sl->setType($typeId);
				return $sl->getByType();
			}			
		}
		
   function getPresentHealth($uid){	   
	  		 $query=$this->ci->db->get_where("present_health",array('uid'=>$uid));
	   		return $query->row();
	   }
	   
   function getMedicalHistory($uid){	   
	  		 $query=$this->ci->db->get_where("medical_history",array('uid'=>$uid));
	   		 return $query->row();
	   }

	
  function getPersonalHistory($uid){	   
		 $query=$this->ci->db->get_where("personal_history",array('uid'=>$uid));
		 return $query->row();
     }
	 
  function getInformedConsent($uid){	   
		 $query=$this->ci->db->get_where("informed_consent",array('uid'=>$uid));
		 return $query->row();
     }	 
	 
  function checkDiseases($uid,$Disease){
	  	$getData= $this->getPersonalHistory($uid)->child_diseases;
		$data=explode(",",$getData);
			if(array_search($Disease,$data))
			{
				return "Yes";
			}
			else{
				 return "-";
				}
	  }
	  
  function getReviewOfSymptoms($uid,$symptom_name){
			$this->ci->db->where('uid',$uid);
			$this->ci->db->where('symptom_name',$symptom_name);
			$query=$this->ci->db->get('review_of_symptoms');
			
			 if($query->num_rows()){
				return $query->row()->symptom_value;
				 }
		   	else{				
				 return " - ";
				}	 
	  }	  
	  	  
  function checkDiseasesOther($uid){
	  	$getData= $this->getPersonalHistory($uid)->child_diseases;
		$data=explode(",",$getData);
		return $data['0'];
	  }	   
   function getFamilyHistory($uid,$problem){
	   		$this->ci->db->where('uid',$uid);
		    $this->ci->db->where('problem',$problem);
			$query=$this->ci->db->get('family_history');
			if($query->num_rows()){
			 return	$query->row()->member;
				}
			else{
				
				return "-";
				}	
	   }	
	
	function getProblem($data){
			$date=explode(',',$data);
			return $date['0'];
		}
		
	function getProblemQuantity($data){
			$date=explode(',',$data);
			if(isset($date['1'])){
				return $date['1'];
			}
		}
		
	function timezone(){
			$this->ci->db->order_by('timezone','asc');
			$query=$this->ci->db->get('timezone');
			return $query->result();
		}
		
	
		
	}
