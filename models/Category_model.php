<?php

class Category_model extends CI_Model
{
	function getall_main_categories($condition)
	{
		$query = $this->db->query("SELECT *
										FROM main_category
										".$condition."
										ORDER BY id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	
	function getall_category($condition)
	{
		$query = $this->db->query("SELECT cat.*, m_cat.main_category
										FROM category as cat
										INNER JOIN main_category as m_cat
										ON cat.main_category=m_cat.id
										".$condition."
										ORDER BY cat.id DESC"
								);
		$return_array = $query->result_array();
		return $return_array;	
	}
	function create_category($data)
	{
		$this->db->insert('category', $data);
		$return_value = $this->db->insert_id();
		return 	$return_value;
	}	
	
	function update_category($data,$category_id)
	{
		$this->db->where('id', $category_id);
		$this->db->update('category', $data);
		$result=$this->db->affected_rows();	
		
		return $result;
	}

	function get_category($condition)
	{
		$query = $this->db->query("SELECT cat.*, m_cat.main_category, cat.main_category as main_category_id
										FROM category as cat
										INNER JOIN main_category as m_cat
										ON cat.main_category=m_cat.id
										".$condition."
										ORDER BY id DESC"
								);
		$return_array = $query->row_array();
		return $return_array;	
	}
}

?>