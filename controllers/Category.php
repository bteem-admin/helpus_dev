<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_logged')!="yes:tracking_user" && $this->session->userdata('user_type')!="superadmin")
		{
			redirect(base_url().'index.php/Home');
			exit;
		}		
		$this->load->model('Category_model');
	}
	
	function index()
	{	
		$show_data = array();	
		$show_data['error']='';
		$show_data['success']=$this->session->userdata('success');
		$this->clearmessage();
		
		if(isset($_POST['create_category']))
		{
			$this->load->library('form_validation');			
			$config = array(
				array(
                     'field'   => 'main_category', 
                     'label'   => 'Type', 
                     'rules'   => 'required'
                  ),
				array(
                     'field'   => 'category', 
                     'label'   => 'Category', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$info = array();
				$info['main_category'] = $this->input->post('main_category');
				$info['category'] = $this->input->post('category');
				$info['status'] = 1;
				$info['created_date'] = date('Y-m-d h:i:s');

				$result = $this->Category_model->create_category($info);	
				
				if($result>0)
				{
					$this->success('<p class="success">Category has been added successfully</p>');
					redirect('index.php/category');
					exit;					
				}
			}
		}
		if(isset($_POST['edit_category']))
		{
			$this->load->library('form_validation');			
			$config = array(
				array(
                     'field'   => 'main_category', 
                     'label'   => 'Type', 
                     'rules'   => 'required'
                  ),
				array(
                     'field'   => 'category', 
                     'label'   => 'Category', 
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{		
				$info = array();

				$category_id = $this->input->post('category_id');
				$info['main_category'] = $this->input->post('main_category');
				$info['category'] = $this->input->post('category');
				$info['status'] = $this->input->post('estatus');
				
				$result = $this->Category_model->update_category($info,$category_id);
				
				if($result>0)
				{
					$this->success('<p class="success">Category have been updated successfully</p>');
					redirect('index.php/category');
				}
			}
		}
		
		$condition = '';
		$show_data['role_array'] = $this->Category_model->getall_category($condition);
		$this->load->view('category_view',$show_data);		
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
			$all_main_categories = $this->Category_model->getall_main_categories($conditions);

			$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Add Category</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="category_registration" name="category_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Type
											</label>
											<div class="input__area">		
												<select class="input" name="main_category" id="main_category">
													<option value="">select</option>';
													foreach($all_main_categories as $category)
													{
														$ret_result.='<option value="'.$category['id'].'">'.$category['main_category'].'</option>';
													}
									$ret_result.='</select>
												<div id="error_main_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<input type="text" value="" class="input" name="category" id="category" placeholder="Category">
												<div id="error_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>										

										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>					
											<input type="submit" name="create_category" id="create_category" class="submit__button" style="float:none;" value="Create Category" onclick="return category_registration_validation()">
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
			$category_id = $data['id'];
			$condition=' WHERE cat.id='.$category_id;
			$category_details = $this->Category_model->get_category($condition);

			$conditions = " WHERE status=1";
			$all_main_categories = $this->Category_model->getall_main_categories($conditions);

			if(sizeof($category_details)>0)
			{
				$disableselect =  $category_details['status']==0?'selected':'';
				$enableselect =  $category_details['status']==1?'selected':'';
				
				$CreatedDTObj = new DateTime($category_details['created_date']);
				$createddatetime = $CreatedDTObj->format('d-m-Y H:i:s');

				$ret_result='';
				$ret_result.='<div class="pogin__popuphd" style="text-transform:uppercase">
								<h2>Edit Category</h2>
								<div class="close__btn" onclick="closePopup()"></div>
							</div>
							<div class="loginmsg__box"></div>
							<form action="" id="edit_category_registration"  name="edit_category_registration" enctype="multipart/form-data" method="post">
								<div class="">
									<div class="form">
										<div class="field" role="user-name">
											<label style="padding:0;">
												Type
											</label>
											<div class="input__area">		
												<select class="input" name="main_category" id="main_category">
													<option value="">select</option>';
													foreach($all_main_categories as $category)
													{
														$selected = $category_details['main_category_id'] == $category['id']?'selected':'';
														$ret_result.='<option value="'.$category['id'].'" '.$selected.'>'.$category['main_category'].'</option>';
													}
									$ret_result.='</select>
												<div id="error_main_category" class="val__msgbx"></div>
												</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Category
											</label>
											<div class="input__area">		
												<input type="text" value="'.$category_details['category'].'" class="input" name="category" id="category" placeholder="Category">
												<div id="error_category" class="val__msgbx"></div>
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
											<input type="hidden" value="'.$category_details['id'].'" name="category_id" id="category_id">
											<input type="submit" name="edit_category" id="edit_category" class="submit__button" style="float:none;" value="Edit Category" onclick="return edit_category_registration_validation()">
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