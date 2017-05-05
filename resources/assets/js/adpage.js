import Vue from "vue";
Vue.use(require('vue-resource'));

//import components
var numberUtils = require('mout/number');

Vue.filter('abbreviate', function(value){
    return numberUtils.abbreviate(value)
});

new Vue({
    el: "section.content",
    components: {},
    methods: {},
    data: {
        activeActiveAds: {},
        activeEventAds: {},
        totalCompanies: {},
        audioAds: [],
        eventAds: [],
        newCompany:{
            name: ''
        },
        newAd:{
            title: "",
            startDate: "",
            endDate: "",
            company_id: null
        },
        newEventAd:{
            title: "",
            description: "",
            time: "",
            startDate: "",
            endDate: "",
            company_id: null
        }
    },
    created(){},
    ready(){}
});