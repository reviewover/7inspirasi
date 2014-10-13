<!DOCTYPE html>
<html>
<head>
    <?php $settings = Setting::first(); ?>
    @if(isset($media->title))
      <title>{{ stripslashes($media->title) }}</title>
    @else
      <title>{{ $settings->website_name }} - {{ $settings->website_description }}</title>
    @endif

    <meta name="viewport" content="initial-scale=1">
    
    <link rel="stylesheet" href="{{ URL::to('/') }}/application/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/application/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/application/assets/css/animate.min.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/application/assets/css/style.css" />
    @if($settings->color_scheme == 'dark' || (isset($_GET['color_scheme']) && $_GET['color_scheme'] == 'dark') )
      <link rel="stylesheet" href="{{ URL::to('/') }}/application/assets/css/style-dark.min.css" />
    @endif

    <link rel="icon" href="{{ Config::get('site.uploads_dir') . '/settings/' . $settings->favicon }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ Config::get('site.uploads_dir') . '/settings/' . $settings->favicon }}" type="image/x-icon">
    @yield('css')

    @include('includes.custom_css')

    <!--[if lte IE 8]>
      <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/jquery.infinitescroll.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/jquery.sticky.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/jquery.nearest.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/jquery.fitvid.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/jquery.timeago.js"></script>

    @if(isset($media->title) && isset($media->pic_url))
      <meta property="og:title" content="{{ $media->title }}"/>
      <meta property="og:url" content="{{ Request::url() }}"/>
      <meta property="og:image" content="{{ Config::get('site.uploads_dir') . '/images/' . $media->pic_url }}"/>
      <meta property="og:type" content="website" />

      @if(isset($media->description))
        <meta property="og:description" content="{{ $media->description }}"/>
      @endif

      <meta itemprop="name" content="{{ $media->title }}">
      <meta itemprop="description" content="{{ $media->description }}">
      <meta itemprop="image" content="{{ Config::get('site.uploads_dir') . '/images/' . $media->pic_url }}">
    @endif
    <?php call_user_func ( Config::get('site.header')); ?>
</head>
<body @if($settings->color_scheme == 'dark')class="dark"@endif>

