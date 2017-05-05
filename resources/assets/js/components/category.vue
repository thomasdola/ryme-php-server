<style>
</style>


<template>
	<li :class="act">
		<a href="#"  @click="setActive">
		    <i class="fa fa-box"></i>
		    {{ category.name | capitalize }}
		    <span class="label label-info pull-right">
		        {{ category.followers | abbreviate}}
		    </span>
		</a>
	</li>
</template>

<script type="text/babel">
	var numberUtils = require('mout/number');
	export default {
		methods: {
			setActive(){
	            if(this.category != this.active ){
	                this.active = this.category;
	            }
	        }
		},
		props: ['active', 'category'],
		computed: {
			act(){
				if(this.active == this.category){
					return "active";
				}
			}
		},
		ready(){
			console.log('ready from category component');
		}
	}
</script>