<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class plans extends CI_Model {
	
	var $_data;
	var $tableName;
	function __construct(){
		parent :: __construct();
		$this->tableName = 'table_name';	
		}
	function setId($str){
		$this->_data['id'] = $str;
    	}
	function setName($str){
		$this->_data['name']= $str;
		}
	function setPath($str){
		$this->_data['path']= $str;
		}
	function setAmount($str){
		$this->_data['amount']= $str;
		}			
	function save(){
			$this->db->insert(
			$this->tableName, $this->_data
		);
		}		
	function update(){
		$this->db->where('id',$this->_data['id']);
		$this->db->update( 
			$this->tableName, $this->_data
		);
		}
	function getById(){
		$query = $this->db->get_where(
		$this->tableName, array('id' => $this->_data['id'])
		);
		return $query->row();
		}
	function delete(){
		$this->db->where('id', $this->_data['id']);
		$this->db->delete($this->tableName); 
		}
	
	function getAll($stop,$start){
			$this->db->limit($stop,$start);
			$query=$this->db->get($this->tableName);
			return $query->result();	
			}
	function getCount(){
			$query=$this->db->get($this->tableName);
			return $query->num_rows();
		}				
	}
