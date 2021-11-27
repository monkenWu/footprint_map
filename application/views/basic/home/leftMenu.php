<nav class="side-menu">
    <div class="side-menu-list">
    	<div class="container-fluid ">
    		<nav>
			  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active" id="nav-area-tab" data-toggle="tab" href="#nav-area" role="tab" aria-controls="nav-area" aria-selected="true">地區</a>
			    <a class="nav-item nav-link" id="nav-keywords-tab" data-toggle="tab" href="#nav-keywords" role="tab" aria-controls="nav-keywords" aria-selected="false">關鍵字</a>
			    <a class="nav-item nav-link" id="nav-attributes-tab" data-toggle="tab" href="#nav-attributes" role="tab" aria-controls="nav-attributes" aria-selected="false">屬性</a>
			  </div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active in" id="nav-area" role="tabpanel" aria-labelledby="nav-area-tab">
					<?php $this->load->view("basic/home/leftMenuContent/area"); ?>
				</div>
				<div class="tab-pane fade" id="nav-keywords" role="tabpanel" aria-labelledby="nav-keywords-tab">
					<?php $this->load->view("basic/home/leftMenuContent/keywords"); ?>
				</div>
				<div class="tab-pane fade" id="nav-attributes" role="tabpanel" aria-labelledby="nav-attributes-tab">
					<?php $this->load->view("basic/home/leftMenuContent/attributes"); ?>
				</div>
			</div>
    	</div>  	
    <div>
</nav>

<!-- JS  -->
<script>
	$(".nav-item").click(function() {
        $(".nav-item").removeClass('active');
        $(".nav-link").removeClass('active');
        $("#nav-messages").addClass('active'); 
        $(this).addClass('active');
         $(".tab-pane").removeClass('show active in');
         $("#tab-incoming").addClass('show active in');
         $($(this).attr("href")).addClass('show active in');
    });
	
</script>
<!-- JS  -->