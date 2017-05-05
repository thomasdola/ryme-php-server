import Vue from 'vue';
Vue.use(require('vue-resource'));
var numberUtils = require('mout/number');

//import components
import StaffTable from './components/staff-table.vue';
import EditModal from './components/edit-staff-form.vue';

Vue.config.debug = true;
Vue.filter('abbreviate', function(value){
    return numberUtils.abbreviate(value);
});
new Vue({
    el: "section.content",
    methods: {
        saveRole(){
            this.savingRole = true;
            let title = this.newRole.title.trim();
            if(title){
                let data = new FormData;
                data.append('title', title);
                this.$http.post("internal/roles", data).then(
                    (response) => {
                        console.log(response.data);
                        this.newRole.title = "";
                        this.savingRole = false;
                    },
                    (response) => {
                        console.log(response);
                        this.savingRole = false;
                    }
                )
            }
        },
        saveStaff(){
            this.savingStaff = true;
            let name = this.newStaff.name.trim();
            let email = this.newStaff.email.trim();
            let role_id = this.newStaff.role_id;
            if(name && email && role_id){
                let data = new FormData;
                data.append('name', name);
                data.append('email', email);
                data.append('role_id', role_id);
                this.$http.post('internal/staffs', data).then(
                    (response) => {
                        console.log(response.data.data);
                        this.staffs.push(response.data.data);
                        this.savingStaff = false;
                    },
                    (response) => {
                        console.log(response);
                        this.savingStaff = false;
                    }
                )
            }
        },
        fetchData(source, target){
            this.$http.get(`internal/${source}`).then(
                (response) => {
                    console.log(response.data.data);
                    this.$set(target, response.data.data);
                },
                (response) => {
                    console.log(response)
                }
            )
        },
        loadRoles(){
            this.fetchData('roles', 'roles');
        },
        loadStaffs(){
            this.fetchData('staffs', 'staffs');
        }
    },
    components: {StaffTable, EditModal},
    events: {},
    created(){
        this.loadRoles();
        this.loadStaffs();
        console.log('main Component created');
    },
    ready(){
        console.log('now ready');
    },
    data: {
        savingRole: false,
        savingStaff: false,
        newRole: {
            title: ''
        },
        newStaff: {
            name: '',
            email: '',
            role_id: ''
        },
        roles: [],
        staffs: [],
        staff: {}
    }
});