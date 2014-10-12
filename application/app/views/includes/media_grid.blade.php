<div id="media" style="padding-bottom:70px;">

<style>
	.item .container{
		padding:0px;
		margin:0px 5px;
	}

	.item img{
		-webkit-border-top-left-radius: 3px;
		-webkit-border-top-right-radius: 3px;
		-moz-border-radius-topleft: 3px;
		-moz-border-radius-topright: 3px;
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
	}
	#media{
		margin-top:15px;
	}

	p.home-like-count, p.home-comment-count, p.home-view-count{
		float:none;
		display:inline-block;
		margin-top:0px;
		margin-bottom:0px;
		line-height:32px;
	}

	.home-media-like{
		position: absolute;
		right: 0px;
		top: 0px;
		font-size: 18px;
		width: 40px;
		height: 32px;
		border: 0px solid #eee;
		line-height: 25px;
		background: #ddd;
		color: #fff;
		z-index: 999;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
		-webkit-border-bottom-right-radius: 3px;
		-moz-border-radius-bottomright: 3px;
		border-bottom-right-radius: 3px;
	}

	.grid_details{
		position:relative;
	}

	.grid_item_title{
		background:#fff;
		text-align:center;
		padding-top:20px;
	}

	.grid_item_title a{
		margin:0px;
		padding:5px;
		text-align:center;
		display:block;
		color:#333;
	}

	.grid_item_title a:hover{
		text-decoration:none;
	}


	.grid_item_details{
		position:relative;
		background:#eee;
		-webkit-border-bottom-left-radius: 3px;
		-webkit-border-bottom-right-radius: 3px;
		-moz-border-radius-bottomleft: 3px;
		-moz-border-radius-bottomright: 3px;
		border-bottom-left-radius: 3px;
		border-bottom-right-radius: 3px;
		line-height:20px;
		text-align:center;
	}

	.single-left img.user-avatar-medium{
		width: 40px;
		height: 40px;
		position: absolute;
		left: 50%;
		margin-left:-20px;
		border:2px solid #fff;
		top: -20px;
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
		border-radius: 20px;
	}
	/*#media .grid-sizer { width: 33.33333333333333%; }*/

</style>

<script>


	$(document).ready(function(){

		var $container = $('#media');
		// layout Masonry again after all images have loaded
		$container.imagesLoaded( function() {

		  $container.masonry({
			  "columnWidth": "." + "{{ $column }}",
			  itemSelector: '.item',
			  gutter: 0,
			});
		  $('.item').css('opacity', '1.0');
		});
		
	});

</script>


