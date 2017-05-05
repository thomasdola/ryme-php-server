<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    {{--<div class="user-panel">--}}
      {{--<div class="pull-left image">--}}
        {{--<img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}
      {{--</div>--}}
      {{--<div class="pull-left info">--}}
        {{--<p>Alexander Pierce</p>--}}
        {{--<!-- Status -->--}}
        {{--<a href="#"> Profile</a>--}}
      {{--</div>--}}
    {{--</div>--}}

    <!-- search form (Optional) -->
    {{-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form> --}}
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="{{ Request::is('admin/dashboard') ? "active" : '' }}">
          <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>
      <li class="{{ Request::is('admin/artists') || Request::is('admin/artists/*') ? "active" : '' }}">
          <a href="{!! route('artists') !!}"><i class="fa fa-male"></i> <span>Artists</span></a>
      </li>
      <li class="{{ Request::is('admin/categories') ? "active" : '' }}">
          <a href="{{ route('admin.categories.index') }}"><i class="fa fa-list"></i> <span>Categories</span></a>
      </li>
      <li class="{{ Request::is('admin/users') ? "active" : '' }}">
          <a href="{{ route('admin.users.index') }}"><i class="fa fa-group"></i> <span>Users</span></a>
      </li>
      <li class="{{ Request::is('admin/ads') ? "active" : '' }}">
          <a href="{{ route('admin.ads.index') }}"><i class="fa fa-money"></i> <span>Ads</span></a>
      </li>
      <li class="{{ Request::is('admin/settings') ? "active" : '' }}">
          <a href="{{ route('settings') }}"><i class="fa fa-briefcase"></i> <span>Admin</span></a>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>