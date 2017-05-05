<style type="text/css">
	ul.result__vew{
		z-index: 9999;
		position: absolute;
		width: 90%;
	}
	ul.result__vew li a{
		text-decoration: none;
	}
	.search__btn:hover{
		cursor: pointer;
	}
</style>

<template>
	<div class="input-group col-md-5 col-md-offset-3">
        <div class="row">
        	<div class="col-xs-12">
	        	<div class="input-group">
	        	  	<input type="text"
	        	  	v-model="searchQuery"
	        	  	@keyup="search | debounce 500"
	        	  	:placeholder="placeholder"
	        	  	class="form-control">
		        	<span class="input-group-addon search__btn" @click="searchWithQuery">
		        	  	<i class="fa fa-search fa-spin"></i>
		    	  	</span>
	        	</div>
        	</div>
        	<div class="col-xs-12" v-if="searchResult && searchQuery">
        		<ul class="list-group result__vew" v-for="item in searchResult">
        			<search-result-item :item="item"></search-result-item>
        		</ul>
        	</div>
        </div>
    </div>
</template>

<script type="text/babel">
	import SearchResultItem from './search-item.vue';
	export default {
		components: {SearchResultItem},
		data(){
			return {
				searchQuery:"",
				searchResult: []
			}
		},
        computed: {
            placeholder(){
				let placeholder = '';
                if(this.page == 'users'){
                    placeholder = 'Search for users ...';
                }else if(this.page == 'artists'){
                    placeholder =  'Search for artists ...';
                }
				return placeholder;
            }
        },

        props: ['page'],
		methods: {
			search(){
				if(this.searchQuery.trim()){
                    if(this.page == 'users'){
                        this.performSearch(this.searchQuery.trim(), 'users')
                    }else if(this.page == 'artists'){
                        this.performSearch(this.searchQuery.trim(), 'artists')
                    }
				}
			},
			searchWithQuery(){
				if(this.searchQuery.trim()){
                    if(this.page == 'users'){
                        this.performSearch(this.searchQuery.trim(), 'users')
                    }else if(this.page == 'artists'){
                        this.performSearch(this.searchQuery.trim(), 'artists')
                    }
				}
			},
			performSearch(query, type){
				this.$http.get(`internal/local/search?q=${query}&type=${type}`)
                        .then((response) => {
					this.$set('searchResult', response.data.data);
				}, (response) => {
					console.log(response);
				});
			}
		}
	}
</script>
