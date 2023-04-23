<script setup>
import { ref } from 'vue'
import JobList from '../components/JobList.vue';
const jobs = ref([
      {
        _id: 1,
        start_time: '2022-04-01 10:00:00',
        params: {
    "url":"https://books.toscrape.com/catalogue/page-50.html",
    "params":[{
                "name":"title",
                "selector":"h1 text"
            },{
                "name":"price",
                "selector":".product_main>.price_color text"
            }
    ],
    "item_page_link_selector":"h3>a href",
    "next_page_selector":"li[class=next] a href",
    "pod_count":1
},
        pod_count: 3,
        status: 'In progress',
      },
      {
        _id: 2,
        start_time: '2022-04-02 14:30:00',
        params: {
    "url":"https://books.toscrape.com/catalogue/page-50.html",
    "params":[{
                "name":"title",
                "selector":"h1 text"
            },{
                "name":"price",
                "selector":".product_main>.price_color text"
            }
    ],
    "item_page_link_selector":"h3>a href",
    "next_page_selector":"li[class=next] a href",
    "pod_count":1
},
        pod_count: 2,
        status: 'Completed',
      },
      // ...
    ]);

</script>

<template>
    <h1 class="text-center my-10">
        Welcome to the scrapes list page
    </h1>
    <v-card class="pa-10 outlined" variant="outlined">
        <JobList :jobs="jobs"></JobList>
    </v-card>
    
    
</template>