<?php $count = 1; ?>
@foreach($media as $item)


		<div class="item animated single-left {{ $column }}" data-href="{{ URL::to('media') . '/' . $item->id }}" data-id="{{ $item->id }}">

		<div class="container">
		  	<div class="single-title" style="display:none">
		  		@if($item->user())
		  			<?php $user_url = URL::to('user') . '/' . $item->user()->username;
		  				  $username = $item->user()->username;
		  				  $user_avatar = Config::get('site.uploads_dir') . 'avatars/' . $item->user()->avatar;
		  			?>
		  		@else
		  			<?php $user_url = '#_';
		  				  $username = Lang::get('lang.anonymous');
		  				  $user_avatar = Config::get('site.uploads_dir') . 'avatars/default.jpg';
		  			?>
		  		@endif

					<a href="{{ $user_url }}"><img src="{{ $user_avatar }}" class="img-circle user-avatar-medium" /></a><h2 class="item-title"><a href="{{ URL::to('media') . '/' . $item->slug; }}" target="_blank" alt="{{ $item->title }}">{{{ stripslashes($item->title) }}}</a></h2>
					<div class="item-details">
						<p class="details">{{ Lang::get('lang.submitted_by') }}: <a href="{{ $user_url }}">{{ $username}}</a> {{ Lang::get('lang.submitted_on') }} {{ date("F j, Y", strtotime($item->created_at)) }}</p>
						<p class="home-like-count"><i class="fa {{ $settings->like_icon }}"></i> <span>{{ $item->totalLikes() }}</span></p>
						<p class="home-comment-count"><i class="fa fa-comments"></i> {{ $item->totalComments() }}</p>
						<p class="home-view-count"><i class="fa fa-eye"></i> @if(isset($view_increment) && $view_increment == true ){{ $item->views + 1 }}@else{{ $item->views }}@endif </p>
					</div>
					@if(!Auth::guest())
						<?php $liked = MediaLike::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $item->id)->first(); ?> 
					@endif
					<div class="home-media-like @if(isset($liked->id)) active @endif" data-authenticated="@if(Auth::guest()){{ 'false' }}@else{{ 'true' }}@endif" data-id="{{ $item->id }}"><i class="fa {{ $settings->like_icon }}"></i></div>
				
			</div>

			<div class="clear"></div>

			
				@if($item->vid != 1)
					@if(strpos($item->pic_url, '.gif') > 0)
						<div class="animated-gif">
							<img class="single-media animation" alt="..." src="{{ Config::get('site.uploads_dir') . '/images/' . $item->pic_url }}" data-animation="{{ Config::get('site.uploads_dir') . '/images/' . str_replace('.gif', '-animation.gif', $item->pic_url) }}" data-original="{{ Config::get('site.uploads_dir') . '/images/' . $item->pic_url }}" data-state="0" />
							<img style="display:none" src="{{ Config::get('site.uploads_dir') . '/images/' . str_replace('.gif', '-animation.gif', $item->pic_url) }}" />
							<p class="gif-play"><i class="fa fa-play-circle-o"></i></p>
						</div>
					@else
						<a href="{{ URL::to('media') . '/' . $item->slug; }}" target="_blank" alt="{{ $item->title }}"><img class="single-media" alt="..." src="{{ Config::get('site.uploads_dir') . '/images/' . $item->pic_url }}" /></a>
					@endif
				@else
					
					<div class="video_container">

						<!-- YOUTUBE VIDEO -->
						@if (strpos($item->vid_url, 'youtube') > 0 || strpos($item->vid_url, 'youtu.be') > 0)
					        
							<iframe title="YouTube video player" class="youtube-player" type="text/html" width="640"
			height="360" src="http://www.youtube.com/embed/{{ Youtubehelper::extractUTubeVidId($item->vid_url); }}?theme=light&rel=0" frameborder="0"
			allowFullScreen></iframe>

					   

					    <!-- VIMEO VIDEO -->
					    @elseif (strpos($item->vid_url, 'vimeo') > 0)
					        <?php $vimeo_id = (int)substr(parse_url($item->vid_url, PHP_URL_PATH), 1); ?>
					        <iframe src="//player.vimeo.com/video/{{ $vimeo_id; }}" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					    
					    <!-- VINE Video -->
					    @elseif (strpos($item->vid_url, 'vine') > 0)
					    	<?php $include_embed = (strpos($item->vid_url, '/embed') > 0) ? '' : '/embed'; ?>
					    	<img class="single-media vine-thumbnail" style="cursor:pointer;" alt="..." src="{{ Config::get('site.uploads_dir') . '/images/' . $item->pic_url }}" data-embed="{{ $item->vid_url . $include_embed }}/simple?audio=1" />
					    	<p class="vine-thumbnail-play" data-embed="{{ $item->vid_url . $include_embed }}/simple?audio=1" style="color:#fff; color:rgba(255, 255, 255, 0.6); font-size:50px; position:absolute; z-index:999; width:50px; height:50px; top:50%; left:50%; margin:0px; padding:0px; margin-left:-30px; margin-top:-30px; cursor:pointer;"><i class="fa fa-play-circle-o"></i></p>
					    	
					    @endif

						


					</div>
				@endif

			<div class="grid_details">
				<a href="{{ $user_url }}"><img src="{{ $user_avatar }}" class="img-circle user-avatar-medium" /></a>
				<div class="grid_item_title"><a href="{{ URL::to('media') . '/' . $item->slug; }}" target="_blank">{{ $item->title }}</a></div>
				<div class="grid_item_details">
					
					<p class="home-like-count"><i class="fa {{ $settings->like_icon }}"></i> <span>{{ $item->totalLikes() }}</span></p>
					<p class="home-comment-count"><i class="fa fa-comments"></i> {{ $item->totalComments() }}</p>
					<p class="home-view-count"><i class="fa fa-eye"></i> @if(isset($view_increment) && $view_increment == true ){{ $item->views + 1 }}@else{{ $item->views }}@endif </p>
					
					@if(!Auth::guest())
						<?php $liked = MediaLike::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $item->id)->first(); ?> 
					@endif
					<div class="home-media-like @if(isset($liked->id)) active @endif" data-authenticated="@if(Auth::guest()){{ 'false' }}@else{{ 'true' }}@endif" data-id="{{ $item->id }}"><i class="fa {{ $settings->like_icon }}"></i></div>
					

					<div class="clear"></div>
				</div>
			</div>
			@if($settings->media_description && isset($item->description) && !empty($item->description))
				<p class="media_description"><i class="fa fa-quote-left"></i> {{ $item->description }}</p>
			@endif



		</div><!-- item-large -->

		</div>
	@endforeach

	<div style="clear:both"></div>
	@include('includes.pagination')

</div><!-- #media -->