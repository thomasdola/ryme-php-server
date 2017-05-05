<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <!-- User Account Menu -->
    @if(Auth::check())
          <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                      <p>
                          {{ Auth::user()->email }}
                          <small>{{ Auth::user()->role->title }}</small>
                      </p>
                  </li>
                  <!-- Menu Body -->
                  {{--<li class="user-body">--}}
                  {{--<div class="col-xs-4 text-center">--}}
                  {{--<a href="#">Followers</a>--}}
                  {{--</div>--}}
                  {{--<div class="col-xs-4 text-center">--}}
                  {{--<a href="#">Sales</a>--}}
                  {{--</div>--}}
                  {{--<div class="col-xs-4 text-center">--}}
                  {{--<a href="#">Friends</a>--}}
                  {{--</div>--}}
                  {{--</li>--}}
                  <!-- Menu Footer-->
                  <li class="user-footer">
                      <div class="pull-left">
                          <a href="#" data-toggle="control-sidebar"
                             class="btn btn-default btn-flat">Settings</a>
                      </div>
                      <div class="pull-right">
                          <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                      </div>
                  </li>
              </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
    @endif
  </ul>
</div>