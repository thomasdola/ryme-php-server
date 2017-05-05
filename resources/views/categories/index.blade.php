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
    <div class="row">
        <div class="col-md-3">

            <div class="box collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">New Category</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" @submit.prevent="saveCategory">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input v-model="newCategory.name"
                                       type="text"
                                       class="form-control"
                                       id="name"
                                       placeholder="Category Name">
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="fa fa-plus"></span>
                                Create
                            </button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
                <div class="overlay" v-if="newCategory.saving">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div><!-- /.box -->

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Categories</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <category-list :categories="categories" :active="active"></category-list>
                </div><!-- /.box-body -->
            </div><!-- /. box -->

        </div><!-- /.col -->
        <div class="col-md-9">

            <category-detail :active.sync="active"></category-detail>

        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
@endsection

@section('scripts')

    <script src="{{ asset('js/categories.js', false) }}"></script>
@endsection