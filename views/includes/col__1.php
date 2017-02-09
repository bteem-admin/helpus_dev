			<div class="col__1">
				<?php
				if($this->session->userdata('admin_flag')==1)
				{
				?>
					<div class="menu">
						<a href="javascript:void(0);" id="general_settings" class="general dblinner__1 dblink__wrp">
							<i></i>
							<span>General Settings</span>
							<em></em>
							<div class="clear"></div>
						</a>

						<div class="general__mlinks" id="general__mlinks" style="display:none;">		
							<a href="<?php echo base_url().'index.php/Category' ?>" class="dblinner__2 dblink__wrp dblinner__3">
								<span>Category</span>
								<div class="clear"></div>
							</a>
							<a href="<?php echo base_url().'index.php/Role' ?>" class="dblinner__2 dblink__wrp dblinner__3">
								<span>Role</span>
								<div class="clear"></div>
							</a>

							<a href="<?php echo base_url().'index.php/Department' ?>" class="dblinner__2 dblink__wrp dblinner__3">
								<span>Department</span>
								<div class="clear"></div>
							</a>
							
							<a href="<?php echo base_url().'index.php/Function_role_mapping' ?>" class="dblinner__2 dblink__wrp dblinner__3">
								<span>Function Role Mapping</span>
								<div class="clear"></div>
							</a>											
						</div>
						
						
						<a href="javascript:void(0);" id="user_management" class="user dblinner__1 dblink__wrp">
							<i></i>
							<span>User Management</span>
							<em></em>
							<div class="clear"></div>
						</a>
						<div class="" id="internal_user_mlinks" style="display:none;">
							<a href="<?php echo base_url().'index.php/User' ?>"  class="general dblinner__2 dblink__wrp">
								<span>Internal User</span>
								<div class="clear"></div>
							</a>
						</div>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="menu">
						<a href="javascript:void(0);" id="general_settings" class="general dblinner__1 dblink__wrp">
							<i></i>
							<span>Manage Ticketing</span>
							<em></em>
							<div class="clear"></div>
						</a>
						<a href="javascript:void(0);" id="user_management" class="user dblinner__1 dblink__wrp">
							<i></i>
							<span>Categories</span>
							<em></em>
							<div class="clear"></div>
						</a>
						<div class="" id="internal_user_mlinks" style="display:none;">
							<?php
							if(sizeof($user_categories)>0)
							{
								foreach($user_categories as $category)
								{
							?>
									<a href="javascript:void(0);"  class="general dblinner__2 dblink__wrp">
										<span><?php echo $category['category']; ?></span>
										<div class="clear"></div>
									</a>
							<?php
								}
							}
							?>
						</div>
					</div>
				<?php
				}
				?>
			</div>