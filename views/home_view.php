<!DOCTYPE html>
<html>
	<?php require('includes/head.php'); ?>
	<title>BTEEM</title>
	<script>
		$(document).ready(function(){
		});
	</script>
</head>

<body>
	<div class="main bg1">
		<?php //require('includes/header.php'); ?>
		<?php //require('includes/google-login-api/index.php'); ?>

		<div class="banner">
			<div class="banner_left_common">
				<div class="banner_animated_icon_left"></div>
				<div class="banner_animated_icon_right_common"></div>
				<div class="clear"></div>
			</div>

			<div class="banner_right">
				<div class="login__bx p-8">
					<div class="val__log_msgbx">
						<?php echo $error; ?>
					</div>
					<form action="" method="post" name="login_validation" id="login_validation">
						<div class="form">
							<div class="sign_in">SIGN IN</div>
							<!-- <div class="input__area">
								<div class="login_type" id="login_type" name="login_type">
									<input type="radio" name="login_type" id="jobseeker" value="3">Jobseeker
									<input type="radio" name="login_type" id="client" value="2">Company
									<div id="error_login_type" class="val__log_msgbx"></div>
								</div>
								<div class="clear"></div>
							</div> -->
							<div class="field" role="hash-code">
								<label style="padding:0;width:135px; font-size: 14px; color:#FFFFFF;">
									User Name				
								</label>
								<div class="input__area">				
									<input type="text" value="" class="input" name="ls_username" id="ls_username" placeholder="User Name" >
									<div id="error_ls_username" class="val__log_msgbx"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="field" role="hash-code">
								<label style="padding:0;width:135px; font-size: 14px; color:#FFFFFF;">
									Password				
								</label>
								<div class="input__area">			
									<input type="password" value="" class="input" name="ls_password" id="ls_password" placeholder="Password" >
									<div id="error_ls_password" class="val__log_msgbx"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="field" role="hash-code">
								<label style="padding:0;">
									&nbsp;				
								</label>					
								<input type="submit" name="adminlogin" id="adminlogin" class="submit__btn" style="float:right;" value="Login" onclick="return login_validate()">
								<div class="clear"></div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<br/><br/>
		<div class="copyright">
			Powered By ----- , All Rights Reserved
		</div>
	</div>
	<?php require('includes/footer.php'); ?>
</body>
</html>