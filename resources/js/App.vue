<script setup>
import Footer from './components/Footer.vue';
import Navigation from './components/Navigation.vue';

</script>

<template>
        <v-app>
                <Navigation/>
                <v-main class="container-m">
                        <router-view/>
                </v-main>
                <Footer></Footer>
        </v-app>
</template>
<style>
.container-m{
        margin: 0 10em!important;
}
.container-p{
        padding: 0 10em!important;
}
.v-alert {
  position: fixed;
  left: 50%;
  bottom: 50px;
  transform: translate(-50%, -50%);
  margin: 0 auto;
  font-size: inherit;
}
ol, ul{
  text-decoration: none;
  list-style: none;
}
a{
  text-decoration: none;
  color: inherit;
}
</style>