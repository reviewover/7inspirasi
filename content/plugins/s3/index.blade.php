@extends('layouts.master')
	@section('content')

		<?php $s3url = $s3bucket = $s3key = $s3secret = ''; ?>
		@foreach($plugin_data as $data)
		
			<?php switch($data->key){
						case 's3url':
							$s3url = $data->value;
							break;
						case 's3key':
							$s3key = $data->value;
							break;
						case 's3bucket':
							$s3bucket = $data->value;
							break;
						case 's3secret':
							$s3secret = $data->value;
							break;
						default:
							break;
					}
			?>
		@endforeach

		<div class="main_home_container container">
			<div class="white_container row" style="margin-top:20px;">
				<img src="/content/plugins/s3/logo.png" height="75" style="float:left; margin-right:15px; margin-bottom:15px;" />
				<h1>Amazon s3 Plugin</h1>
				<div style="clear:both"></div>
				<form method="POST" action="">
					
					<label for="s3url">S3 URL: example (http://s3.amazonaws.com/bucket-name/uploads)</label>
					<input type="text" class="form-control" name="s3url" id="s3url" value="{{ $s3url }}" />

					<label for="s3bucket">S3 Bucket: example (bucket-name/uploads)</label>
					<input type="text" class="form-control" name="s3bucket" id="s3bucket" value="{{ $s3bucket }}" />
					
					<label for="s3key">S3 Key:</label>
					<input type="text" class="form-control" name="s3key" id="s3key" value="{{ $s3key }}" />
					
					<label for="s3url">S3 Secret Key:</label>
					<input type="text" class="form-control" name="s3secret" id="s3secret" value="{{ $s3secret }}" />

					<input type="submit" class="btn btn-color" style="float:right; margin-top:20px;" value="submit" />
				</form>
			</div>
		</div>
	@endsection
@stop