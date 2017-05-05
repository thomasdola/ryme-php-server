import Vue from 'vue';
Vue.use(require('vue-resource'));

//import components
import InfoBox from "./components/infoBox.vue";
import Search from "./components/search.vue";
import TrendingArtists from "./components/trendingArtistTable.vue";
import VouchingRequests from "./components/vouchingRequestsTable.vue";
var numberUtils = require('mout/number');

Vue.filter('abbreviate', function(value){
    return numberUtils.abbreviate(value)
});

new Vue({
    el: 'section.content',
    data: {
        data: {},
        requests: [],
        artists: [],
        searchResult: []
    },
    components: {Search, InfoBox, TrendingArtists, VouchingRequests},
    methods: {
        fetchData(target, source=null, query=null){
            let data;
            let url = `internal/artists/${source}`;

            if(source == null){
                url = 'internal/artists'
            }

            if(query != null){
                url = `internal/artists/${source}?${query}`;
            }
            console.log(`final url -> ${url}`);
            this.$http.get(url).then(function(response){
                if(source == 'data'){
                    data =  response.data;
                }else{
                    data = response.data.data;
                }
                console.log(`target -> ${target} ----> data -> ${data}`);
                this.$set(target, data);
            }, function(response){
                console.log(response);
            });
        },
        initialData(){
            this.fetchData('data', 'data');
        },
        getTrendingArtists(){
            this.fetchData('artists', 'trending');
        },
        getUsersRequests(){
            this.fetchData('requests', 'requests');
        },
        performSearch(query){
            this.fetchData('searchResult', 'search', query);
        }
    },
    created(){
        this.initialData();
        this.getTrendingArtists();
        this.getUsersRequests();
    },
    ready(){}
});
