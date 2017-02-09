<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Function_role_mapping extends CI_Controller {

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
		
		if(isset($_POST['create_function_role_mapping']))
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
                     'field'   => 'role', 
                     'label'   => 'Role', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$info = array();
				for ($k = 0; $k < sizeof($this->input->post('function')); $k++) 
				{
					$info['category_id'] = $this->input->post('category');
					$info['department_id'] = $this->input->post('department');
					$info['role_id'] = $this->input->post('role');
					$info['function_id'] = $this->input->post('function')[$k];
					$info['status'] = 1;
					$info['created_date'] = date("Y-m-d H:i:s");

                   	$result = $this->Generalsettings_model->create_function_role_mapping($info);
                }					
				
				if($result>0)
				{
					$this->success('<p class="success">Function Role Mapping has been successfully done</p>');
					redirect('index.php/Function_role_mapping');
					exit;					
				}
			}
		}
		if(isset($_POST['edit_function_role_mapping']))
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
                     'field'   => 'role', 
                     'label'   => 'Role', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{			
				$info = array();				
				
				//$info['role_id'] = $this->input->post('erole');
                //$info['function_id'] = $this->input->post('efunction');
                //$info['status'] = $this->input->post('estatus');

				$this->Generalsettings_model->get_previous_data($this->input->post('role'),$this->input->post('category'),$this->input->post('department'));

                for ($k = 0; $k < sizeof($this->input->post('efunction')); $k++) 
				{
					$info['category_id'] = $this->input->post('category');
					$info['department_id'] = $this->input->post('department');
					$info['role_id'] = $this->input->post('role');
					$info['function_id'] = $this->input->post('efunction')[$k];
					$info['status'] = $this->input->post('estatus');
					$info['created_date'] = date("Y-m-d H:i:s");

                   	$result = $this->Generalsettings_model->create_function_role_mapping($info);
                }	
				
				if($result>0)
				{
					$this->success('<p class="success">Function Role Mapping has been updated successfully</p>');
					redirect('index.php/Function_role_mapping');
				}
			}
		}
		
		$condition = '';
		$show_data['function_role_mapped_array'] = $this->Generalsettings_model->getall_mapped_function_role($condition);
		$this->load->view('manage_function_role_mapping_view',$show_data);		
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
			$role_condition='';
			//$function_condition='WHERE ur.client_id='.$this->session->userdata('user_id').' AND frm.status=1';

			$user_role_array = $this->Generalsettings_model->get_all_role($role_condition);
			$function_array = $this->Generalsettings_model->get_all_functions();

			$conditions = " WHERE status=1";
			$all_categories = $this->Generalsettings_model->getall_categories($conditions);

			$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Add Mapping</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" name="function_role_mapping_registration" id="function_role_mapping_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<select class="inputselect" name="category" id="category" onchange="get_function_role_department(this.value);">
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

										<div id="fn_role_dept"></div>
										
										<hr/>';
										if(sizeof($function_array)>0)
										{									
										$ret_result.='<div class="field" role="user-name">
												<label style="padding:0; text-decoration:underline;">
													Functions				
												</label><br>
												<div class="input__area">';
												foreach($function_array as $function)
												{
													$ret_result.='<input type="checkbox" value="'.$function['id'].'" name="function[]" id="function">'.$function['function_name'].'<br>';
												}
												$ret_result.='<div id="" class="val__msgbx"></div>
												</div>
												<div class="clear"></div>
											</div>';
										}
										else
										{
										$ret_result.='<div class="field" role="user-name">
														<label style="padding:0;">
															&nbsp;				
														</label>			
														FUNCTIONS NOT FOUND
													</div>';	
										}
										
                                                                                
										
									$ret_result.='<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>					
											<input type="submit" name="create_function_role_mapping" id="create_function_role_mapping" class="submit__button" style="float:none;" value="Create" onclick="return function_role_mapping_validation()">
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
		// echo "<pre>";
		// print_r($_POST);die;
		if(isset($_POST['mapping_id'])&&$_POST['mapping_id']!='' && (isset($_POST['category_id'])&&$_POST['category_id']!='') && (isset($_POST['role_id'])&&$_POST['role_id']!='') && (isset($_POST['department_id'])&&$_POST['department_id']!='') )
		$data['mapping_id'] =  $_POST['mapping_id'];
		$category_id = $_POST['category_id'];
		$role_id = $_POST['role_id'];
		$department_id = $_POST['department_id'];
		
		if(isset($data['mapping_id'])&&$data['mapping_id']!=''&&$this->session->userdata('user_logged')=="yes:tracking_user" && (isset($_POST['role_id'])&&$_POST['role_id']!='') && (isset($_POST['category_id'])&&$_POST['category_id']!='') && (isset($_POST['department_id'])&&$_POST['department_id']!='') )
		{	
			$role_condition=' WHERE category='.$category_id;
			$user_role_array = $this->Generalsettings_model->get_category_roles($role_condition);
			$user_department_array = $this->Generalsettings_model->get_category_departments($role_condition);

			$function_array = $this->Generalsettings_model->get_all_functions();

			$conditions = ' WHERE id='.$data['mapping_id'];	
			$mapped_details = $this->Generalsettings_model->get_function_role_mapping_details($conditions);

			$conditions = ' WHERE category_id='.$mapped_details['category_id'].' AND role_id='.$mapped_details['role_id'].' AND department_id='.$mapped_details['department_id'];
			$selected_functions = $this->Generalsettings_model->get_selected_functions($conditions);
			
			foreach($selected_functions as $s_function)
			{
				$sel_function[] = $s_function['function_id'];
				$sel_category[] = $s_function['category_id'];
				$sel_role[] = $s_function['role_id'];
				$sel_department[] = $s_function['department_id'];
			}

			$conditions = " WHERE status=1";
			$all_categories = $this->Generalsettings_model->getall_categories($conditions);


			if(sizeof($mapped_details)>0)
			{
					$disableselect =  $mapped_details['status']==0?'selected':'';
					$enableselect =  $mapped_details['status']==1?'selected':'';
					
					$CreatedDTObj = new DateTime($mapped_details['created_date']);
					$createddatetime = $CreatedDTObj->format('d-m-Y H:i:s');
					
					$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Edit Mapping</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" name="edit_function_role_mapping_registration" id="edit_function_role_mapping_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
											<div class="field" role="user-name">
												<label style="padding:0;">
													Category
												</label>
												<div class="input__area">		
													<select class="inputselect" name="category" id="category" onchange="get_function_role_department(this.value);">
														<option value="">select</option>';
														foreach($all_categories as $category)
														{
															//$selected = $category_id==$category['id']?'selected':'';
															$selected = in_array($category['id'],$sel_category)?'selected':'';
															$ret_result.='<option value="'.$category['id'].'" '.$selected.'>'.$category['category'].'</option>';
														}
										$ret_result.='</select>
													<div id="error_category" class="val__msgbx"></div>
													</div>
												<div class="clear"></div>
											</div>';

											if(sizeof($user_role_array)>0)
											{
												$ret_result.='<div class="field" role="user-name">
															<label style="padding:0;">
																Role
															</label>
															<div class="input__area">
																<select class="input" name="role" id="role">
																	<option value="" >Select</option>';
																	foreach($user_role_array as $role)
																	{	
																		// $selected = $role_id==$role['role_id']?'selected':'';
																		$selected = in_array($role['role_id'],$sel_role)?'selected':'';
																		$ret_result.='<option value="'.$role['role_id'].'" '.$selected.' >'.$role['role'].'</option>';								
																	}
													$ret_result.='</select>
															<div id="error_role" class="val__msgbx"></div>
															</div>
															<div class="clear"></div>
														</div>';

											}
											if(sizeof($user_department_array)>0)
											{
												// echo "<pre>";
												// print_r($user_department_array);die;
												$ret_result.='<div class="field" role="user-name">
															<label style="padding:0;">
																Department
															</label>
															<div class="input__area">
																<select class="input" name="department" id="department">
																	<option value="">Select</option>';
																	foreach($user_department_array as $department)
																	{
																		// $selected = $department_id==$department['department_id']?'selected':'';	
																		$selected = in_array($department['department_id'],$sel_department)?'selected':'';
																		$ret_result.='<option value="'.$department['department_id'].'" '.$selected.'>'.$department['department_name'].'</option>';
																	}
													$ret_result.='</select>
																<div id="error_department" class="val__msgbx"></div>
															</div>
															<div class="clear"></div>
														</div>';

											}

											if(sizeof($function_array)>0)
											{									
											$ret_result.='<div class="field" role="user-name">
													<label style="padding:0; text-decoration:underline;">
														Functions				
													</label><br>
													<div class="input__area">';
														foreach($function_array as $function)
														{
															$selected_function = in_array($function['id'],$sel_function)?'checked':'';
															$ret_result.='<input type="checkbox" value="'.$function['id'].'" name="efunction[]" id="efunction" '.$selected_function.'>'.$function['function_name'].'<br>';
														}
													$ret_result.='<div id="" class="val__msgbx"></div>
													</div>
													<div class="clear"></div>
												</div>';
											}
											else
											{
											$ret_result.='<div class="field" role="user-name">
															<label style="padding:0;">
																&nbsp;				
															</label>			
															FUNCTIONS NOT FOUND
														</div>';	
											}
										$ret_result.='<div class="field" role="user-name">
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
												<input type="hidden" value="'.$mapped_details['id'].'" name="id[]" id="id">
												<input type="submit" name="edit_function_role_mapping" id="edit_function_role_mapping" class="submit__button" style="float:none;" value="Update" onclick="return edit_function_role_mapping_validation()">
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


	function get_fn_category_role()
	{
		$result='';

		if(isset($_POST['category_id']) && $_POST['category_id']!='')
		{			
			$category_id=$_POST['category_id'];

			$this->load->model('User_model');
			$condition =" WHERE category=".$category_id;
			$defined_user_roles=$this->User_model->user_roles($condition);
			$defined_user_departments=$this->User_model->user_department($condition);

			if(sizeof($defined_user_roles)>0)
			{
				$result.='<div class="field" role="user-name">
							<label style="padding:0;">
								Role
							</label>
							<div class="input__area">
								<select class="input" name="role" id="role">
									<option value="" >Select</option>';
									foreach($defined_user_roles as $role)
									{	
										$result.='<option value="'.$role['role_id'].'" >'.$role['role'].'</option>';								
									}
					$result.='</select>
							<div id="error_role" class="val__msgbx"></div>
							</div>
							<div class="clear"></div>
						</div>';

			}
			if(sizeof($defined_user_departments)>0)
			{
				$result.='<div class="field" role="user-name">
							<label style="padding:0;">
								Department
							</label>
							<div class="input__area">
								<select class="input" name="department" id="department">
									<option value="">Select</option>';
									foreach($defined_user_departments as $department)
									{	
										$result.='<option value="'.$department['department_id'].'" >'.$department['department_name'].'</option>';
									}
					$result.='</select>
								<div id="error_department" class="val__msgbx"></div>
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