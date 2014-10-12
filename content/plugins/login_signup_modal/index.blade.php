@extends('layouts.master')
	@section('content')

		<?php $login_signup_modal_custom_css = ''; ?>
		@foreach($plugin_data as $data)
		
			@if($data->key == 'css')
				<?php $login_signup_modal_custom_css = $data->value; ?>
			@endif

		@endforeach

		<div class="main_home_container container">
			<div class="white_container row" style="margin-top:20px;">
				<img src="/content/plugins/login_signup_modal/logo.png" height="75" style="float:left; margin-right:15px; margin-bottom:15px;" />
				<h1>Login/Signup Modal Lightbox</h1>
				<div style="clear:both"></div>
				<p>When you activate this plugin your login and signup will be displayed in a modal window instead of redirecting the user to a separate page</p>
				
				<form method="POST" id="form" action="">
					<label for="css">Add Your Own Custom CSS for the Modal Window</label>
					<pre id="editor" class="ace-editor" style="min-height:500px; font-size:22px;">{{ $login_signup_modal_custom_css }}</pre>
					<input type="hidden" id="css" name="css" value="" />
					<div class="btn btn-color submit-code" style="float:left; margin-top:20px;">Add Custom CSS</div>
					<div style="clear:both"></div>
				</form>
			</div>
		</div>

		<script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/ace/ace.js" data-ace-base="src" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/ace/mode-css.js"></script>

		<script>
		    var editor = ace.edit("editor");
		    editor.setTheme("ace/theme/github");
		    editor.getSession().setMode("ace/mode/css");

		    $(document).ready(function(){
		    	$('.submit-code').click(function(){
		    		var new_css = editor.getSession().getValue();
		    		$('#css').val(new_css);
		    		$('#form').submit();
		    	});
		    });

		</script>

	@endsection
@stop