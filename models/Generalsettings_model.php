<?php

class Generalsettings_model extends CI_Model
{
	function create_department($data)
	{
		$this->db->insert('department', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}

	// function create_department_role_mapping($data)
	// {
	// 	$this->db->insert('department_role_mapping', $data);
	// 	$return_value = $this->db->insert_id();
	// 	return 	$return_value;
	// }

	function update_department($data,$department_id)
	{
		$this->db->where('id', $department_id);
		$this->db->update('department', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}

	function getall_departments($condition)
	{
		$query = $this->db->query("SELECT dept.*, cat.category, dept.category as category_id
										FROM department as dept
										INNER JOIN category as cat
										ON dept.category=cat.id
										".$condition."
										ORDER BY dept.department_name DESC "
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function get_departmentdetails($department_id)
	{
		$query = $this->db->query("SELECT *
										FROM department
										WHERE id=".$department_id."
										ORDER BY department_name DESC"
								);
		$return_array = $query->row_array();
		return $return_array;	
	}

	function create_designation($data)
	{
		$this->db->insert('designation', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}
	function update_designation($data,$designation_id)
	{
		$this->db->where('id', $designation_id);
		$this->db->update('designation', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}

	function getall_designations($condition)
	{
		$query = $this->db->query("SELECT *
										FROM designation
										".$condition."
										ORDER BY designation DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function get_designationdetails($designation_id)
	{
		$query = $this->db->query("SELECT *
										FROM designation
										WHERE id=".$designation_id."
										ORDER BY designation DESC"
								);
		$return_array = $query->row_array();
		return $return_array;	
	}

	/*--- Function role Mapping ---*/
	function create_function_role_mapping($data)
	{
		$this->db->insert('function_role_mapping', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}

	function update_function_role_mapping($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('function_role_mapping', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}
	function getall_mapped_function_role($condition)
	{
		$query = $this->db->query("SELECT DISTINCT(ur.id) as role_id, ur.role, f.id as function_id, f.function_name, frm.id, frm.status, frm.category_id, frm.department_id, c.category, r.role, d.department_name
										FROM function_role_mapping as frm
										INNER JOIN user_role as ur
										ON frm.role_id=ur.id
										INNER JOIN functions as f
										ON frm.function_id=f.id
										INNER JOIN category as c
										ON frm.category_id=c.id
										INNER JOIN user_role as r
										ON frm.role_id=r.id
										INNER JOIN department as d
										ON frm.department_id=d.id

										".$condition."
										GROUP BY frm.category_id, frm.role_id, frm.department_id ORDER BY frm.id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function get_function_role_mapping_details($condition)
	{
		$query = $this->db->query("SELECT *
										FROM function_role_mapping
										".$condition."
										ORDER BY id ASC"
								);
		$return_array = $query->row_array();
		return $return_array;	
	}

	function get_selected_functions($condition)
	{
		$query = $this->db->query("SELECT function_id, category_id, role_id, department_id
										FROM function_role_mapping
										".$condition."
										ORDER BY id ASC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function get_all_role($role_condition)
	{
		$query = $this->db->query("SELECT *
										FROM user_role
										".$role_condition."
										ORDER BY id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function get_all_functions()
	{
		$query = $this->db->query("SELECT *
										FROM functions 
										ORDER BY id ASC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function get_function_id($role_id)
	{
		$condition= 'role_id='.$role_id;
		$query = $this->db->query("SELECT function_id
										FROM function_role_mapping
										WHERE ".$condition."
										ORDER BY id ASC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function get_previous_data($role_id,$category_id,$department_id) {
        $query = $this->db->query("SELECT *
										FROM function_role_mapping
										WHERE role_id=".$role_id." AND category_id=".$category_id." AND department_id=".$department_id
        );
        $return_array = $query->result_array();


        if (sizeof($return_array) > 0) {

        	$where = '(department_id=' . $department_id.' AND category_id='.$category_id.' AND role_id='.$role_id.')';
        	$this->db->where($where);
			$this->db->delete('function_role_mapping');
			
	        return true;
        }
    }

    function getall_categories($condition)
	{
		$query = $this->db->query("SELECT *
										FROM category
										".$condition."
										ORDER BY id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}

	function get_category_roles($condition)
	{
		$query = $this->db->query("SELECT id as role_id, role
										FROM user_role as r
										".$condition
								);
		$return_array = $query->result_array();		
		return $return_array;
	}

	function get_category_departments($condition)
	{
		$query = $this->db->query("SELECT id as department_id, department_name
										FROM department
										".$condition
								);
		$return_array = $query->result_array();		
		return $return_array;
	}

	// function clear_category_department($department_id)
 //    {
 //        $where = '(department_id=' . $department_id.')';
 //        $this->db->where($where);
 //        $this->db->delete('department_role_mapping');
 //    }

    function getall_user_categories($condition)
	{
		$query = $this->db->query("SELECT DISTINCT cat.category, cat.id as category_id
										FROM category as cat
										INNER JOIN user_category_department_role as ucdr
										ON cat.id=ucdr.category
										".$condition."
										ORDER BY cat.category ASC "
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
}
?>