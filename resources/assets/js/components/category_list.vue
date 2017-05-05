<style>
	
</style>

<template>
	<ul class="nav nav-pills nav-stacked" v-for="category in categories">
        <category :active.sync="active" :category="category"></category>
    </ul>
</template>

<script type="text/babel">
	import Category from "./category.vue";
	export default {
		components: {Category},
		props: ['categories', 'active'],
		data(){
			return {
				
			}
		},
		ready(){
			
			console.log('ready from category list component');
		},
		watch: {
			'active': function(category){
				this.$dispatch('category-changed', category);
			}
		}
	}
</script>