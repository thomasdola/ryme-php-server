<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-envelope"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-lock"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane active" id="control-sidebar-home-tab">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Change Email</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'put', 'route' => ['staff.update', Auth::user()->uuid]]) !!}
                <input type="hidden" value="email" name="type">
                <div class="box-body">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input name="email" type="email" value="{{ Auth::user()->email }}"
                               class="form-control" id="email" placeholder="Enter email">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-default btn-block">update</button>
                </div>
            {!! Form::close() !!}
        </div>

    </div>
    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'put', 'route' => ['staff.update', Auth::user()->uuid]]) !!}
                <div class="box-body">
                    <input type="hidden" value="password" name="type">
                    <div class="form-group">
                        <label for="oldPassword">Old Password</label>
                        <input name="old_password" type="password" class="form-control" id="oldPassword"
                               placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input name="new_password" type="password" class="form-control" id="newPassword"
                               placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="passwordConfirm">Confirm Password</label>
                        <input name="new_password_confirmation" type="password" class="form-control" id="passwordConfirm"
                               placeholder="Enter password">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-default btn-block">update</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div><!-- /.tab-pane -->
  </div>
</aside>