<template>
    <div>
        <b-container class="bv-example-row ml-2">
            <div v-if="loading" style="position:fixed;top:35%;left:50%;">
                <b-spinner style="width: 3rem; height: 3rem;" type="grow" variant="info" label="Loading..."></b-spinner>
            </div>
            <div v-if="!loading">
                <b-row cols="3">
                    <div v-for="character in characters" :key="character.id">
                        <b-col>
                        <b-card
                            :title="character.name"
                            :img-src="character.picture+'/standard_xlarge.jpg'"
                            img-alt="Image"
                            img-top
                            tag="article"
                            style="max-width: 20rem;"
                            class="mb-4"
                        >
                            <b-row>
                            <b-col></b-col>
                            <b-col cols="8">
                                <router-link :to="{ name: 'Character', params: { id: character.id }}">
                                    <b-button v-b-tooltip.hover.bottom title="View details" variant="primary">{{ character.name }}</b-button>
                                </router-link>
                            </b-col>
                            <b-col><b-icon
                                    class="h3 ml-10"
                                    :icon="character.inFavorites ? 'star-fill' : 'star'"
                                    aria-hidden="true"
                                    @click="changeFavorites(character)"
                                    v-b-tooltip.hover :title="character.inFavorites ? 'Remove from favorites' : 'Add to favorites'"
                                    ></b-icon></b-col>
                            </b-row>
                        </b-card>
                        </b-col>
                    </div>
                </b-row>
            </div>
        </b-container>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Characters',
  data() {
    return {
      characters: [],
      favorites: [],
      loading: true,
      currentPage: 1,
      perPage: 3
    }
  },
  mounted() {
    axios.get("/api/characters",{
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-User-Info": "true"
      }})
    .then(response => {
        if (response.status == 200) {
            this.loading = false;
            this.characters = response.data;
            this.characters = this.characters.map(character => {
                return {...character, inFavorites: false}
            });
        }
    })
  },
  methods: {
    changeFavorites(character) {
      if (this.favorites.length < 5 && !this.favorites.includes(character.id)) {
        this.favorites.push(character.id);
        character.inFavorites = !character.inFavorites;
      } else if (this.favorites.includes(character.id)) {
        character.inFavorites = !character.inFavorites;
        this.favorites = this.favorites.filter(favorite => favorite != character.id);
      }else {
        alert("You already selected 5 characters, please remove one before choosing a new character");
      }
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.bootstrap-icon:hover{
  cursor: pointer;
}
</style>