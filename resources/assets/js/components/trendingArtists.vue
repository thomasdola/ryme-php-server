<template>
	<div class="col-md-12">
          <!-- USERS LIST -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Popular Artists</h3>
              <div class="box-tools pull-right">
                <!-- <span class="label label-danger">8 New Members</span> -->
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <li v-for="artist in artists">
                  <artist :artist="artist"></artist>
                </li>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="javascript::" class="uppercase">View More</a>
            </div><!-- /.box-footer -->
          </div><!--/.box -->
        </div><!-- /.col -->
</template>

<script type="text/babel">
	import Artist from "./artist.vue";
	export default{
		components: {Artist},
		data(){
			return {

			};
		},
		props: ['artists'],
		methods:{}
	}
</script>