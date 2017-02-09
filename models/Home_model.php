<?php

class Home_model extends CI_Model
{

	function function_array()
	{
		$query = $this->db->query("SELECT frm.function_id, frm.category_id, frm.role_id, frm.department_id
									FROM user as u
									-- INNER JOIN employee as emp
									-- ON u.employee_id=emp.id
									INNER JOIN user_category_department_role as ucdr
									ON u.employee_id=ucdr.employee_id
									-- INNER JOIN user_role as ur
									-- ON ucdr.role=ur.id
									INNER JOIN function_role_mapping as frm
									ON ucdr.role=frm.role_id AND ucdr.department=frm.department_id AND ucdr.category=frm.category_id
									INNER JOIN functions as f
									ON f.id=frm.function_id
									INNER JOIN department as d
									ON ucdr.department=d.id
									INNER JOIN category as c
									ON ucdr.category=c.id
									where u.username='".$this->input->post('ls_username')."' and u.password='".md5($this->input->post('ls_password'))."' and u.status=1");
		$return_array = $query->result_array();
		return $return_array;	
	}

	function loginValidate()
	{
		$query = $this->db->query("SELECT u.id as user_id, u.user_role_id, u.username, u.employee_id, ud.*
									FROM user as u
									INNER JOIN employee as ud
									ON u.employee_id=ud.id
									where u.username='".$this->input->post('ls_username')."' and u.password='".md5($this->input->post('ls_password'))."' and u.status=1");
		$return_array = $query->row_array();
		
		if(sizeof($return_array) != 0)
		{		
			return $return_array;			
		}		
		else
		{			
			return 0;
		}	
	}
}
?>