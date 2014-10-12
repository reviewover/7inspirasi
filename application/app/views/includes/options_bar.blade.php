<div class="options_sidebar">
<?php $media_view = Cookie::get('media_view'); ?>

<h2>Viewing Options:</h2>

<div class="viewing_options">
  <i class="fa fa-th-list @if(!isset($media_view) || $media_view == 'list') active @endif" data-url="{{ URL::to('view/list'); }}"></i>
  <i class="fa fa-th-large @if(isset($media_view) && $media_view == 'grid_large') active @endif" data-url="{{ URL::to('view/grid_large'); }}"></i>
  <i class="fa fa-th @if(isset($media_view) && $media_view == 'grid') active @endif" data-url="{{ URL::to('view/grid'); }}"></i>
</div>
<div style="clear:both"></div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('.viewing_options i').click(function(){
      window.location = $(this).data('url');
    }); 
  });
</script>