<?php  $this->load->view("basic/top");  ?>

<!--頁面CSS-->
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/lib/lobipanel/lobipanel.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/vendor/lobipanel.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/lib/jqueryui/jquery-ui.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/pages/widgets.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/pages/profile-2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/vendor/bootstrap-touchspin.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/separate/vendor/select2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/js/lib/bootstrap-star-rating/css/star-rating.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('dist/build/css/croppie.css'); ?>">
<style type="text/css" media="screen">
	body{
		font-family:Microsoft JhengHei;
	}

	.upload-msg {
	    text-align: center;
	    padding: 90px;
	    font-size: 22px;
	    color: #aaa;
	    width: 300px;
	    margin: 20px auto;
	    border: 1px solid #aaa;
	}

	#upload {
		position: absolute;
		top: 0;left: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
	}

	.site-header-content-noButton {
	    float: right;
	    height: 40px;
	    padding: 5px 0;
	    width: 100%;
	    margin-left: -210px;
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
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/croppie.min.js'); ?>"></script>
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

	<div class="page-content" style="padding: 105px 0px 0px 0px;">
		<div class="profile-header-photo"  style="background-image: url(<?php echo base_url('dist/img/user/7857c405c747c6c.jpg') ?>);">
		
		</div>
	</div><!--上方視覺-->


	<div class="container-fluid">
		<div class="row">
			<?php  $this->load->view("basic/profile/member");  ?>
			<?php  $this->load->view("basic/profile/function");  ?>
		</div><!--.row-->
	</div><!--.container-fluid-->

	<?php  //$this->load->view("basic/comparing/content");  ?>
	


</body>

</html>