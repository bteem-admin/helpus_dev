<?php 
class Logout extends CI_Controller{
	function __construct()
	{	
		parent::__construct();
		if($this->session->userdata('user_logged')!="yes:tracking_user")
		{
			redirect(base_url().'index.php/Home');
			exit;
		}
	}
	function index()
	{		
		$this->session->sess_destroy();
		redirect(base_url().'index.php/Home');
	}
}
?>