<div class="row version">
	<div id="version_block" class="col-md-12">
		<h4>Ninja Media Script</h4>
		<h5>Version 1.1.8</h5>

<?php 
		$json = file_get_contents('https://s3.amazonaws.com/ninja-media-script/info.json');
		$obj = json_decode($json);
		$version = 'Could not retrieve info';
		if(isset($obj->version)){
			$version = $obj->version;
		}
?>
		<small>current version (<span class="current_version">{{ $version }}</span>)
	</div>
</div>

