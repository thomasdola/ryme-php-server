@extends('master-pages.master')

@section('content')

  <!-- Content Header (Page header) -->
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

<!-- Main content -->
<section class="content">
  <!-- Info boxes -->
  <div class="row">
      <info-box :data="users"></info-box>
      <info-box :data="tracks"></info-box>

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

      <info-box :data="artists"></info-box>
      <info-box :data="activeAds"></info-box>
  </div><!-- /.row -->

  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-8">
      <!-- TABLE: TRENDING TRACKS -->
      <trending-tracks :tracks="trendingTracks"></trending-tracks>
    </div><!-- /.col -->

    <div class="col-md-4">
      <div class="row">
        <trending-artists :artists="trendingArtists"></trending-artists>
      </div><!-- /.row -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard.js', false) }}"></script>
@endsection