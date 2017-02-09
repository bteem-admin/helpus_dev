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
		<?php require('includes/dashboard_header.php'); ?>
		<div class="clear"></div>
		<div class="body_content">
			<div class="main_bg_2">
				<?php //require('includes/col__1.php'); 
				$this->load->view('includes/col__1');
				?>
			</div>
			
			<div class="col__2">
				<div class="msg__box">
					<?php echo $success; ?>
				</div>
				<div class="admin__profile">
					<div class="adminpro__top">
						<?php
							if($propic=='')
							{
								$profile_img = base_url().'images/admin/profilepic/default.png';
							}
							else
							{
								$profile_img = base_url().'images/profile_pic/'.$propic;
							}
						?>
						<img src="<?php echo $profile_img; ?>" class="admin_profilepic" />
					</div>
					<div class="adminpro__bottom">
						<div class="admin__name">
							<?php echo $name; ?>
						</div>
						<?php
						// if(in_array(1, $this->session->userdata('function')))
						// {
						?>
							<a href="<?php echo base_url().'index.php/Profile'; ?>" class="editpro__btn">Edit Profile</a>
						<?php
						// }
						?>					
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<!-- <div class="copyright">
			Powered By Vivacom , All Rights Reserved
		</div> -->
	</div>
	<?php require('includes/footer.php'); ?>
</body>
</html>