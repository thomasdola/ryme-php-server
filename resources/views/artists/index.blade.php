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

    <section class="content">

        <div class="row margin-bottom">
            <info-box :data="data[0]"></info-box>
            <info-box :data="data[1]"></info-box>
            <info-box :data="data[2]"></info-box>
            <info-box :data="data[3]"></info-box>
        </div>

        <div class="row margin">
            <search :page="'artists'"></search>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <trending-artists :artists="artists"></trending-artists>
            </div>

            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Vouching Request(s)</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <vouching-requests :requests="requests"></vouching-requests>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/artists.js', false) }}"></script>
@endsection