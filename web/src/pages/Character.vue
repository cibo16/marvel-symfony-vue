<template>
    <div>
        <b-container class="bv-example-row ml-2 mt-2">
            <div v-if="loading" style="position:fixed;top:35%;left:50%;">
                <b-spinner style="width: 3rem; height: 3rem;" type="grow" variant="info" label="Loading..."></b-spinner>
            </div>
            <div v-if="!loading">
                <b-row>
                    <router-link :to="{ name: 'Characters'}">
                        <b-button v-b-tooltip.hover.bottom title="Characters" variant="primary" class="mb-3" style="float:left">
                             <b-icon icon="arrow-left-circle"></b-icon>
                             Characters
                        </b-button>
                    </router-link>
                </b-row>
                <b-row>
                    <b-col>
                        <b-img :src="character.picture+'.jpg'" fluid alt="Responsive image"></b-img>
                    </b-col>
                    <b-col>
                        <h2 style="text-align:center;">{{ character.name }}</h2>
                        <h3 style="text-align:left;">Description:</h3>
                        <p style="text-align:left;">{{ character.description }}</p>
                        <h5 style="text-align:left;">Number of comics: {{ character.comicsAppearances.length }}</h5>
                        <p style="text-align:left;">First three comics:</p>
                        <ul>
                            <li style="text-align:left;" v-for="(comic, index) in character.comicsAppearances.slice(0,3)" :key="index">{{ comic }}</li>
                        </ul>
                    </b-col>
                </b-row>
            </div>
        </b-container>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    name: "Character",
    data() {
        return {
            character: {},
            loading: true
        }
    },
    mounted() {
        axios.get("/api/character/"+this.$route.params.id,{
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-User-Info": "true"
        }})
        .then(response => {
            if (response.status == 200) {
                this.loading = false;
                this.character = response.data[0];
            }
        })
    },
}
</script>
<style lang="">
    
</style>