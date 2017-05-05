import Vue from "vue";
Vue.use(require('vue-resource'));

//import components
import InfoBox from './components/infoBox.vue';
import Search from './components/search.vue';
import UsersTable from './components/usersTable.vue';

var numberUtils = require('mout/number');

Vue.filter('abbreviate', function(value){
    return numberUtils.abbreviate(value)
});

new Vue({
    el: "section.content",
    components: {InfoBox, Search, UsersTable},
    methods: {
        fetchData(target, source=null){
            let url = `internal/users/${source}`;
            let data;
            if(source == null){
                url = 'internal/users'
            }
            this.$http.get(url).then((response) => {
                if(source == 'data'){
                    data = response.data;
                }else{
                    data = response.data.data
                }
                this.$set(target, data)
            }, response => console.log(response))
        },
        getInitialData(){
            this.fetchData('data', 'data');
        },
        getUsers(){
            this.fetchData('users');
        }
    },
    data: {
        data: {},
        users: []
    },
    created(){
        this.getInitialData();
        this.getUsers();
    },
    ready(){}
});



