<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_logged')!="yes:tracking_user" && $this->session->userdata('user_type')!="superadmin")
		{
			redirect(base_url().'index.php/Home');
			exit;
		}		
		$this->load->model('Role_model');
	}
	
	function index()
	{	
		$show_data = array();	
		$show_data['error']='';
		$show_data['success']=$this->session->userdata('success');
		$this->clearmessage();
		
		if(isset($_POST['create_role']))
		{
			$this->load->library('form_validation');			
			$config = array(
				array(
                     'field'   => 'category', 
                     'label'   => 'Category', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'role', 
                     'label'   => 'Role', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$info = array();
				$info['category'] = $this->input->post('category');
				$info['role'] = $this->input->post('role');

				$result = $this->Role_model->create_role($info);	
				
				if($result>0)
				{
					$this->success('<p class="success">Role has been added successfully</p>');
					redirect('index.php/Role');
					exit;					
				}
			}
		}
		if(isset($_POST['edit_role']))
		{
			$this->load->library('form_validation');			
			$config = array(
				array(
                     'field'   => 'category', 
                     'label'   => 'Category', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'role', 
                     'label'   => 'Role', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{		
				$info = array();

				$role_id = $this->input->post('role_id');
				$info['category'] = $this->input->post('category');
				$info['role'] = $this->input->post('role');
				
				$result = $this->Role_model->update_role($info,$role_id);
				
				if($result>0)
				{
					$this->success('<p class="success">Role have been updated successfully</p>');
					redirect('index.php/Role');
				}
			}
		}
		
		$condition = ' WHERE r.category!=0';
		$show_data['role_array'] = $this->Role_model->getall_role($condition);
		$this->load->view('role_view',$show_data);		
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
	
	function add()
	{
		$ret_result='';
		
		if($this->session->userdata('user_logged')=="yes:tracking_user")
		{
			$conditions = " WHERE status=1";
			$all_categories = $this->Role_model->getall_categories($conditions);

			$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Add Role</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="role_registration" name="role_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<select class="input" name="category" id="category">
													<option value="">select</option>';
													foreach($all_categories as $category)
													{
														$ret_result.='<option value="'.$category['id'].'">'.$category['category'].'</option>';
													}
									$ret_result.='</select>
												<div id="error_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Role
											</label>
											<div class="input__area">		
												<input type="text" value="" class="input" name="role" id="role" placeholder="Role">
												<div id="error_role" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>										

										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>					
											<input type="submit" name="create_role" id="create_role" class="submit__button" style="float:none;" value="Create Role" onclick="return role_registration_validation()">
										</div>										
									</div>
								</div>
							</form>
							';
									
									
					echo $ret_result;
					exit;
		}
	}
	
	function edit()
	{
		$data = array();
		$ret_result = '';
		
		if(isset($_POST['id'])&&$_POST['id']!='')
		$data['id'] =  $_POST['id'];
		
		if(isset($data['id'])&&$data['id']!=''&&$this->session->userdata('user_logged')=="yes:tracking_user")
		{
			$role_id = $data['id'];
			$condition=' WHERE id='.$role_id;
			$role_details = $this->Role_model->get_role($condition);

			$conditions = " WHERE status=1";
			$all_categories = $this->Role_model->getall_categories($conditions);

			if(sizeof($role_details)>0)
			{				
				$ret_result='';
				$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Edit Role</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="edit_role_registration"  name="edit_role_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<select class="input" name="category" id="category">
													<option value="">select</option>';
													foreach($all_categories as $category)
													{
														$selected = $category['id'] == $role_details['category']?'selected':'';
														$ret_result.='<option value="'.$category['id'].'" '.$selected.'>'.$category['category'].'</option>';
													}
									$ret_result.='</select>
												<div id="error_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Role
											</label>
											<div class="input__area">		
												<input type="text" value="'.$role_details['role'].'" class="input" name="role" id="role" placeholder="Role">
												<div id="error_role" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>
										
										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>
											<input type="hidden" value="'.$role_details['id'].'" name="role_id" id="role_id">
											<input type="submit" name="edit_role" id="edit_role" class="submit__button" style="float:none;" value="Edit Role" onclick="return edit_role_registration_validation()">
										</div>										
									</div>
								</div>
							</form>
						';
								
								
				echo $ret_result;
				exit;				
			}
			else
			{
				echo 'Invalid Branch.';
				exit;
			}
		}
		else
		{
			echo 'Invalid Request.';
			exit;
		}
	}

}

?>