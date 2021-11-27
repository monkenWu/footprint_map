<?php  $this->load->view("basic/top");  ?>

<!--頁面CSS-->
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/lib/lobipanel/lobipanel.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/vendor/lobipanel.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/lib/jqueryui/jquery-ui.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/pages/widgets.min.css')?>">

<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/vendor/bootstrap-touchspin.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/vendor/select2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/js/lib/bootstrap-star-rating/css/star-rating.css'); ?>">
<style type="text/css" media="screen">
	body{
		font-family:Microsoft JhengHei;
	}
	.overlay {
		position: fixed;
		top: 90px; left: 0;
		height: 5%;
		width: 100%;
		z-index: 10;
		background-color: rgba(0,0,0,0);
	}
	.overlayDiv {
		height: 100%;
		padding-right: 15px;
		padding-left: 15px
	}
	.overlayDivText{
		height: 100%;
		background-color:#f6f8fa;
		color:#6c7a86;
		position: relative;
		padding: 8px 15px;
		font-size: 1rem;
		border-top: solid 1px #d8e2e7;
		border-bottom: solid 1px #d8e2e7;
	}
	.miniTop{
		margin-top: 90px;
		background-color:#f6f8fa;
		color:#6c7a86;
		border-top: solid 1px #d8e2e7;
		border-bottom: solid 1px #d8e2e7;

	}
	@media screen and (max-height: 1366px){
		.overlay{
			height: 3%;
	  	}
	}
	@media screen and (max-height: 1024px){
		.overlay{
			height: 4%;
	  	}
	}
	@media screen and (max-height: 765px){
		.overlay{
			height: 5%;
	  	}
	}
	@media screen and (max-height: 588px){
		.overlay{
			height: 7%;
	  	}
	}
	@media screen and (max-height: 414px){
		.overlay{
			height: 10%;
	  	}
	}

</style>
<!--頁面CSS-->

</head>
<body class="with-side-menu" style="height: 100%;">
	<?php  $this->load->view("basic/jsLoad");  ?>
	<script src="<?php echo base_url('dist/build/js/lib/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/select2/select2.full.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/bootstrap-star-rating/js/star-rating.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/jqueryui/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/lobipanel/lobipanel.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/match-height/jquery.matchHeight.min.js'); ?>"></script>
	<header class="site-header">
	    <div class="container-fluid">
			<!--上方按鈕
	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	        -->
	
	        <!--Logo-->
	        <a href="<?php echo base_url('home') ?>" class="site-logo">
	            <img src="<?php echo base_url('dist/img/system/logo.png') ?>" alt="" style="float: left;height: 30px;width:170px;position: relative;top: 5px;">
	              <!--mini loho <img class="hidden-lg-up" src="<?php echo base_url('dist/img/system/logo.png') ?>" alt="">-->
	        </a>
	        <!--Logo-->

	        <!--上方欄-->
	        <div class="site-header-content-noButton" style="    /* margin-left: -80px;">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">	
	                	<?php
	                		// $login = 0;
	                		if($login==1){
	                			//訊息按鈕
	                			//$this->load->view("basic/home/messages");
	                			//登入用戶按鈕
	                			$this->load->view("basic/home/user-menu");
	                		}else{
	                			//手機版按鈕
	                			$this->load->view("basic/home/no-user-menu");
	                		}
	                	?>
	                    <!-- 手機版按鈕 -->
	                </div><!--.site-header-shown-->

	                <div class="mobile-menu-right-overlay"></div>

	            </div><!--site-header-content-in-->
	        </div>
	        <!--上方欄-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>

	<?php  $this->load->view("basic/comparing/content");  ?>
	


</body>
</html>