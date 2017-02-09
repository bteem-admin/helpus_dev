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
			// if(in_array(8, $this->session->userdata('function')))
			// {
			?>
				$('#rtable_length').html('Function Role Mapping&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="mappingaddpopup()" >Add</a>');
			<?php
			// }
			// else
			// {
			?>
				//$('#rtable_length').html('Function Role Mapping');
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
					$this->load->view('includes/col__1');?>
					
				</div>
					<div class="col__2">
						<div class="admninn__pagecontent">
							<div class="msg__box">
								<?php echo $success; ?>
								<?php echo validation_errors(); ?>
							</div>
							<?php						
							if(sizeof($function_role_mapped_array)>0)
							{
							?>
								<table id="rtable" class="display" cellspacing="0" width="auto">
									<thead>
										<tr>										
											<th>No</th>
											<th>Category</th>
											<th>Role</th>
											<th>Deparment</th>
											<th>Status</th>
											<?php
											// if(in_array(9, $this->session->userdata('function')))
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
										foreach($function_role_mapped_array as $mapped)
										{								
										?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo ucwords($mapped['category']); ?></td>
												<td><?php echo ucwords($mapped['role']); ?></td>
												<td><?php echo ucwords($mapped['department_name']); ?></td>
												<td><?php echo ($mapped['status']==0?'<span class="regected">Disabled</span>':'<span class="approved">Enabled</span>'); ?></td>
												<?php
												// if(in_array(9, $this->session->userdata('function')))
												// {
												?>
													<td class="last__column"><a href="javascript:void(0);" id="<?php echo $mapped['id']; ?>_<?php echo $mapped['category_id']; ?>_<?php echo $mapped['role_id']; ?>_<?php echo $mapped['department_id']; ?>" onclick="mappingeditpopup(this.id)" class="link__vmore">Edit</a></td>
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
								// if(in_array(8, $this->session->userdata('function')))
								// {
									echo 'Data Not Found <a href="javascript:void(0);" style="text-decoration:underline;margin-left:10px;" onclick="mappingaddpopup()" >Function Role Mapping</a>';
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
