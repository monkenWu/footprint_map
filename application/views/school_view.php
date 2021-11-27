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
<link rel="stylesheet" href="<?php echo base_url('dist/build/js/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>">
<style type="text/css" media="screen">
	body{
		font-family:Microsoft JhengHei;
	}
	.table td {
	   text-align: center;   
	}
	.table th {
	   text-align: center;   
	}
	.card {
		margin-bottom: 0em;
	}
	.card-btn-open:hover {
	    color: #212529;
	    background-color: #e2e6ea;
	    border-color: #dae0e5;
	}
	.card-btn-open {
	    color: #212529;
	    background-color: #f8f9fa;
	    border-color: #f8f9fa;
	}
	.card-btn-top {
	    display: inline-block;
	    font-weight: 400;
	    text-align: left ;
	    
	    border: 1px solid transparent;
	    padding: 0.375rem 0.75rem;
	    font-size: 1rem;
	    line-height: 1.5;
	    border-radius: 0.25rem;
	    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	    border-bottom: 1px solid rgba(0, 0, 0, 0.125)
	}
	.card-btn {
	    display: inline-block;
	    height: 50px;
	    font-weight: 400;
	   
	    border: 1px solid transparent;
	    padding: 0.375rem 0.75rem;
	    font-size: 1rem;
	    line-height: 1.5;
	    border-radius: 0.25rem;
	    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
	    border-top: 1px solid rgba(0, 0, 0, 0.125);
	}
	.row{
		font-family:Microsoft JhengHei;
	}
	.footPrint-card{
	  position: relative;
	  display: flex;
	  flex-direction: column;
	  min-width: 0;
	  word-wrap: break-word;
	  background-color: $card-bg;
	  background-clip: border-box;
	  border: $card-border-width solid $card-border-color;
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
	<script src="<?php echo base_url('dist/build/js/lib/tw-city-selector-master/tw-city-selector.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/bootstrap-star-rating/js/star-rating.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/jqueryui/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/lobipanel/lobipanel.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/match-height/jquery.matchHeight.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/moment/moment.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/moment/locale/zh-tw.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/Chart.bundle.min.js'); ?>"></script>
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

	<?php  $this->load->view("basic/school/content");  ?>
	


</body>
</html>