<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_logged')!="yes:tracking_user" && $this->session->userdata('user_type')!="superadmin")
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
		
		if(isset($_POST['create_department']))
		{
			$this->load->library('form_validation');			
			$config = array(
				array(
                     'field'   => 'category', 
                     'label'   => 'Category', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'department', 
                     'label'   => 'Department', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'department_code', 
                     'label'   => 'Deparment Code', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$info = array();

				$info['category'] = $this->input->post('category');
				$info['department_name'] = $this->input->post('department');
				$info['department_code'] = $this->input->post('department_code');
				$info['status'] = 1;	
				$info['created_date'] = date("Y-m-d H:i:s");
				$result = $this->Generalsettings_model->create_department($info);
				
				if($result>0)
				{
					// $info_array = array();
					// for($i = 0; $i < sizeof($this->input->post('role')); $i++)
					// {
					// 	$info_array['department_id'] = $result;
					// 	$info_array['role_id'] = $this->input->post('role')[$i];

					// 	$result = $this->Generalsettings_model->create_department_role_mapping($info_array);	
					// }

					$this->success('<p class="success">Department has been added successfully</p>');
					redirect('index.php/manage_department');
					exit;					
				}
			}
		}
		if(isset($_POST['edit_department']))
		{
			$this->load->library('form_validation');			
			$config = array(
				array(
                     'field'   => 'category', 
                     'label'   => 'Category', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'edepartment', 
                     'label'   => 'Department', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'edepartment_code', 
                     'label'   => 'Department Code', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{			
				$info = array();

				$department_id = $this->input->post('id');
				$info['category'] = $this->input->post('category');
				$info['department_name'] = $this->input->post('edepartment');
				$info['department_code'] = $this->input->post('edepartment_code');
				$info['status'] = $this->input->post('estatus');
				$result = $this->Generalsettings_model->update_department($info,$department_id);					
				
				if($result>0)
				{
					// $this->Generalsettings_model->clear_category_department($department_id);
					// $info_array = array();
					// for($i = 0; $i < sizeof($this->input->post('role')); $i++)
					// {
					// 	$info_array['department_id'] = $result;
					// 	$info_array['role_id'] = $this->input->post('role')[$i];

					// 	$result = $this->Generalsettings_model->create_department_role_mapping($info_array);
					// }

					$this->success('<p class="success">Department has been updated successfully</p>');
					redirect('index.php/manage_department');
				}
			}
		}
		
		$condition='';
		$show_data['department_array'] = $this->Generalsettings_model->getall_departments($condition);
		$this->load->view('manage_department_view',$show_data);		
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
			$all_categories = $this->Generalsettings_model->getall_categories($conditions);

			$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Add Department</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="department_registration" name="department_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<select class="input" name="category" id="category" >
													<option value="">select</option>'; //onchange="get_category_role(this.value);"
													foreach($all_categories as $category)
													{
														$ret_result.='<option value="'.$category['id'].'" >'.$category['category'].'</option>';
													}
									$ret_result.='</select>
												<div id="error_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>

										<div id="category_role"></div>

										<div class="field" role="user-name">
											<label style="padding:0;">
												Department				
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="department" id="department" placeholder="Department">
												<div id="error_department" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Department Code				
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="department_code" id="department_code" placeholder="Abbreviation">
												<div id="error_department_code" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>					
											<input type="submit" name="create_department" id="create_department" class="submit__button" style="float:none;" value="Create Department" onclick="return department_registration_validation()">
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
		
		if(isset($_POST['department_id'])&&$_POST['department_id']!='')
		
		$data['department_id'] =  $_POST['department_id'];
		$department_id = $_POST['department_id'];
		
		if(isset($data['department_id'])&&$data['department_id']!=''&&$this->session->userdata('user_logged')=="yes:tracking_user")
		{
			$department_details = $this->Generalsettings_model->get_departmentdetails($department_id);

			// $condition =" WHERE category=".$category_id." ORDER BY role";
			// $category_roles=$this->Generalsettings_model->get_category_roles($condition);

			$conditions = " WHERE status=1";
			$all_categories = $this->Generalsettings_model->getall_categories($conditions);

			if(sizeof($department_details)>0)
			{
				// foreach($department_details_array as $s_category_role)
				// {
				// 	$sel_category_role[] = $s_category_role['role_id'];
				// }

				$disableselect =  $department_details['status']==0?'selected':'';
				$enableselect =  $department_details['status']==1?'selected':'';
				
				$CreatedDTObj = new DateTime($department_details['created_date']);
				$createddatetime = $CreatedDTObj->format('d-m-Y H:i:s');
				
				$ret_result='';
				$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
							<h2>Edit Department</h2>
							<div class="close__btn" onclick="closePopup()"></div>
						</div>
						<div class="loginmsg__box"></div>
						<form action=""  id="edit_department_registration" name="edit_department_registration" enctype="multipart/form-data" method="post">
							<div class="">
								<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<select class="input" name="category" id="category" onchange="get_category_role(this.value);">
													<option value="">select</option>';
													foreach($all_categories as $category)
													{
														$selected = $category['id'] == $department_details['category']?'selected':'';
														$ret_result.='<option value="'.$category['id'].'" '.$selected.'>'.$category['category'].'</option>';
													}
									$ret_result.='</select>
												<div id="error_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>';

										// <div id="category_role">
										// 	<div class="field" role="user-name">
										// 		<label style="padding:0;">
										// 			Role
										// 		</label>
										// 		<div class="input__area">';
										// 		if(sizeof($category_roles)>0)
										// 		{
										// 			foreach($category_roles as $role)
										// 			{	
										// 				$checked = in_array($role['role_id'],$sel_category_role)?'checked':'';
										// 				$ret_result.='<input type="checkbox" name="role[]" value="'.$role['role_id'].'" '.$checked.'>'.$role['role'].'<br>';
										// 			}
										// 		}
										// 		else
										// 		{
										// 			echo "No Role Found";
										// 		}
										// $ret_result.='<div id="" class="val__msgbx"></div>
										// 		</div>
										// 		<div class="clear"></div>
										// 	</div>
										// </div>

							$ret_result.='<div class="field" role="user-name">
											<label style="padding:0;">
												Department			
											</label>
											<div class="input__area">
												<input type="text" value="'.$department_details['department_name'].'" class="input" name="edepartment" id="edepartment" placeholder="Department">
												<div id="error_edepartment" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Department Code				
											</label>
											<div class="input__area">
												<input type="text" value="'.$department_details['department_code'].'" class="input" name="edepartment_code" id="edepartment_code" placeholder="Abbreviation">
												<div id="error_edepartment_code" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Status
											</label>
											<div class="input__area">
												<select class="inputselect" name="estatus" id="estatus">
													<option value="0" '.$disableselect.'>Disable</option>
													<option value="1" '.$enableselect.'>Enable</option>													
												</select>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Created Date	
											</label>
											<div class="input__area">										
												'.$createddatetime.'
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>
											<input type="hidden" value="'.$department_details['id'].'" name="id" id="id">
											<input type="submit" name="edit_department" id="edit_department" class="submit__button" style="float:none;" value="Edit Department" onclick="return edit_department_registration_validation()">
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
				echo 'Invalid Country.';
				exit;
			}
		}
		else
		{
			echo 'Invalid Request.';
			exit;
		}
	}	

	function get_category_role()
	{
		$result='';

		if(isset($_POST['category_id']) && $_POST['category_id']!='')
		{			
			$category_id=$_POST['category_id'];

			$condition =" WHERE category=".$category_id." ORDER BY role";
			$category_roles=$this->Generalsettings_model->get_category_roles($condition);

			if(sizeof($category_roles)>0)
			{
				$result.='<div class="field" role="user-name">
							<label style="padding:0;">
								Role
							</label>
							<div class="input__area">';
							foreach($category_roles as $role)
							{	
								$result.='<input type="checkbox" name="role[]" value="'.$role['role_id'].'">'.$role['role'].'<br>';
							}
					$result.='<div id="" class="val__msgbx"></div>
							</div>
							<div class="clear"></div>
						</div>';

			}
			else
			{
				$result='';
			}
		}
		echo $result;
		exit();
	}
}

?>