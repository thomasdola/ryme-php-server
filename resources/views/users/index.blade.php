@extends('master-pages.master')

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
        <div class="row margin-bottom">
            <info-box :data="data[0]"></info-box>
            <info-box :data="data[1]"></info-box>
            <info-box :data="data[2]"></info-box>
            <info-box :data="data[3]"></info-box>
        </div>

        <div class="row margin">
            <search :page="'users'"></search>
        </div>

        <users-table :users="users"></users-table>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/users.js', false) }}"></script>
@endsection