<div class="dropdown user-menu">
    <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    	<!--小頭像-->
        	<img src="<?php echo base_url('dist/img/user/'.$photo) ?>" alt="">
         
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
        <a class="dropdown-item" href="<?php echo base_url('profile') ?>"><span class="font-icon glyphicon glyphicon-user"></span>個人資訊</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url() ?>" target="_blank"><span class="font-icon glyphicon glyphicon-home"></span>首頁</a>
        <!--<a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>幫助</a>-->
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url(); ?>home/logout"><span class="font-icon glyphicon glyphicon-log-out"></span>登出</a>
    </div>
</div>

<!-- JS  -->
<script>
	
</script>
<!-- JS  -->
