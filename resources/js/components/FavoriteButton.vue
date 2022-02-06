<template>
    <div>
        <img :src="imageLink" @click="favoriteIssue" width="20">
    </div>
</template>

<script>
export default {
    props: ['alias', 'favorite'],

    mounted() {
        console.log('Component mounted.')
    },

    data: function() {
        return {
            status: this.favorite,
        }
    },

    methods: {
        favoriteIssue() {
            axios.post( process.env.MIX_PREFIX_PATH + '/alias/' + this.alias + '/favorite')
            .then( response => {
                // console.log(process.env.ENV_PREFIX);
                this.status = ! this.status;
            });
        }
    },

    computed: {
        imageLink() {
            console.log(process.env.VUE_APP_ENV_PREFIX);

            return (this.status) ? process.env.MIX_PREFIX_PATH + "/svg/favorite.svg" : process.env.MIX_PREFIX_PATH + "/svg/not-favorite.svg";
        }
    }
}
</script>
