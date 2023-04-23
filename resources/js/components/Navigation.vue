<template>
      <v-app-bar class="container-p" app color="blue-darken-2">
        <router-link to="/" class="link"><v-toolbar-title class="text-h5">WebScraper</v-toolbar-title></router-link>        
        <v-spacer></v-spacer>
        <router-link to="/scrapes" class="link"><v-btn>All scrapes</v-btn></router-link>  
        <router-link to="/create" class="link"><v-btn>Create</v-btn> </router-link>         
        <router-link to="/try" class="link"><v-btn>Try it</v-btn>  </router-link>  
      </v-app-bar>
  </template>

<style scoped>
.link{
    text-decoration: none;
    color: inherit;
}
</style>