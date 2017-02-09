<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('Home_model');
		$this->load->helper('html');
		$this->load->helper('security');
		$this->load->helper('cookie');
		// $this->load->helper('url');
	}
	
	function index()
	{
		if($this->session->userdata('user_logged')=="yes:tracking_user")
		{
			
			redirect(base_url().'index.php/Dashboard');
		}
		else
		{			
			$show_data = array();
			$show_data['error']='';
			$show_data['success']=$this->session->userdata('success');
			$this->clearmessage();
			
			if(isset($_POST['adminlogin']))
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('ls_username','User Name','required');
				$this->form_validation->set_rules('ls_password','Password','required');
				
				if($this->form_validation->run() != false)
				{
					$result = $this->Home_model->loginValidate();
					if($result == 0)
					{
						$show_data['error'] = 'Invalid Username or Password';
					}
					else
					{
						$this->setLoginSession($result);
						redirect(base_url().'index.php/Dashboard');
					}
				}
				else
				{
					redirect(base_url().'index.php/Home');
				}
			}
			$this->load->view('home_view',$show_data);
		}
	}

	function setLoginSession($result)
	{
		$category_role_department_functions=array();
		if($result['user_role_id']!=1)
		{
			$function_result = $this->Home_model->function_array();

			foreach($function_result as $functions)
			{
				// $function[] = $functions['function_id'];
				// $category[] = $functions['category_id'];
				// $role[] = $functions['role_id'];
				// $department[] = $functions['department_id'];
				$category_role_department_functions[$functions['category_id']]['category_name']='CatName';
				$category_role_department_functions[$functions['category_id']]['roles'][$functions['role_id']]['role_name']='RolName';
				$category_role_department_functions[$functions['category_id']]['roles'][$functions['role_id']]['departments'][$functions['department_id']]['department_name']='DepName';
				$category_role_department_functions[$functions['category_id']]['roles'][$functions['role_id']]['departments'][$functions['department_id']]['funtions'][$functions['function_id']]='Funtion_name';
				//$category_role_department_functions[$functions['category_id']][$functions['role_id']][$functions['department_id']][]=$functions['function_id'];
			}

			$userdata = array(
							'user_id'    => $result['user_id'],
							'userdetails_id' => $result['employee_id'],
							'user_logged' => 'yes:tracking_user',
							'user_name' => $result['f_name'].' '.$result['l_name'],
							'profile_pic' => $result['profile_pic'],
							'user_code' => $result['username'],
							'admin_flag' => 0,
							'category_role_department_functions' => $category_role_department_functions
							);
		}
		else
		{
			$userdata = array(
							'user_id'    => $result['user_id'],
							'userdetails_id' => $result['employee_id'],
							'user_logged' => 'yes:tracking_user',
							'user_name' => $result['f_name'].' '.$result['l_name'],
							'profile_pic' => $result['profile_pic'],
							'role' => 'superadmin',
							'role_id' => 1,
							'user_code' => $result['username'],
							'admin_flag' => 1,
							);
		}

		$this->session->set_userdata($userdata);
	}

	private function clearmessage()
	{
		$userdata = array(
							'success'    => ''
						);
		$this->session->set_userdata($userdata);
	}
	private function success($message)
	{
		$userdata = array(
							'success'    => $message
						);
		$this->session->set_userdata($userdata);		
	}
}

?>