<?php

class User_model extends CI_Model
{
	function getall_users()
	{
		$query = $this->db->query("SELECT ud.id, ud.f_name, ud.l_name, ud.email, ud.primary_contact_no, u.status, u.employee_code, ur.id as role_id, ur.role
										FROM employee as ud
										INNER JOIN 
										user as u
										ON ud.id=u.employee_id
										INNER JOIN user_category_department_role as ucdr
										ON ud.id=ucdr.employee_id
										INNER JOIN 
										department as dp
										ON ucdr.department=dp.id
										INNER JOIN 
										user_role as ur
										ON ucdr.role=ur.id
										GROUP BY ucdr.employee_id ORDER BY ud.id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function create_internal_user($data)
	{
		$this->db->insert('employee', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}

	function create_user_category_department_role($data)
	{
		$this->db->insert('user_category_department_role', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}

	function create_internal_userlogin($data)
	{
		$this->db->insert('user', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}	
	function get_userdetails($data)
	{
		$condition= 'emp.id='.$data['id'];
		$query = $this->db->query("SELECT emp.*, iu.username, iu.status as emp_status, iu.created_date
										FROM employee as emp
										INNER JOIN user as iu
										ON emp.id=iu.employee_id
										-- INNER JOIN user_role as r
										-- ON iu.user_role_id=r.id
										WHERE ".$condition
								);
		$return_array = $query->row_array();		
		return $return_array;
	}

	function update_internal_user($data,$user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update('employee', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}

	function update_emp_status($data,$user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update('user', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}

	function update_userid_employee($data,$employee_id)
	{
		$this->db->where('id', $employee_id);
		$this->db->update('employee', $data);
		$result=$this->db->affected_rows();		
		return $result;
	}

	function unique_username($username,$email)
	{
		$null_array = array();
		$query = $this->db->query("SELECT *
								FROM user
								WHERE username='".$username."'"
								);
		$return_array = $query->row_array();

		if (sizeof($return_array) > 0) 
		{
			$query = $this->db->query("SELECT *
							FROM employee
							WHERE id=".$return_array['employee_id']
							);
			$return_array_1 = $query->row_array();
			if(sizeof($return_array_1) > 0)
			{
				if($return_array_1['email'] == $email)
				{
					return $null_array;
				}
				else
				{
					return $return_array_1;
				}
			}
			else
			{
				return $return_array_1;
			}
        }
        else
        {	
			return $null_array;
		}
	}

	function getall_departments($condition)
	{
		$query = $this->db->query("SELECT *
										FROM department
										".$condition."
										ORDER BY department_name DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function getall_category($condition)
	{
		$query = $this->db->query("SELECT *
										FROM category
										".$condition."
										ORDER BY category DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function getall_role($condition)
	{
		$query = $this->db->query("SELECT *
										FROM user_role
										".$condition."
										ORDER BY id ASC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function user_department($condition)
	{
		$query = $this->db->query("SELECT id as department_id, department_name
										FROM department
										".$condition
								);
		$return_array = $query->result_array();		
		return $return_array;
	}

	function user_roles($condition)
	{
		$query = $this->db->query("SELECT id as role_id, role
										FROM user_role
										".$condition
								);
		$return_array = $query->result_array();		
		return $return_array;
	}

	function user_roles_department($condition)
	{
		$query = $this->db->query("SELECT *
										FROM user_category_department_role
										".$condition
								);
		$return_array = $query->result_array();		
		return $return_array;
	}

	function clear_category_dept_role($employee_id)
    {
        $where = '(employee_id=' . $employee_id.')';
        $this->db->where($where);
        $this->db->delete('user_category_department_role');
    }
}
?>