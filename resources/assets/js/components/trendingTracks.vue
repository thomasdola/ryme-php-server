<template>
	<div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Trending Tracks</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
              <tr>
                <th>Title</th>
                <th>Artist(s)</th>
                <th>Category</th>
                <th>Streams</th>
                <th>Download</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="track in tracks">
                <td>{{ track.title }}</td>
                <td>{{ track.artist }}</td>
                <td>{{ track.genre }}</td>
                <td>{{ track.streams }}</td>
                <td>{{ track.downloads }}</td>
              </tr>
              </tbody>
            </table>
          </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
      </div><!-- /.box -->
</template>

<script type="text/babel">
	export default {
		data(){
			return {}
		},
		methods(){},
		props:['tracks']
	}
</script>