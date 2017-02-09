<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		if($this->session->userdata('user_logged')!="yes:tracking_user")
		{
			redirect(base_url().'index.php/Home');
			exit;
		}
		$this->load->model('Generalsettings_model');
	}
	
	function index()
	{
		$show_data = array();
		$show_data['error']='';
		$show_data['success']=$this->session->userdata('success');
		$this->clearmessage();

		$show_data['name']=$this->session->userdata('user_name');
		$show_data['propic']=$this->session->userdata('profile_pic');

		$condition = " WHERE ucdr.employee_id=".$this->session->userdata('user_id');
		$show_data['user_categories']=$this->Generalsettings_model->getall_user_categories($condition);

		$this->load->view('dashboard_view',$show_data);
		//

	}



	private function success($message)
	{
		$userdata = array(
							'success'    => $message
						);
		$this->session->set_userdata($userdata);		
	}

	private function clearmessage()
	{
		$userdata = array(
							'success'    => ''
						);
		$this->session->set_userdata($userdata);
	}
}

?>