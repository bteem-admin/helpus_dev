<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_logged')!="yes:tracking_user" && $this->session->userdata('user_type')!="superadmin")
		{
			redirect(base_url().'index.php/Home');
			exit;
		}		
		$this->load->helper('security');
		$this->load->model('User_model');
	}
	
	function index()
	{	
		$show_data = array();	
		$show_data['error']='';
		$show_data['success']=$this->session->userdata('success');
		$this->clearmessage();
		
		if(isset($_POST['create_user']))
		{
			$this->load->library('form_validation');			
			$config = array(
               array(
                     'field'   => 'f_name', 
                     'label'   => 'First Name', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'l_name', 
                     'label'   => 'Last Name', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'e_email', 
                     'label'   => 'Email id', 
                     'rules'   => 'required|is_unique[employee.email]|valid_email'
                  ),			   
			   array(
                     'field'   => 'contact_no1', 
                     'label'   => 'Contact No', 
                     'rules'   => 'required'
                  )		   	   
			  // array(
     //                 'field'   => 'role', 
     //                 'label'   => 'Role', 
     //                 'rules'   => 'required'
     //              ),
			  //  array(
     //                 'field'   => 'department', 
     //                 'label'   => 'Department', 
     //                 'rules'   => 'required'
     //              )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$user_info = array();			
				
				$user_info['f_name'] = $this->input->post('f_name');
				$user_info['m_name'] = $this->input->post('m_name');
				$user_info['l_name'] = $this->input->post('l_name');
				$user_info['email'] = $this->input->post('e_email');
				$user_info['primary_contact_no'] = $this->input->post('contact_no1');
				$user_info['secondary_contact_no'] = $this->input->post('contact_no2');
			
				$result = $this->User_model->create_internal_user($user_info);	
				
				if($result>0)
				{
					$info = array();

					foreach($this->input->post('category') as $category)
					{
						foreach($this->input->post('department')[$category] as $department)
						{
							$info['employee_id'] = $result;
							$info['category'] = $category;
							$info['department'] = $department;
							$info['role'] = $this->input->post('role')[$category];

							$this->User_model->create_user_category_department_role($info);	
						}
					}

					$user_credential = array();
					$user_credential['employee_id'] = $result;
					// $user_credential['user_role_id'] = $this->input->post('role');
					$user_credential['employee_code']= 'EMP-T-'.str_pad($result, 3, '0', STR_PAD_LEFT);
					$user_credential['username'] = $this->input->post('e_email'); //$this->input->post('username');
					$password = $this->randomPassword();
					$user_credential['password']= md5($password);
					$user_credential['status'] = 1;
					$user_credential['created_date'] = date('Y-m-d h:i:s');								
					
					$uresult = $this->User_model->create_internal_userlogin($user_credential);					
					if($uresult>0)
					{
						$message = '';
						$message .= 'You have successfully registered as User <br /><br />';
						$message .= 'First Name: '.$user_info['f_name'].'<br /><br />';
						$message .= 'Surname: '.$user_info['l_name'].'<br /><br />';
						$message .= 'Contact Number: '.$user_info['primary_contact_no'].'<br /><br />';
						$message .= 'E Mail Address: '.$user_info['email'].'<br /><br />';
						$message .= 'Username: '.$user_credential['username'].'<br /><br />';
						$message .= 'Password: '.$password.'<br /><br />';					
						
						$this->load->library('email');
						$this->email->to($user_info['email']);
						$this->email->from('no-reply.com');
						$this->email->subject('User Details');
						$this->email->message($message);
						
						// if ($this->email->send())
						// {
						// 	$subagnet_message = 'Dear '.$this->input->post('f_name').' '.$this->input->post('l_name').': Your Username : '.$user_credential['username'].' Password : '.$password;  //Your agnet has changed to Your agent ; changed by Athul;
						// 	$this->send_sms($subagnet_message,$user_info['phone_no']);
						// }
						$this->success('<p class="success">User has been added successfully</p>');
						redirect('index.php/User');
						exit;
					}
					
				}
			}
		}
		if(isset($_POST['edit_user'])&&$_POST['ef_name']!='')
		{
			$this->load->library('form_validation');			
			$config = array(
               array(
                     'field'   => 'ef_name', 
                     'label'   => 'First Name', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'el_name', 
                     'label'   => 'Last Name', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'e_email', 
                     'label'   => 'Email', 
                     'rules'   => 'required|valid_email'
                  ),			   
			   array(
                     'field'   => 'econtact_no1', 
                     'label'   => 'Contact No', 
                     'rules'   => 'required'
                  )   
			   // array(
      //                'field'   => 'role', 
      //                'label'   => 'Role', 
      //                'rules'   => 'required'
      //             ),
			   // array(
      //                'field'   => 'department', 
      //                'label'   => 'Department', 
      //                'rules'   => 'required'
      //             )
			  
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{			
				$user_info = array();
				
				$employee_id=$this->input->post('employee_id');
				$role_id=$this->input->post('role_id');
				$user_info['f_name'] = $this->input->post('ef_name');
				$user_info['m_name'] = $this->input->post('em_name');
				$user_info['l_name'] = $this->input->post('el_name');
				$user_info['email'] = $this->input->post('e_email');
				$user_info['primary_contact_no'] = $this->input->post('econtact_no1');
				$user_info['secondary_contact_no'] = $this->input->post('econtact_no2');
				
				$result = $this->User_model->update_internal_user($user_info,$employee_id);

				$info = array();
				$this->User_model->clear_category_dept_role($employee_id);
				foreach($this->input->post('category') as $category)
				{
					foreach($this->input->post('department')[$category] as $department)
					{
						$info['employee_id'] = $employee_id;
						$info['category'] = $category;
						$info['department'] = $department;
						$info['role'] = $this->input->post('role')[$category];

						$this->User_model->create_user_category_department_role($info);	
					}
				}
				
				if($result>0)
				{
					$this->success('<p class="success">User details have been updated successfully</p>');
					redirect('index.php/User');
				}
			}
		}
		
		$show_data['user_array'] = $this->User_model->getall_users();
		$this->load->view('user_view',$show_data);		
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
	
	function randomPassword() 
	{
		$alphabet = "0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	
	function add()
	{
		$ret_result='';

		$condition = ' WHERE category!=0';
		$role_array = $this->User_model->getall_role($condition);
				
		$condition=' WHERE status=1';

		$category_array = $this->User_model->getall_category($condition);
		$department_array = $this->User_model->getall_departments($condition);

		if($this->session->userdata('user_logged')=="yes:tracking_user")
		{
			$ret_result.='<script type="text/javascript" src="'.base_url().'js/script.js"></script>
        				<script type="text/javascript" src="'.base_url().'js/script_validation.js"></script>

        				<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Add Employee</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="user_registration" name="user_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												First Name				
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="f_name" id="f_name" placeholder="First Name">
												<div id="error_f_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Middle Name
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="m_name" id="m_name" placeholder="Middle Name">
												<div id="" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Last Name				
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="l_name" id="l_name" placeholder="Last Name">
												<div id="error_l_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Email				
											</label>
											<div class="input__area">
												<input type="text" value="" class="input email" name="e_email" id="email" placeholder="Email">
												<div id="error_email" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Contact No. -1
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="contact_no1" id="contact_no1" placeholder="Phone No">
												<div id="error_contact_no1" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>										
										<div class="field" role="user-name">
											<label style="padding:0;">
												Contact No. -2	
											</label>
											<div class="input__area">
												<input type="text" value="" class="input" name="contact_no2" id="contact_no2" placeholder="Phone No">
												<div id="" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">';
												foreach($category_array as $category)
												{
													$ret_result.='<input type="checkbox" class="" value="'.$category['id'].'" name="category[]" id="category_'.$category['id'].'" onclick="get_user_role(this.value)">'.$category['category'].'<br>
																	<div id="category_dept_'.$category['id'].'"></div>';												
												}
								 				$ret_result.='<div id="error_category" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
																			
										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>					
											<input type="submit" name="create_user" id="create_user" class="submit__button" style="float:none;" value="Create User" onclick="return user_registration_validation()">
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

		$condition = ' WHERE category!=0';
		$role_array = $this->User_model->getall_role($condition);
		
		$condition=' WHERE status=1';
		$category_array = $this->User_model->getall_category($condition);
		$department_array = $this->User_model->getall_departments($condition);	
		
		if(isset($data['id'])&&$data['id']!=''&&$this->session->userdata('user_logged')=="yes:tracking_user")
		{			
			$user_details = $this->User_model->get_userdetails($data);

			$condition =" WHERE employee_id=".$data['id'];
			$selected_user_category_roles_array=$this->User_model->user_roles_department($condition);
			
			if(sizeof($selected_user_category_roles_array)>0)
			{
				foreach($selected_user_category_roles_array as $category)
				{
					$selected_user_category_roles[] = $category['category'];
					$selected_user_roles[] = $category['role'];
					$selected_user_departments[] = $category['department'];

					$condition = " WHERE category=".$category['category'];
					$role_array=$this->User_model->user_roles($condition);
					$defined_user_roles[$category['category']] = $role_array;

					$department_array = $this->User_model->getall_departments($condition);	
					$defined_user_departments[$category['category']] = $department_array;
				}
			}

			if(sizeof($user_details)>0)
			{
				$disableselect =  $user_details['emp_status']==0?'selected':'';
				$enableselect =  $user_details['emp_status']==1?'selected':'';
				
				$CreatedDTObj = new DateTime($user_details['created_date']);
				$createddatetime = $CreatedDTObj->format('d-m-Y H:i:s');
				
				$ret_result='';
				$ret_result.='<script type="text/javascript" src="'.base_url().'js/script.js"></script>
        					<script type="text/javascript" src="'.base_url().'js/script_validation.js"></script>

        					<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Edit Employee</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="edit_user_registration" name="edit_user_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												First Name				
											</label>
											<div class="input__area">					
												<input type="text" value="'.$user_details['f_name'].'" class="input" name="ef_name" id="ef_name" placeholder="First Name">
												<div id="error_ef_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Middle Name
											</label>
											<div class="input__area">		
												<input type="text" value="'.$user_details['m_name'].'" class="input" name="em_name" id="em_name" placeholder="Middle Name">
												<div id="" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Last Name				
											</label>
											<div class="input__area">					
												<input type="text" value="'.$user_details['l_name'].'" class="input" name="el_name" id="el_name" placeholder="Last Name">
												<div id="error_el_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Email				
											</label>
											<div class="input__area">					
												<input type="text" value="'.$user_details['email'].'" class="input email" name="e_email" id="email" placeholder="Email">
												<div id="error_email" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Contact No. -1
											</label>
											<div class="input__area">
												<input type="text" value="'.$user_details['primary_contact_no'].'" class="input" name="econtact_no1" id="econtact_no1" placeholder="Phone No">
												<div id="error_econtact_no1" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>										
										<div class="field" role="user-name">
											<label style="padding:0;">
												Contact No. -2	
											</label>
											<div class="input__area">
												<input type="text" value="'.$user_details['secondary_contact_no'].'" class="input" name="econtact_no2" id="econtact_no2" placeholder="Phone No">
												<div id="" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>	

										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">';
												foreach($category_array as $category)
												{
													$check = in_array($category['id'],$selected_user_category_roles)?'checked':'';
													$ret_result.='<input type="checkbox" class="" value="'.$category['id'].'" name="category[]" id="category_'.$category['id'].'" onclick="get_user_role(this.value)" '.$check.'>'.$category['category'].'<br>
																	<div id="category_dept_'.$category['id'].'">';
																		if(isset($defined_user_roles[$category['id']]))
																		{
																		$ret_result.='<div class="field" role="user-name">
																						<label style="padding:0; width:100px;">
																							Role:
																						</label>
																						<div class="input__area">
																							<select class="input" name="role['.$category['id'].']" id="role">
																								<option value="" >Select</option>';
																								foreach($defined_user_roles[$category['id']] as $role)
																								{	
																									$selected = in_array($role['role_id'],$selected_user_roles)?'selected':'';
																									$ret_result.='<option value="'.$role['role_id'].'" '.$selected.'>'.$role['role'].'</option>';								
																								}
																								$ret_result.='</select>
																							<div id="" class="val__msgbx"></div>
																						</div>
																						<div class="clear"></div>
																					</div>';
																		}
															
																		if(isset($defined_user_departments[$category['id']]))
																		{
																			$ret_result.='<div class="field" role="user-name">
																							<label style="padding:0; width:100px;">
																								Department:
																							</label>
																							<div class="input__area">';
																								foreach($defined_user_departments[$category['id']] as $department)
																								{	
																									$checked = in_array($department['id'],$selected_user_departments)?'checked':'';
																									$ret_result.='<input type="checkbox" name="department['.$category['id'].'][]" id="department" value="'.$department['id'].'" '.$checked.' >'.$department['department_name'].'<br>';
																								}
																				$ret_result.='<div id="" class="val__msgbx"></div>
																							</div>
																							<div class="clear"></div>
																						</div>';
																		}
														$ret_result.='</div>';												
												}
								 				$ret_result.='<div id="error_category" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										
											
										<div class="field" role="user-name">
											<label>Status</label>
											<select class="inputselect" name="estatus" id="estatus">
												<option value="0" '.$disableselect.'>Disable</option>
												<option value="1" '.$enableselect.'>Enable</option>													
											</select>
										</div>

										<div class="field" role="user-name">
											<label style="padding:0;">
												Created Date	
											</label>					
											'.$createddatetime.'
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>
											<input type="hidden" value="'.$user_details['id'].'" name="employee_id" id="employee_id">
											<input type="submit" name="edit_user" id="edit_user" class="submit__button" style="float:none;" value="Edit User" onclick="return edit_user_registration_validation()">
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
				echo 'Invalid User.';
				exit;
			}
		}
		else
		{
			echo 'Invalid Request.';
			exit;
		}
	}


	function get_existing_username()
	{
		$result='';

		if(isset($_POST['username']) && $_POST['username']!='' && (isset($_POST['email']) && $_POST['email']!=''))
		{			
			$username=$_POST['username'];
			$email=$_POST['email'];

			$existing_username=$this->User_model->unique_username($username,$email);

			if(sizeof($existing_username) > 0)
			{
				$result.='existing';	
			}
			else
			{
				$result.='not_existing';
			}
		}
		echo $result;
		exit();
	}

	function get_existing_email()
	{
		$result='';

		if(isset($_POST['email']) && $_POST['email']!='')
		{			
			$email=$_POST['email'];

			$existing_email=$this->User_model->unique_email($email);
			if(sizeof($existing_email)>0)
			{
				$result.='existing';	
			}
			else
			{
				$result='not_existing';
			}
		}
		echo $result;
		exit();
	}


	function get_user_category_role()
	{
		$result='';

		if(isset($_POST['category_id']) && $_POST['category_id']!='')
		{			
			$category_id=$_POST['category_id'];

			$condition =" WHERE category=".$category_id;
			$defined_user_roles=$this->User_model->user_roles($condition);
			$defined_user_departments=$this->User_model->user_department($condition);

			if(sizeof($defined_user_roles)>0)
			{
				$result.='<div class="field" role="user-name">
							<label style="padding:0; width:100px;">
								Role:
							</label>
							<div class="input__area">
								<select class="input" name="role['.$category_id.']" id="role">
									<option value="" >Select</option>';
									foreach($defined_user_roles as $role)
									{	
										$result.='<option value="'.$role['role_id'].'" >'.$role['role'].'</option>';								
									}
					$result.='</select>
							<div id="" class="val__msgbx"></div>
							</div>
							<div class="clear"></div>
						</div>';

			}
			if(sizeof($defined_user_departments)>0)
			{
				$result.='<div class="field" role="user-name">
							<label style="padding:0; width:100px;">
								Department:
							</label>
							<div class="input__area">';
									foreach($defined_user_departments as $department)
									{	
										$result.='<input type="checkbox" name="department['.$category_id.'][]" id="department" value="'.$department['department_id'].'" >'.$department['department_name'].'<br>';
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