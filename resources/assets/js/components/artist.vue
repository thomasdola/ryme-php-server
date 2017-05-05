<template>
	<img :src="avatar" alt="Artist Image">
	<a class="users-list-name" :href="profile_link">{{ artist.name }}</a>
	<!-- <span class="users-list-date">Today</span> -->
</template>

<script type="text/babel">
	export default{
		props:['artist'],
		computed:{
			avatar(){
				return 'this.artist.profilePic}';
			},
			profile_link(){
				return `artists/${this.artist.id}`;
			}
		}
	}
</script>
