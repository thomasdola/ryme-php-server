@extends("master-pages.master")

@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Optional description</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-black" style="background: url('{{ asset("img/photo1.png", false) }}') center center;">
                        <h3 class="widget-user-username">Shatta Wale</h3>
                        <h5 class="widget-user-desc">DanceHall</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ asset('img/user3-128x128.jpg', false) }}" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">TRACKS</span>
                                </div><!-- /.description-block -->
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">FOLLOWERS</span>
                                </div><!-- /.description-block -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div>
                </div><!-- /.widget-user -->
            </div>
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#trending_tracks" data-toggle="tab">Trending Tracks</a></li>
                        <li><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="trending_tracks">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Artist(s)</th>
                                        <th>Stream(s)</th>
                                        <th>Download(s)</th>
                                        <th>Favorite(s)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...</td>
                                        <td class="mailbox-attachment"></td>
                                    </tr>
                                    </tbody>
                                </table><!-- /.table -->
                            </div>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="settings">

                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/user-profile.js', false) }}"></script>
@endsection