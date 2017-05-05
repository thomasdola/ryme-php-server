<style>

</style>

<template>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User Joined Today</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th> # Category(ies)</th>
                                <th> # Artists(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users">
                                <td>{{ user.username }}</td>
                                <td>{{ user.phone }}</td>
                                <td>{{user.categories }}</td>
                                <td>{{ user.artists }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</template>

<script type="text/babel">

    export default {
        props: ['users']
    }

</script>