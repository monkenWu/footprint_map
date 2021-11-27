<div class="col-xl-9 col-lg-8">
	<section class="tabs-section">
		<div class="tabs-section-nav tabs-section-nav-left">
			<ul class="nav" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" href="#tabs-2-tab-1" role="tab" data-toggle="tab">
						<span class="nav-link-in">留言</span>
					</a>
				</li>
				<?php
					if($member == 1){
				?>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-2-tab-2" role="tab" data-toggle="tab">
								<span class="nav-link-in">團體</span>
							</a>
						</li>
						<?php 
							/*<li class="nav-item">
								<a class="nav-link" href="#tabs-2-tab-3" role="tab" data-toggle="tab">
									<span class="nav-link-in">服務</span>
								</a>
							</li>*/
						?>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-2-tab-4" onclick="getSettingInfo()" role="tab" data-toggle="tab">
								<span class="nav-link-in">設定</span>
							</a>
						</li>
				<?php
					}
				?>
				
			</ul>
		</div><!--.tabs-section-nav-->

		<div class="tab-content no-styled profile-tabs">
			<!--.評論-->
			<?php  $this->load->view("basic/profile/function/comment");  ?>

			<!--.設定-->
			<?php 
				if($member == 1){
					$this->load->view("basic/profile/function/group");
					$this->load->view("basic/profile/function/group/addGroupMember");
					$this->load->view("basic/profile/function/group/addGroup");
					$this->load->view("basic/profile/function/group/editGroup");
					$this->load->view("basic/profile/function/service");
					$this->load->view("basic/profile/function/setting");
					$this->load->view("basic/profile/function/imgUpload");
				}
			?>
			
		</div><!--.tab-content-->
	</section><!--.tabs-section-->
</div>