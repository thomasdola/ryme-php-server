import Vue from "vue";
var _ = require('lodash');
Vue.use(require('vue-resource'));
Vue.config.warnExpressionErrors = false;
var numberUtils = require('mout/number');

import EventAdsTable from './components/eventAdsTable.vue';
import AudioAdsTable from './components/audioAdsTable.vue';
import InfoBox from './components/infoBox.vue';

Vue.filter('abbreviate', function(value){
    return numberUtils.abbreviate(value)
});

new Vue({
    el: "section.content",
    components: {EventAdsTable, AudioAdsTable, InfoBox},
    methods: {
        saveCompany(){
            let name = this.newCompany.name.trim();
            if(name){
                this.savingCompany = true;
                this.$http.post("internal/companies", {name: name}).then((response) => {
                    console.log(response);
                    this.clearFields(this.newCompany);
                    this.companies.push(response.data.data);
                    this.savingCompany = false;
                }, function(response){
                    console.log(response);
                    this.savingCompany = false;
                });
            }
        },
        saveSession(){
            let name = this.newSession.name.trim();
            let start = this.newSession.start;
            let end = this.newSession.end;
            if(name && start && end){
                this.savingSession = true;
                let payload = new FormData();
                payload.append('name', name);
                payload.append('start', start);
                payload.append('end', end);
                this.$http.post('internal/ad-sections', payload).then(function(response){
                    this.sessions.push(response.data.data);
                    this.clearFields(this.newSession);
                    this.savingSession = false;
                }, function(response){
                    this.savingSession = false;
                    console.log(response);
                });
            }

        },
        onAudioChange(e){
            this.onFileChange(e, "audio");
        },
        onImageChange(e){
            this.onFileChange(e, "image");
        },
        onFileChange(e, type) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            let file = files[0];
            console.log(files[0], type, file, "no Condition");
            if(type == "image"){
                console.log(files[0], type, file);
                this.newEventAd.image_file = file;
            }else if(type == "audio"){
                console.log(files[0], type, file);
                this.newAd.audio_file = file;
            }
        },
        saveAd(){
            let title = this.newAd.title.trim();
            let startDate = this.newAd.startDate;
            let endDate = this.newAd.endDate;
            let companyId = this.newAd.company_id;
            let sessionIds = this.newAd.session_id;
            let categoryIds = this.newAd.category_id;
            if( title && companyId && endDate && startDate){
                this.savingAd = true;
                var payload = new FormData();
                payload.append("title", title);
                payload.append("start_date", startDate);
                payload.append("end_date", endDate);
                payload.append("company_id", companyId);
                payload.append("file", this.newAd.audio_file);
                payload.append("section_ids", sessionIds);
                payload.append("category_ids", categoryIds);
                this.$http.post("internal/audio-ads", payload).then(function(response){
                    this.audioAds.push(response.data.data);
                    //this.clearFields(this.newAd);
                    this.savingAd = false;
                }, function(response){
                    console.log(response);
                    this.savingAd = false;
                });
            }
        },
        saveEventAd(){
            let title = this.newEventAd.title.trim();
            let venue = this.newEventAd.venue.trim();
            let fare = this.newEventAd.fare.trim();
            let description = this.newEventAd.description.trim();
            let dateTime = this.newEventAd.dateTime;
            let startDate = this.newEventAd.startDate;
            let endDate = this.newEventAd.endDate;
            let companyId = this.newEventAd.company_id;
            let sessionIds = this.newEventAd.session_id;
            let categoryIds = this.newEventAd.category_id;
            if( title && companyId && endDate && fare
                && startDate && description && venue && dateTime){
                this.savingAd = true;
                let payload = new FormData();
                payload.append("title", title);
                payload.append("venue", venue);
                payload.append("fare", fare);
                payload.append("date_time", dateTime);
                payload.append("description", description);
                payload.append("start_date", startDate);
                payload.append("end_date", endDate);
                payload.append("section_ids", sessionIds);
                payload.append("category_ids", categoryIds);
                payload.append("file", this.newEventAd.image_file);
                this.$http.post('internal/event-ads', payload).then(function(response){
                    console.log(response);
                    this.eventAds.push(response.data.data);
                    this.savingAd = false;
                }, function(response){
                    console.log(response);
                    this.savingAd = false;
                });
            }
        },
        clearFields(form){
            _.forEach(form, function(value, key){
                form[key] = "";
                console.log(key , " -> ", value);
            });
        },
        loadCompanies(){
            this.$http.get("internal/companies").then((response) => {
                console.log(response);
                this.companies = response.data.data;
                this.totalCompanies.total = this.companies.length;
            }, function(response){
                console.log(response);
            });
        },
        loadAudioAds(){
            this.$http.get("internal/audio-ads").then((response) => {
                console.log(response);
                this.audioAds = response.data.data;
                this.activeAudioAds.total = this.audioAds.length;
            }, function(response){
                console.log(response);
            });
        },
        loadEventAds(){
            this.$http.get("internal/event-ads").then((response) => {
                console.log(response);
                this.eventAds = response.data.data;
                this.activeEventAds.total = this.eventAds.length;
            }, function(response){
                console.log(response);
            });
        },
        loadSections(){
            this.$http.get('internal/ad-sections').then(function(response){
                this.$set('sessions', response.data.data);
                console.log(response);
            }, function(response){
                console.log(response);
            });
        },
        loadCategories(){
            this.$http.get('internal/categories').then(function(response){
                this.$set('categories', response.data.categories);
                console.log(response);
            }, function(response){
                console.log(response);
            });
        }
    },
    data: {
        activeAudioAds: {
            title: 'Active Audio Ads',
            total: null
        },
        activeEventAds: {
            title: 'Active Event Ads',
            total: null
        },
        totalCompanies: {
            title: 'Total Companies',
            total: null
        },
        savingCompany: false,
        savingAd: false,
        savingSession: false,
        companies: [],
        audioAds: [],
        eventAds: [],
        categories: [],
        sessions: [],
        newCompany:{
            name: ''
        },
        newSession: {
            name: '',
            start: '',
            end: ''
        },
        newAd:{
            title: "",
            startDate: "",
            endDate: "",
            session_id: [],
            category_id: [],
            company_id: null,
            audio_file: null
        },
        newEventAd:{
            title: "",
            venue: "",
            fare: "",
            description: "",
            session_id: [],
            category_id: [],
            dateTime: "",
            startDate: "",
            endDate: "",
            company_id: null,
            image_file: null
        }
    },
    created(){
        this.loadCompanies();
        this.loadAudioAds();
        this.loadEventAds();
        this.loadSections();
        this.loadCategories();
    },
    ready(){
    }
});