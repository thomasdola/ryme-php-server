<script type="text/babel">
    export default {
		methods: {},
		props: ['data'],
		computed: {
			icon(){
				switch(this.data.title){
					case "users":
						return "fa fa-users";
					break;
					case "tracks":
						return "fa fa-play";
					break;
					case "artists":
						return "fa fa-user";
					break;
					case "active ads":
						return "fa fa-tv";
					break;
					case 'Active Audio Ads':
						return 'fa fa-tv';
					break;
					case 'Active Event Ads':
						return 'fa fa-tv';
						break;
					case 'Total Companies':
						return 'fa fa-building';
						break;
                    default:
                        return "fa fa-user";
                    break;
				}
			}
		},
        ready(){
            console.log(`infoBox component is ready with data -> ${this.data}`);
        },
	}
</script>

<template>
	<div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i :class="icon"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{ data.title }}</span>
          <span class="info-box-number">{{ data.total | abbreviate }}</span>
        </div>
      </div>
    </div>
</template>