import Vue from 'vue';
Vue.use(require('vue-resource'));
Vue.config.devtools = true;

//import components
import CategoryDetail from "./components/category_detail.vue";
import CategoryList from "./components/category_list.vue";
var numberUtils = require('mout/number');

Vue.filter('abbreviate', function(value){
    return numberUtils.abbreviate(value)
});
new Vue({
    el: "section.content",
    components: {CategoryDetail, CategoryList},
    data: {
        newCategory: {
            name: '',
            saving: false
        },
        categories: [],
        active: {}
    },
    methods: {
        saveCategory(){
            var text = this.newCategory.name.trim();
            if(text){
                this.newCategory.saving = true;
                this.$http.post("internal/categories", {name: text})
                    .then(function(response){
                        console.log(response);
                        this.getAllCategories();
                        this.newCategory.saving = false;
                }, function(response){
                        console.log(response);
                        this.newCategory.saving = false;
                });
                console.log(text);
                this.newCategory.name = '';
            }
        },
        setActiveCategory(category){
            console.log("initial active => " + category.name);
            this.active = category;
        },
        getAllCategories(){
            this.$http.get("internal/categories")
                .then(function(response){
                    this.categories = response.data.categories;
                    this.setActiveCategory(this.categories[0]);
                    this.$emit('initial-active-category', this.active);
                    console.log(response.data.categories);
                }, function(response){
                    console.log(response)
                })
        }
    },
    created(){
        this.getAllCategories();
        console.log('main category component is now created');
    },
    computed: {},
    ready(){
        console.log('main category component is now ready');
    },
    events: {
        'category-changed': function(category){
            this.setActiveCategory(category);
            console.log('category changed');
        }
    }
});
