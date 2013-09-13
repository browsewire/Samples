<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ourplans extends CI_Controller {
	var $data;
	function __construct(){
				parent :: __construct();
				$this->ourclass->isLoggedin();
			}
	function index(){
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;		
		$this->data['pagination'] = $this->ourclass->getPaginationAll("our_plans",3,$this->plans->getCount());
		$this->data['list'] = $this->plans->getAll(10,$page);
		$this->data['header'] = $this->load->view('include/header');
		$this->data['siteContent'] = $this->load->view('option/plans',$this->data);
		$this->data['footer'] = $this->load->view('include/footer');			
		$this->load->view('template',$this->data);
		}
   function add(){
	  extract($_REQUEST);
		  if($name&&$path&&$id){
			  $this->plans->setId($id);
			  $this->plans->setName($name);
			  $this->plans->setPath($path);
			  $this->plans->setAmount($amount);
			  $this->plans->save();
			  }
	  redirect('/ourplans');
	  }
   function edit(){
	    $this->data['header'] = $this->load->view('include/header');
		$this->data['siteContent'] = $this->load->view('option/planEdit',$this->data);
		$this->data['footer'] = $this->load->view('include/footer');			
		$this->load->view('template',$this->data);
	   }
  function update(){
	  extract($_REQUEST);
	  $this->plans->setId($id);
	  $this->plans->setName($name);
	  $this->plans->setPath($path);
	  $this->plans->setAmount($amount);
	  $this->plans->update();
		redirect('/ourplans');
	  }  
 function delete(){
		 $this->plans->setId($this->uri->segment(3));
		 $this->plans->delete();
		 redirect('/ourplans');
	  }
}	
