<div class="page-content" style="height: 100%;">
	<div id="map" style="border:0;height: 100%;width: 100%;">
		
	</div>
	<?php $this->load->view("basic/home/schoolWindow"); ?>
</div><!--.page-content-->
<!-- JS  -->
<script src="<?php echo base_url('dist/build/js/lib/jQuery-tinyMap-master/jquery.tinyMap.js'); ?>"></script>
<script>

	//套件名稱:tinyMap
	//套件說明:https://code.essoduke.org/tinyMap/

	//設定GoogleMap取用API
	$.fn.tinyMapConfigure({
		"key": "",
		'libraries': 'places'
	});

	//渲染GoogleMap
	$('#map').tinyMap({
	    'center': '台北',
	    'zoom'  : 7
	});

</script>
<!-- JS  -->
