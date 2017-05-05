<style>
	
</style>

<template>
	<table class="table table-striped">
       <thead>
           <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Role</th>
               <th>Action</th>
           </tr>
       </thead>
       <tbody>
           <tr v-for="staff in staffs">
               <td>{{ staff.name | capitalize }}</td>
               <td>{{ staff.email }}</td>
               <td>{{ staff.role.title | capitalize }}</td>
               <td>
                   <div class="row">
                       <div class="col-xs-6">
                           <button @click="editStaff(staff)" type="button"
                           class="btn btn-xs btn-default"
                           data-toggle="modal" data-target="#myModal">
                           <i class="fa fa-pencil"></i>
                           </button>
                       </div>
                       <div class="col-xs-6">
                           <button @click="deleteStaff(staff)" type="button" class="btn btn-xs btn-danger">
                           <i class="fa fa-trash"></i>
                           </button>
                       </div>
                   </div>
               </td>
           </tr>
       </tbody>
   </table>
   <edit-modal :staff="editedStaff" :roles="roles"></edit-modal>
</template>

<script type="text/babel">
	import EditModal from './edit-staff-form.vue';
	export default {
		props: ['staffs', 'roles'],
		data(){
			return {
				editedStaff: {}
			}
		},
		components: {EditModal},
		methods: {
			editStaff(staff){
				console.log(staff);
				this.setEditedStaff(staff);
				this.$broadcast('edit-staff', staff);
			},
			deleteStaff(staff){

                if(confirm("Are you Sure?")){
                    this.$http.delete(`internal/staffs/${staff.id}`)
                            .then((response) => {
                                this.staffs.$remove(staff);
                            },
                            (response) => {
                                console.log(response)
                            });
                }
            },
			setEditedStaff(staff){
				this.editedStaff = staff;
			}
		},
		events: {}
	}
</script>