<template>
	<table class="table table-hover">
	        <thead>
	            <tr>
	                <th>Stage Name</th>
	                <th>Genre</th>
	                <th>Start Date</th>
	                <th>End Date</th>
	                <th>Action</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr v-for="request in requests">
	            <td>{{ request.stage_name }}</td>
	            <td>{{ request.genre }}</td>
	            <td>{{ request.start_date }}</td>
	            <td>{{ request.end_date }}</td>
	            <td>
	                <button type="button" 
	                	@click="cancelRequest(request, $index)" 
	                	class="btn btn-xs btn-default">
	                    <i class="fa fa-times"></i>
	                </button>
	            </td>
	        </tr>
	        </tbody>
	    </table>
</template>

<script type="text/babel">
	export default {
		props: ['requests'],
		methods: {
			cancelRequest(request, index){
				console.log(request.user, index);
			}
		}
	}
</script>