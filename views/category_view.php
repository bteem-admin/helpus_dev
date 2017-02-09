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
			// if(in_array(23, $this->session->userdata('function')))
			// {
			?>
				$('#rtable_length').html('Category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="categoryaddpopup()" >Add</a>');
			<?php
			// }
			// else
			// {
			?>
				//$('#rtable_length').html('Role');
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
							if(sizeof($role_array)>0)
							{
							?>
								<table id="rtable" class="display" cellspacing="0" width="auto">
									<thead>
										<tr>										
											<th>No</th>
											<th>Type</th>
											<th>Category</th>
											<?php
											// if(in_array(24, $this->session->userdata('function')))
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
										foreach($role_array as $role)
										{								
										?>
											<tr>
												<td><?php echo $i; ?></td>		
												<td><?php echo ucwords($role['main_category']); ?></td>
												<td><?php echo ucwords($role['category']); ?></td>							
												<?php
												// if(in_array(24, $this->session->userdata('function')))
												// {
												?>
													<td class="last__column">
														<a href="javascript:void(0);" id="<?php echo $role['id']; ?>" onclick="categoryeditpopup(this.id)" class="link__vmore">Edit</a>
													</td>
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
								// if(in_array(6, $this->session->userdata('function')))
								// {
									echo 'Data Not Found <a href="javascript:void(0);" style="text-decoration:underline;margin-left:10px;" onclick="categoryaddpopup()" >Add Category</a>';
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