<nav class="navbar navbar-fixed-top" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">{{ Lang::get('lang.toggle_navigation') }}</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand logo" href="{{ URL::to('/') }}"><img src="{{ Config::get('site.uploads_dir') . '/settings/' . $settings->logo }}" style="height:35px; width:auto;" /></a>
      
        <div class="mobile-menu-toggle"><i class="fa fa-bars"></i></div>

        @include('layouts.mobile-menu')


        <ul class="nav navbar-nav navbar-right">
        @if(Auth::guest())
        
        
            <li class="@if(Request::is('signin')) active @endif"><a href="{{ URL::to('signin') }}">{{ Lang::get('lang.sign_in') }}</a></li>
            
            @if($settings->user_registration)
              <li class="@if(Request::is('signup')) active @endif"><a href="{{ URL::to('signup') }}">{{ Lang::get('lang.sign_up') }}</a></li>
            @endif

        @else

        <?php $user_points = DB::table('points')->where('user_id', '=', Auth::user()->id)->sum('points'); ?>

          <li class="dropdown">
              <a href="#" class="user-menu dropdown-toggle" data-toggle="dropdown"><b class="caret"></b><div id="user-info"><h4><i class="fa fa-gear"></i> {{ Lang::get('lang.settings') }}</h4></div> </a>
              <ul class="dropdown-menu">
                @if(Auth::user()->admin)
                  <li><a href="{{ URL::to('admin') }}" class="admin_link_mobile"><i class="fa fa-coffee"></i> {{ Lang::get('lang.admin') }}</a></li>
                @endif
                <li><a href="{{ URL::to('user') . '/' . Auth::user()->username; }}"><i class="fa fa-user"></i> {{ Lang::get('lang.my_profile') }}</a></li>
                <li><a href="{{ URL::to('logout') }}" id="user_logout_mobile"><i class="fa fa-power-off"></i> {{ Lang::get('lang.logout') }}</a></li>
              </ul>
            </li>

        @endif
            @if($settings->user_registration || !Auth::guest())
              <li><a href="{{ URL::to('upload') }}" class="upload-btn"><i class="fa fa-cloud-upload"></i> {{ Lang::get('lang.upload') }}</a></li>
            @endif
          </ul>


        </div>
      </div>


      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
      
      <ul class="nav navbar-nav navbar-left nav-desktop">
        <!--li><a href="#" id="categories_open"><i class="fa fa-th-list"></i> Categories</a></li-->
        <li class="@if(Request::is('/') || Request::is('category/*')) active @endif"><a href="{{ URL::to('/') }}"><i class="fa fa-home"></i><span> {{ Lang::get('lang.home') }}</span></a><div class="nav-border-bottom"></div></li>
         <li class="dropdown @if(Request::is('popular/*') || Request::is('popular')) active @endif">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-star"></i><span> {{ Lang::get('lang.popular') }} </span><b class="caret"></b><div class="nav-border-bottom"></div></a>
          <ul class="dropdown-menu">
            <li><a href="{{ URL::to('popular/week') }}">{{ Lang::get('lang.for_the_week') }}</a></li>
            <li><a href="{{ URL::to('popular/month') }}">{{ Lang::get('lang.for_the_month') }}</a></li>
            <li><a href="{{ URL::to('popular/year') }}">{{ Lang::get('lang.for_the_year') }}</a></li>
            <li><a href="{{ URL::to('popular') }}">{{ Lang::get('lang.all_time') }}</a></li>
          </ul>
        </li>
        
        <?php $categories = Category::orderBy('order', 'ASC')->get(); ?>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle categories" data-toggle="dropdown"><i class="fa fa-folder-open"></i><span> {{ Lang::get('lang.categories') }} </span><b class="caret"></b><div class="nav-border-bottom"></div></a>
            
            <ul class="dropdown-menu">
                <li>
                    @foreach ($categories as $category)
                      <a href="{{ URL::to('category') . '/' . strtolower($category->name) }}">{{ $category->name }}</a>
                    @endforeach
                </li>
              </ul>
       </li>

       @if($settings->pages_in_menu)
       <li class="dropdown @if(Request::is('pages/*') || Request::is('pages')) active @endif">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file-text"></i> {{ $settings->pages_in_menu_text }} <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <?php $pages = Page::all(); ?>
            @foreach($pages as $page)
              <li><a href="{{ URL::to('pages') . '/' . $page->url }}">{{ $page->title }}</a></li>
            @endforeach
          
          </ul>
        </li>
        @endif

      </ul>  


      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ URL::to('/random') }}" class="random"><i class="fa fa-random"></i></a></li>
      @if($settings->user_registration || !Auth::guest())
        <li><a href="{{ URL::to('upload') }}" class="upload-btn upload-btn-desktop"><i class="fa fa-cloud-upload"></i> {{ Lang::get('lang.upload') }}</a></li>
      @endif

      @if(Auth::guest())
      
      
          <li class="@if(Request::is('signin')) active @endif"><a href="{{ URL::to('signin') }}" id="login-button-desktop">{{ Lang::get('lang.sign_in') }}</a><div class="nav-border-bottom"></div></li>
          @if($settings->user_registration)
            <li class="@if(Request::is('signup')) active @endif"><a href="{{ URL::to('signup') }}" id="signup-button-desktop">{{ Lang::get('lang.sign_up') }}</a><div class="nav-border-bottom"></div></li>
          @endif
      @else

      <?php $user_points = DB::table('points')->where('user_id', '=', Auth::user()->id)->sum('points'); ?>

        <li class="dropdown">
            <a href="#" class="user-menu user-menu-desktop dropdown-toggle" data-toggle="dropdown"><img src="{{ Config::get('site.uploads_dir') }}/avatars/{{ Auth::user()->avatar }}" class="img-circle" /><b class="caret"></b><div id="user-info"><h4>@if(strlen(Auth::user()->username) > 8){{ substr(Auth::user()->username, 0, 8) . '...' }}@else{{ Auth::user()->username }}@endif</h4><p>{{ $user_points }} {{ Lang::get('lang.points') }}</p></div> </a>
            <ul class="dropdown-menu">
              @if(Auth::user()->admin)
                <li><a href="{{ URL::to('admin') }}" class="admin_link_desktop"><i class="fa fa-coffee"></i> {{ Lang::get('lang.admin') }}</a></li>
              @endif
              <li><a href="{{ URL::to('user') . '/' . Auth::user()->username; }}" class="user-profile-link-desktop"><i class="fa fa-user"></i> {{ Lang::get('lang.my_profile') }}</a></li>
              <li><a href="{{ URL::to('logout') }}" id="user_logout_desktop"><i class="fa fa-power-off"></i> {{ Lang::get('lang.logout') }}</a></li>
            </ul>
          </li>

      @endif
    </ul>



  </div><!-- /.navbar-collapse -->
