	<script src="<?php echo base_url('dist/build/js/lib/jquery/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/tether/tether.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/bootstrap/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/plugins.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/salvattore/salvattore.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/lib/sweetalert/sweetalert.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('dist/build/js/lib/match-height/jquery.matchHeight.min.js'); ?>"></script>
	<script src="<?php echo base_url('dist/build/js/app.js'); ?>"></script>
	<script>
		$.prototype.tooltip = (function (tooltip) {
		  return function (config) {
		    try {
		      return tooltip.call(this, config);
		    } catch (ex) {
		      if (ex instanceof TypeError && config === "destroy") {
		        return tooltip.call(this, "dispose");
		      }
		    }
		  };
		})($.prototype.tooltip);
	<?php if(isset($loginTest)){ ?>

		swal({
		  title: '錯誤',
	      text: '<?php echo $loginTest; ?>',
	      type: 'error',
	      showCancelButton: false,
	      confirmButtonColor: '#3085d6',
	      confirmButtonText: '確定',
	    }).catch(swal.noop).then(function () {
	      document.location.href='<?php echo base_url('home/logout'); ?>';
	    },function(dismiss){
	      if(dismiss==='esc'){
	        document.location.href='<?php echo base_url('home/logout'); ?>';
	      }else if(dismiss==='overlay'){
	        document.location.href='<?php echo base_url('home/logout'); ?>';
	      }
	    });

    <?php } ?>

    <?php if($login==1){?>

    	setInterval("checkLogin()", 180000);

    	function checkLogin(){
    		$.ajax({
    			url: '<?php echo base_url('login/tokenCheck') ?>',
    			dataType: 'text',
    		})
    		.done(function(e) {
    			if(e == 0){
    				swal({
					  title: '錯誤',
				      text: '你的帳號已在他處登入。',
				      type: 'error',
				      showCancelButton: false,
				      confirmButtonColor: '#3085d6',
				      confirmButtonText: '確定',
				    }).catch(swal.noop).then(function () {
				      document.location.href='<?php echo base_url('home/logout'); ?>';
				    },function(dismiss){
				      if(dismiss==='esc'){
				        document.location.href='<?php echo base_url('home/logout'); ?>';
				      }else if(dismiss==='overlay'){
				        document.location.href='<?php echo base_url('home/logout'); ?>';
				      }
				    });
    			}
    			//console.log(e);
    		});
    		
    	}
    <?php } ?>
    </script>