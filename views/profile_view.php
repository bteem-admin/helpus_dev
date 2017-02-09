<?php require('includes/head.php'); ?>
	<title>BTEEM</title>
	<script>
		$(document).ready(function(){			
		});
	</script>
</head>

<body>
	<div class="main bg1">

		<?php
		require('includes/dashboard_header.php'); 
		?>
		<div class="clear"></div>
		<div class="body_content">
			<div class="msg__box">
				<?php echo validation_errors(); ?>
			</div>
		
				<div class="edit_section">
					<div class="col1">
						<?php
						// if($this->session->userdata('user_type_id') == 2 || $this->session->userdata('user_type_id') == 3 ||$this->session->userdata('user_type_id') == 4)
						// {
						?>
						<div class="pogin__popuphd" style="text-transform:uppercase">
							<h2>Edit Profile</h2>
						</div>
						<?php
						// }
						?>
						<div class="msg__box">
							<?php echo $success; ?>
						</div>
						<div class="loginmsg__box"></div>
						<form action="" enctype="multipart/form-data" method="post" name="profile_edit_validation" id="profile_edit_validation">
							<div class="">
								<div class="form">
									<?php
									// if($this->session->userdata('user_type_id') == 4)
									// {
									?>
										<div class="field" role="user-name">
											<label style="padding:0;">
												First Name
											</label>
											<div class="input__area">
												<input type="text" value="<?php echo $profile_array['f_name']; ?>" class="input" name="f_name" id="f_name" placeholder="First Name">
												<div id="error_company_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Middle Name
											</label>
											<div class="input__area">
												<input type="text" value="<?php echo $profile_array['m_name']; ?>" class="input" name="m_name" id="m_name" placeholder="Middle Name">
												<div id="error_m_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Last Name
											</label>
											<div class="input__area">				
												<input type="text" value="<?php echo $profile_array['l_name']; ?>" class="input" name="l_name" id="l_name" placeholder="Last Name">
												<div id="error_l_name" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Email
											</label>
											<div class="input__area">					
												<input type="text" value="<?php echo $profile_array['email']; ?>" class="input" name="email" id="email" placeholder="Email">
												<div id="error_email" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										<div class="field" role="user-name">
											<label style="padding:0;">
												Contact No
											</label>
											<div class="input__area">					
												<input type="text" value="<?php echo $profile_array['primary_contact_no']; ?>" class="input" name="primary_contact_no" id="primary_contact_no" placeholder="Contact No">
												<div id="error_primary_contact_no" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										
										<div class="field" role="user-name">
											<label style="padding:0;">
												Department
											</label>					
											<div class="input__area">
												<?php echo $this->session->userdata('department'); ?>
												<div id="" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>
										
										<div class="field" role="user-name">
											<label style="padding:0;">
												Profile Pic				
											</label>					
											<div class="input__area">
												<input type="file" name="profile_pic" id="profile_pic" class="input">
												<div id="error_profile_pic" class="val__msgbx"></div>
											</div>
											<div class="clear"></div>
										</div>

										<div class="field" role="user-name">
											<label style="padding:0;">
												&nbsp;				
											</label>					
											<input type="submit" name="editprofile_employee" id="editprofile_employee" class="submit__button" style="float:none;" value="Edit Profile" onclick="return employee_profile_edit_validation()">
										</div>
									<?php
									// }
									?>
													
								</div>
							</div>
						</form>
					</div>
					<div class="col2">
						<div class="pogin__popuphd" style="text-transform:uppercase">
							<h2>Change Password</h2>
						</div>
						<div class="msg__box">
							<?php echo validation_errors(); ?>
						</div>
						<form action="" enctype="multipart/form-data" method="post">
							<div class="">
								<div class="form">
									<div class="field" role="user-name">
										<label style="padding:0;">
											New Password
										</label>
										<input type="password" class="input" name="n_password" id="n_password" placeholder="Password" autocomplete='off'>
									</div>
									<div class="field" role="user-name">
										<label style="padding:0;">
											Re Password
										</label>
										<input type="password" class="input" name="re_password" id="re_password" placeholder="Re-Password" autocomplete='off'>
									</div>
									<div class="field" role="user-name">
										<label style="padding:0;">
											&nbsp;				
										</label>					
										<input type="submit" name="changepassword" id="changepassword" class="submit__button" style="float:none;" value="Change Password">
									</div>										
								</div>
							</div>
						</form>
					</div>
				</div>
			<div class="clear"></div>														
		</div>

		<div>
			<div class="copyright">
				Powered By ------- , All Rights Reserved
			</div>		
		</div>
	</div>	
	<?php require('includes/footer.php'); ?>
</body>
</html>