</div><!-- /.container -->
</nav>

@yield('outer-content')

<div id="main_container">

    @yield('content')

</div>

<div id="footer">
&copy; {{ date('Y') . ' ' . $settings->website_name }}
</div>

<script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/noty/jquery.noty.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/noty/themes/default.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/noty/layouts/top.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/application/assets/js/nprogress.js"></script>

<script type="text/javascript">
  $('document').ready(function(){

    NProgress.start();

    @if(Session::get('note') != '' && Session::get('note_type') != '')
        var n = noty({text: '{{ Session::get("note") }}', layout: 'top', type: '{{ Session::get("note_type") }}', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
        <?php Session::forget('note');
              Session::forget('note_type');
        ?>
    @endif

    var slide_pos = 1;

    $('#random-right').click(function(){
      if(slide_pos < 3){
        $('#random-slider').css('left', parseInt($('#random-slider').css('left')) - parseInt($('.random-container').width()) -28 + 'px') ;
        slide_pos += 1;
      }
    });

    $('#random-left').click(function(){
      if(slide_pos > 1){
        $('#random-slider').css('left', parseInt($('#random-slider').css('left')) + parseInt($('.random-container').width()) +28 + 'px') ;
        slide_pos -= 1;
      }
    });


  });


  $(window).load(function () {
    NProgress.done();
  });

  $(window).resize(function(){
    jquery_sticky_footer();
  });


  $(window).bind("load", function() {    
    jquery_sticky_footer();
  });

  function jquery_sticky_footer(){
    var footer = $("#footer");
    var pos = footer.position();
    var height = $(window).height();
    height = height - pos.top;
    height = height - footer.outerHeight();
    if (height > 0) {
      footer.css({'margin-top' : height+'px'});
    }
  }

  /********** Mobile Functionality **********/

  var mobileSafari = '';

  $(document).ready(function(){
    $('.mobile-menu-toggle').click(function(){
      $('.mobile-menu').toggle();
      $('body').toggleClass('mobile-margin').toggleClass('body-relative');
      $('.navbar').toggleClass('mobile-margin');
    });


    // Assign a variable for the application being used
    var nVer = navigator.appVersion;
    // Assign a variable for the device being used
    var nAgt = navigator.userAgent;
    var nameOffset,verOffset,ix;
   
   
    // First check to see if the platform is an iPhone or iPod
    if(navigator.platform == 'iPhone' || navigator.platform == 'iPod'){
      // In Safari, the true version is after "Safari" 
      if ((verOffset=nAgt.indexOf('Safari'))!=-1) {
        // Set a variable to use later
        mobileSafari = 'Safari';
      }
    }
   
    // If is mobile Safari set window height +60
    if (mobileSafari == 'Safari') { 
      // Height + 60px
      $('.mobile-menu').css('height', (parseInt($(window).height())+ 60) + 'px' );
    } else {
      // Else use the default window height
      $('.mobile-menu').css('height', $(window).height()); 
    };

  });

  $(window).resize(function(){
    // If is mobile Safari set window height +60
    if (mobileSafari == 'Safari') { 
      // Height + 60px
      $('.mobile-menu').css('height', (parseInt($(window).height())+ 60) + 'px' );
    } else {
      // Else use the default window height
      $('.mobile-menu').css('height', $(window).height()); 
    };
  });

  /********** End Mobile Functionality **********/


</script>

@yield('javascript')


@if(isset($settings->analytics))
  {{ $settings->analytics }}
@endif


<?php //call_user_func ( Config::get('site.footer')); ?>

</body>
</html>