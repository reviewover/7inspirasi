<?php $media_view = Cookie::get('media_view'); ?>

@if(isset($media_view) && ($media_view == 'grid_large' || $media_view == 'grid'))

	<?php if($media_view == 'grid'){ $column = 'col-sm-4'; } else { $column = 'col-sm-6'; } ?>

	@include('includes.media_grid')
@else
	@include('includes.media_list')
@endif