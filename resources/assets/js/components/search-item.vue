<template>
    <li class="list-group-item">
        <a :href="link">
            {{ item.name }}
        </a>
    </li>
</template>

<script type="text/babel">
    export default {
        props: ['item'],
        computed: {
            link(){
                let is_artist = this.item.is_artist;
                let url = this.getUrl(is_artist);
                return url;
            }
        },
        methods: {
            getUrl(is_artist){
                let url;
                if(is_artist){
                    url = `artists/${this.item.id}`;
                }else {
                    url = `users/${this.item.id}`;
                }
                return url;
            }
        }
    }
</script>
