<div class="mobile-menu">

    @if(!Auth::guest())

      <?php $user = Auth::user(); ?>
      <?php $user_points = DB::table('points')->where('user_id', '=', $user->id)->sum('points'); ?>
      <a href="{{ URL::to('user') . '/' . $user->username; }}" class="usr-avatar"><img src="{{ Config::get('site.uploads_dir') }}avatars/{{ $user->avatar }}" alt="{{ $user->username }}" class="img-circle user-avatar-large"></a>
      <a href="{{ URL::to('user') . '/' . $user->username; }}" class="username"><h2>@if(strlen(Auth::user()->username) > 14){{ substr(Auth::user()->username, 0, 14) . '...' }}@else{{ Auth::user()->username }}@endif</h2></a>
      <p class="points"><i class="fa fa-star" style="color:gold"></i> {{ $user_points }} points</p>
      <div id="avatar-bg"></div>

    @endif

    <ul>
      <li class="@if(Request::is('/') || Request::is('category/*')) active @endif"><a href="{{ URL::to('/') }}"><i class="fa fa-home"></i> {{ Lang::get('lang.home') }}</a></li>
     <li class="dropdown @if(Request::is('popular/*') || Request::is('popular')) active @endif">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-star"></i> {{ Lang::get('lang.popular') }} <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="{{ URL::to('popular/week') }}">{{ Lang::get('lang.for_the_week') }}</a></li>
        <li><a href="{{ URL::to('popular/month') }}">{{ Lang::get('lang.for_the_month') }}</a></li>
        <li><a href="{{ URL::to('popular/year') }}">{{ Lang::get('lang.for_the_year') }}</a></li>
        <li><a href="{{ URL::to('popular') }}">{{ Lang::get('lang.all_time') }}</a></li>
      </ul>
    </li>
    
    <?php $categories = Category::orderBy('order', 'ASC')->get(); ?>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle categories" data-toggle="dropdown"><i class="fa fa-folder-open"></i> {{ Lang::get('lang.categories') }} <b class="caret"></b></a>
        
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

   <li><a href="{{ URL::to('/random') }}"><i class="fa fa-random"></i> {{ Lang::get('lang.random') }}</a></li>

</ul>  