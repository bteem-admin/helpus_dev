<?php

class Profile_model extends CI_Model
{		
	function get_user_profile($employee_id)
	{
		$condition= 'ud.id='.$employee_id;
		$query = $this->db->query("SELECT ud.*
										FROM employee as ud
										WHERE ".$condition
								);
		$return_array = $query->row_array();
		return $return_array;
	}

	function update_userlogin($data,$user_id)
	{
		$this->db->where('employee_id', $user_id);
		$this->db->update('user', $data);
		$result=$this->db->affected_rows();		
		return $result;
	}

	function update_user_employee($data,$user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update('employee', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}
}

?>