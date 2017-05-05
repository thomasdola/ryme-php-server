<template>
	<div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#trending_tracks" data-toggle="tab">Trending Tracks</a></li>
            <li><a href="#trending_artists" data-toggle="tab">Trending Artists</a></li>
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
                        <tr v-for="track in tracks">
                            <td><a href="#">{{track.artist}}</a></td>
                            <td>{{track.artist}}</td>
                            <td>{{track.streams}}</td>
                            <td>{{track.downloads}}</td>
                            <td>{{track.likes}}</td>
                        </tr>
                        </tbody>
                    </table><!-- /.table -->
                </div>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="trending_artists">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>followers</th>
                                <th>tracks</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="artist in artists">
                            <td><a href="#">{{artist.name}}</a></td>
                            <td>{{artist.followers}}</td>
                            <td>{{artist.tracks}}</td>
                        </tr>
                        </tbody>
                    </table><!-- /.table -->
                </div>
            </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
    </div>
</template>

<script type="text/babel">
	export default {
		props: ['active'],
		methods: {
		    getCategory(category){
		        this.$http.get("internal/categories/{id}", {id: category.uuid})
                        .then(function(response){
                    this.tracks = response.data.trendingTracks.tracks;
                    this.artists = response.data.trendingArtists.artists;
		        }, function(response){});
		    }
		},
		computed: {},
		data(){
			return {
			    tracks: [],
			    artists: []
			}
		},
        ready(){

        },
        watch: {
            'active': function(category){
                this.$emit('category-changed', category);
            }
        },
        events: {
            'category-changed': function(category){
                console.log('got '+ category.name);
                this.getCategory(category);
            }
        }
	}
</script>