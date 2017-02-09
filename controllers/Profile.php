<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_logged')!="yes:tracking_user")
		{
			redirect(base_url().'index.php/Home');
			exit;
		}
		$this->load->model('Profile_model');
	}
	
	function index()
	{
		$show_data = array();
		$show_data['error']='';
		$show_data['success']=$this->session->userdata('success');
		$this->clearmessage();
		
		if(isset($_POST['editprofile_client']))
		{
			$this->load->library('form_validation');

			$config = array(
               array(
                     'field'   => 'company_name', 
                     'label'   => 'Company Name', 
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'company_email', 
                     'label'   => 'Company Email|valid_email',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'contact_person', 
                     'label'   => 'Contact Person Name',
                     'rules'   => 'required'
                  ),			   
			   array(
                     'field'   => 'contact_person_email', 
                     'label'   => 'Contact Person Email|valid_email',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'company_address', 
                     'label'   => 'Company Adress',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'postal_code', 
                     'label'   => 'Postal Code',
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$user_info = array();			
				
				if(isset($_FILES['company_logo'])&&$_FILES['company_logo']['name']!='')
				{
					$uploaddir = 'images/profile_pic/';
					
					$test = explode('.',$_FILES['company_logo']['name']);
		
					$ext = strtolower($test[sizeof($test)-1]);
					
					if($ext=='png'||$ext=='jpg'||$ext=='jpeg')
					{
						$length = strlen($_FILES['company_logo']['name'])-strlen($ext)-1;
						
						$config['file_name'] = preg_replace('/[^A-Za-z0-9]/', '', substr($_FILES['company_logo']['name'], 0, $length)).strtotime("now").'.'.$ext;
						
						$file = $uploaddir .$config['file_name']; 
						$file_name= $config['file_name'];
						
						if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $file)){				
							$this->makeThumbnails($uploaddir, $file_name);
							$user_info['company_logo'] = $file_name;
						}
					}
				}
				
				$user_id=$this->session->userdata('user_id');
				$user_info['company_name'] = $this->input->post('company_name');
				$user_info['company_email'] = $this->input->post('company_email');
				$user_info['contact_person_name'] = $this->input->post('contact_person');
				$user_info['contact_person_email'] = $this->input->post('contact_person_email');
				$user_info['company_address'] = $this->input->post('company_address');
				$user_info['postal_code'] = $this->input->post('postal_code');

				
				$result = $this->Profile_model->update_user_client($user_info,$user_id);	
				
				if($result>0)
				{
					$this->change_clientSession($this->Profile_model->get_profile_client($this->session->userdata('user_id')));
					$this->success('<p class="success">Profile has been successfully updated</p>');
					redirect('index.php/Profile');
				}
			}
		}

		if(isset($_POST['editprofile_jobseeker']))
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
                     'field'   => 'email', 
                     'label'   => 'Email',
                     'rules'   => 'required|valid_email'
                  ),			   

			   array(
                     'field'   => 'address', 
                     'label'   => 'Adress',
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$user_info = array();			
				
				if(isset($_FILES['profile_pic'])&&$_FILES['profile_pic']['name']!='')
				{
					$uploaddir = 'images/profile_pic/';
					
					$test = explode('.',$_FILES['profile_pic']['name']);
		
					$ext = strtolower($test[sizeof($test)-1]);
					
					if($ext=='png'||$ext=='jpg'||$ext=='jpeg')
					{
						$length = strlen($_FILES['profile_pic']['name'])-strlen($ext)-1;
						
						$config['file_name'] = preg_replace('/[^A-Za-z0-9]/', '', substr($_FILES['profile_pic']['name'], 0, $length)).strtotime("now").'.'.$ext;
						
						$file = $uploaddir .$config['file_name']; 
						$file_name= $config['file_name'];
						
						if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $file)){				
							$this->makeThumbnails($uploaddir, $file_name);
							$user_info['profile_pic'] = $file_name;
						}
					}
				}
				
				$user_id=$this->session->userdata('user_id');
				$user_info['f_name'] = $this->input->post('f_name');
				$user_info['l_name'] = $this->input->post('l_name');
				$user_info['email_id'] = $this->input->post('email');
				$user_info['address'] = $this->input->post('address');
				
				$result = $this->Profile_model->update_user_jobseeker($user_info,$user_id);	
				
				if($result>0)
				{
					$this->change_jobseekerSession($this->Profile_model->get_profile_jobseeker($this->session->userdata('user_id')));
					$this->success('<p class="success">Profile has been successfully updated</p>');
					redirect('index.php/Profile');
				}
			}
		}

		if(isset($_POST['editprofile_employee']))
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
                     'field'   => 'email', 
                     'label'   => 'Email',
                     'rules'   => 'required|valid_email'
                  ),			   

			   array(
                     'field'   => 'primary_contact_no', 
                     'label'   => 'Contact No',
                     'rules'   => 'required'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$user_info = array();			
				
				if(isset($_FILES['profile_pic'])&&$_FILES['profile_pic']['name']!='')
				{
					$uploaddir = 'images/profile_pic/';
					
					$test = explode('.',$_FILES['profile_pic']['name']);
		
					$ext = strtolower($test[sizeof($test)-1]);
					
					if($ext=='png'||$ext=='jpg'||$ext=='jpeg')
					{
						$length = strlen($_FILES['profile_pic']['name'])-strlen($ext)-1;
						
						$config['file_name'] = preg_replace('/[^A-Za-z0-9]/', '', substr($_FILES['profile_pic']['name'], 0, $length)).strtotime("now").'.'.$ext;
						
						$file = $uploaddir .$config['file_name']; 
						$file_name= $config['file_name'];
						
						if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $file)){				
							$this->makeThumbnails($uploaddir, $file_name);
							$user_info['profile_pic'] = $file_name;
						}
					}
				}
				
				$user_id=$this->session->userdata('user_id');
				$user_info['f_name'] = $this->input->post('f_name');
				$user_info['l_name'] = $this->input->post('l_name');
				$user_info['email'] = $this->input->post('email');
				$user_info['primary_contact_no'] = $this->input->post('primary_contact_no');
				
				$result = $this->Profile_model->update_user_employee($user_info,$user_id);	
				
				if($result>0)
				{
					$this->change_employeeSession($this->Profile_model->get_user_profile($this->session->userdata('user_id')));
					$this->success('<p class="success">Profile has been successfully updated</p>');
					redirect('index.php/Profile');
				}
			}
		}
		
		if(isset($_POST['changepassword']))
		{
			$this->load->library('form_validation');			
			$config = array(
               array(
                     'field'   => 'n_password', 
                     'label'   => 'New Password', 
                     'rules'   => 'trim|required|matches[re_password]|md5'
                  )
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() != false)
			{
				$user_info = array();				
				
				$user_info['password'] = $this->input->post('n_password');	
				
				$result = $this->Profile_model->update_userlogin($user_info,$this->session->userdata('userdetails_id'));	
				
				if($result>0)
				{
					$this->success('<p class="success">Password has been changed successfully</p>');
					redirect('index.php/Profile');
				}
                else
                {
                    $this->success('<p class="success">Password update failed</p>');
                    redirect('index.php/Profile');
                }
			}
            else
			{
				$this->success(validation_errors());
				redirect('index.php/profile');
			}
		}

		$show_data['profile_array'] = $this->Profile_model->get_user_profile($this->session->userdata('user_id'));

		$this->load->view('profile_view',$show_data);		
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
	
	private function makeThumbnails($updir, $img)
	{
		$thumbnail_width = 240;
		$thumbnail_height = 240;
		$thumb_beforeword = "thumb/";		
		$arr_image_details = getimagesize("$updir".''."$img"); // pass id to thumb name
		$original_width = $arr_image_details[0];
		$original_height = $arr_image_details[1];
		if ($original_width > $original_height) {
			$new_width = $thumbnail_width;
			$new_height = intval($original_height * $new_width / $original_width);
		} else {
			$new_height = $thumbnail_height;
			$new_width = intval($original_width * $new_height / $original_height);
		}
		$dest_x = intval(($thumbnail_width - $new_width) / 2);
		$dest_y = intval(($thumbnail_height - $new_height) / 2);
		if ($arr_image_details[2] == 1) {
			$imgt = "ImageGIF";
			$imgcreatefrom = "ImageCreateFromGIF";
		}
		if ($arr_image_details[2] == 2) {
			$imgt = "ImageJPEG";
			$imgcreatefrom = "ImageCreateFromJPEG";
		}
		if ($arr_image_details[2] == 3) {
			$imgt = "ImagePNG";
			$imgcreatefrom = "ImageCreateFromPNG";
		}		
		if ($imgt) {
			$old_image = $imgcreatefrom("$updir".''."$img");
			$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
			ImageCopyResampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
			$imgt($new_image, "$updir" . "$thumb_beforeword" . "$img");
		}
	}
	
	private function change_clientSession($result)
	{
		$userdata = array(
							'user_name' => $result['company_name'],
							'profile_pic' => $result['company_logo']
						);
		$this->session->set_userdata($userdata);		
	}
	private function change_jobseekerSession($result)
	{
		$userdata = array(
							'user_name' => $result['f_name'].' '.$result['l_name'],
							'profile_pic' => $result['profile_pic']
						);
		$this->session->set_userdata($userdata);		
	}
	private function change_employeeSession($result)
	{
		$userdata = array(
							'user_name' => $result['f_name'].' '.$result['l_name'],
							'profile_pic' => $result['profile_pic']
						);
		$this->session->set_userdata($userdata);		
	}
}

?>