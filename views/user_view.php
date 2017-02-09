<!DOCTYPE html>
<html>
	<?php require('includes/head.php'); ?>
	<title>BTEEM</title>
	<script>
		$(document).ready(function(){			
			$("#rtable").dataTable({
				"aaSorting": []
			});
			<?php
			// if(in_array(10, $this->session->userdata('function')))
			// {
			?>
				$('#rtable_length').html('Employee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="useraddpopup()" >Add</a>');
			<?php
			// }
			// else
			// {
			?>
				// $('#rtable_length').html('Employee');
			<?php
			// }
			?>
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
						<div class="admninn__pagecontent">
							<div class="msg__box">
								<?php echo $success; ?>
								<?php echo validation_errors(); ?>
							</div>
							<?php						
							if(sizeof($user_array)>0)
							{
							?>
								<table id="rtable" class="display" cellspacing="0" width="auto">
									<thead>
										<tr>										
											<th>No</th>
											<th>Name</th>
											<th>Email</th>
											<th>Contact</th>
											<th>Status</th>
											<?php
											// if(in_array(11, $this->session->userdata('function')))
											// {
											?>
												<th class="last__column">Action</th>
											<?php
											// }
											?>
										</tr>
									</thead>	

									<tbody>
										<?php
										$i=1;
										foreach($user_array as $user)
										{									
										?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo ucwords($user['f_name'].' '.$user['l_name']); ?></td>
												<td><?php echo $user['email']; ?></td>
												<td><?php echo $user['primary_contact_no']; ?></td>
												<td><?php echo ($user['status']==0?'<span class="regected">Disabled</span>':'<span class="approved">Enabled</span>'); ?></td>
												<?php
												// if(in_array(11, $this->session->userdata('function')))
												// {
												?>
													<td class="last__column"><a href="javascript:void(0);" id="<?php echo $user['id']; ?>" onclick="usereditpopup(this.id)" class="link__vmore">Edit</a></td>
												<?php
												// }
												?>
											</tr>
										<?php
											$i++;
										}
										?>
									</tbody>
								</table>
							<?php
							}
							else
							{
								// if(in_array(10, $this->session->userdata('function')))
								// {
									echo 'Data Not Found <a href="javascript:void(0);" style="text-decoration:underline;margin-left:10px;" onclick="useraddpopup()" >Add Employee</a>';
								// }
							}
							?>
						</div>
					</div>
					<div class="copyright">
						Powered By ------- , All Rights Reserved
					</div>
				</div>
			<div class="clear"></div>
		</div>		
	<?php require('includes/footer.php'); ?>
</body>
</html>
