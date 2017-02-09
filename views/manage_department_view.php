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
			// if(in_array(2, $this->session->userdata('function')))
			// {
			?>
				$('#rtable_length').html('Department&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="departmentaddpopup()" >Add</a>');
			<?php
			// }
			// else
			// {
			?>
				// $('#rtable_length').html('Department');
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
							if(sizeof($department_array)>0)
							{
							?>
								<table id="rtable" class="display" cellspacing="0" width="auto">
									<thead>
										<tr>										
											<th>No</th>
											<th>Category</th>
											<th>Department</th>
											<th>Department Code</th>
											<th>Status</th>
											<th>Created Date</th>
											<?php
											// if(in_array(3, $this->session->userdata('function')))
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
										foreach($department_array as $department)
										{	
											$DateTimeObj = new DateTime($department['created_date']);
											$createddate = $DateTimeObj->format('d-m-Y');									
										?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo ucwords($department['category']); ?></td>						
												<td><?php echo ucwords($department['department_name']); ?></td>
												<td><?php echo $department['department_code']; ?></td>
												<td><?php echo ($department['status']==0?'<span class="regected">Disabled</span>':'<span class="approved">Enabled</span>'); ?></td>
												<td><?php echo $createddate; ?></td>
												<?php
												// if(in_array(3, $this->session->userdata('function')))
												// {
												?>
													<td class="last__column"><a href="javascript:void(0);" id="<?php echo $department['id']; ?>" onclick="departmenteditpopup(this.id)" class="link__vmore">Edit</a></td>
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
								// if(in_array(2, $this->session->userdata('function')))
								// {
									echo 'Data Not Found <a href="javascript:void(0);" style="text-decoration:underline;margin-left:10px;" onclick="departmentaddpopup()" >Add Department</a>';
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
