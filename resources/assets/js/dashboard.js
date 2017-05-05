import Vue from 'vue';
Vue.use(require('vue-resource'));

//import components
import InfoBox from "./components/infoBox.vue";
import TrendingTracks from "./components/trendingTracks.vue";
import TrendingArtists from "./components/trendingArtists.vue";

new Vue({
    el:"section.content",
    data:{
        users: {},
        tracks: {},
        artists: {},
        activeAds: {},
        trendingTracks: [],
        trendingArtists: []
    },
    components:{InfoBox, TrendingTracks, TrendingArtists},
    created(){
        console.log('dashboard component created');
    },
    ready(){
        console.log('dashboard component is ready');
        this.totalUsers();
        this.totalArtists();
        this.totalTracks();
        this.activeAudioAds();
        this.getTrendingTracks();
        this.getPopularArtists();
    },
    methods:{
        fetchData(source, target){
            let data;
            this.$http.get(`internal/dashboard/${source}`).then(function(response){
                if(source == 'trending-tracks' || source == 'top-artists'){
                    data =  response.data.data;
                }else{
                    data = response.data;
                }
                this.$set(target, data);
            }, function(response){
                console.log(response);
            });
        },
        totalUsers(){
            this.fetchData('total-users', 'users');
        },
        totalTracks(){
            this.fetchData('total-tracks', 'tracks');
        },
        totalArtists(){
            this.fetchData('total-artists', 'artists');
        },
        activeAudioAds(){
            this.fetchData('total-ads', 'activeAds');
        },
        getTrendingTracks(){
            this.fetchData('trending-tracks', 'trendingTracks');
        },
        getPopularArtists(){
            this.fetchData('top-artists', 'trendingArtists');
        }
    }
});