<?php

class Role_model extends CI_Model
{
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
	
	function getall_role($condition)
	{
		$query = $this->db->query("SELECT r.*, cat.category
										FROM user_role as r
										INNER JOIN category as cat
										ON r.category=cat.id
										".$condition."
										ORDER BY id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function create_role($data)
	{
		$this->db->insert('user_role', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}	
	
	function update_role($data,$role_id)
	{
		$this->db->where('id', $role_id);
		$this->db->update('user_role', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}

	function get_role($condition)
	{
		$query = $this->db->query("SELECT *
										FROM user_role
										".$condition."
										ORDER BY id DESC"
								);
		$return_array = $query->row_array();
		return $return_array;	
	}
}

?>