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
                    <h3 class="box-title">New Role</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" @submit.prevent="saveRole">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Role Title</label>
                                <input v-model="newRole.title" type="text"
                                       class="form-control" id="name" placeholder="Role Title">
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="fa fa-plus"></span>
                                Add
                            </button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
                <div class="overlay" v-if="savingRole">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div><!-- /.box -->

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active" v-for="role in roles">
                            <i class="fa fa-user"></i>
                            @{{ role.title | capitalize }}
                            <span class="label label-danger pull-right">
                                    @{{ role.staff | abbreviate }}
                            </span>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Staff Details</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" @submit.prevent="saveStaff">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Staff Name</label>
                                <input v-model="newStaff.name"
                                       required
                                       type="text"
                                       name="name"
                                       class="form-control"
                                       id="staffName"
                                       placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Staff Email</label>
                                <input v-model="newStaff.email"
                                       required
                                       type="email" name="email"
                                       class="form-control"
                                       id="StaffEmail"
                                       placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="staffRole">Role</label>
                                <select v-model="newStaff.role_id"
                                        required
                                        name="role_id"
                                        class="form-control"
                                        id="staffRole"  style="width: 100%;">
                                    <option v-for="role in roles"
                                            :value="role.id">
                                        @{{ role.title | capitalize }}
                                    </option>
                                </select>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="fa fa-save"></span>
                                Save
                            </button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
                <div class="overlay" v-if="savingStaff">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div><!-- /.box -->

        </div><!-- /.col -->
        <div class="col-md-9">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Staff</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <staff-table :staffs="staffs" :roles="roles"></staff-table>
                </div><!-- /.box-body -->
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js', false) }}"></script>
@endsection