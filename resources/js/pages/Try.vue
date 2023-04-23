<script setup>
    import { ref, onBeforeMount } from 'vue'
    import axios from 'axios'
    import { useRouter, useRoute } from 'vue-router'

    const form = ref({
        url: '',
        params:[],
        itemPageLinkSelector: '',
        nextPageSelector: '',
        podCount: 3,
        pageCount:2,
        itemsCount:1
    });
    const tasks = ref([
    {
        "_id": {
            "$oid": "643a8b7b4cc529ad05091343"
        },
        "scrape_id": "643a8b7b4cc529ad05091342",
        "url": "https://books.toscrape.com/catalogue/page-50.html",
        "status": "created",
        "type": "pagination",
        "worker": "scraper-laravel-5fdcd9f96-2lb7m"
    },
    {
        "_id": {
            "$oid": "643a8b7b4cc529ad05091343"
        },
        "scrape_id": "643a8b7b4cc529ad05091342",
        "url": "https://books.toscrape.com/catalogue/page-50.html",
        "status": "created",
        "type": "pagination",
        "worker": "scraper-laravel-5fdcd9f96-2lb7m"
    },
    ]);
    const items = [{
  "_id": {
    "$oid": "643a8f5fd718ec6df03c132c"
  },
  "scrape_id": "643a8f1d0d658265f50d7a32",
  "title": "Frankenstein",
  "price": "£38.00",
  "__v": 0
},{
  "_id": {
    "$oid": "643a8f5fd718ec6df03c132c"
  },
  "scrape_id": "643a8f1d0d658265f50d7a32",
  "title": "Frankenstein",
  "price": "£38.00",
  "__v": 0
}];
    const router = useRouter();
    const route = useRoute();
    onBeforeMount(() => { 
      for (const key in route.query) {        
        if (form.value.hasOwnProperty(key) && key != 'params') {
          form.value[key] = route.query[key]
        }
      }
      if(route.query.hasOwnProperty('params')){
        form.value['params'] = JSON.parse(route.query['params']);
      }
    });
    
    const updateUrl = (e) => {
      route.query[e.target.name] = e.target.value;
      const urlSearchParams = new URLSearchParams(route.query).toString();
      const url = `${location.pathname}?${urlSearchParams}`;
      history.pushState(null, '', url);
    }    
    const formRef = ref(null);
    const paramCount = ref(1);
    const addParam = () => {
        paramCount.value++;
        form.value.params.push({ name: '', selector: '' });
    }
    const submitForm = async() => {
        const { valid } = await formRef.value.validate()
        if(valid){
            // const res = await axios({
            //     method: 'POST',
            //     url: '/api',
            //     headers: {
            //     'Content-Type': 'application/json'
            //     },
            //     data: JSON.stringify(form.value)
            // });
            // console.log(res);
        }
    };
    const updateUrlItemParams = () => {
        route.query.params = JSON.stringify(form.value.params);
        const urlSearchParams = new URLSearchParams(route.query).toString();
        const url = `${location.pathname}?${urlSearchParams}`;
        history.pushState(null, '', url);
    }
    const goToCreatePage = () => {
        router.push({
            path:'/create',
            query:route.query
        })
    }
</script>

<template>
  <h1 class="text-center my-5">
    Try and check selectors
  </h1>
  <v-card class="pa-15 outlined" variant="outlined">
        <v-form @submit.prevent="submitForm" ref="formRef">
            <v-card-text>
                <v-row>
                    <v-col cols="6">
                        <v-row>
                            <v-col>
                                <p class="font-weight-bold">Job information</p>                                
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-tooltip 
                                    text="Start URL for the job, the first page with list of links of items you want ot scrape." 
                                    location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-text-field name='url' v-bind="props" @input="updateUrl" :rules="[v => !!v || 'Url is required']" v-model="form.url" label="URL"></v-text-field>
                                    </template>
                                </v-tooltip>                                
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-tooltip 
                                    text="Selector for the links, that leads to the item's page." 
                                    location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-text-field name='itemPageLinkSelector' v-bind="props" @input="updateUrl" :rules="[v => !!v || 'Selector is required']" v-model="form.itemPageLinkSelector" label="Item page link selector"></v-text-field>
                                    </template>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-tooltip 
                                    text="Selector for the link to the next page." 
                                    location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-text-field name='nextPageSelector' v-bind="props" :rules="[v => !!v || 'Selector is required']" v-model="form.nextPageSelector" label="Next page selector"></v-text-field>
                                    </template>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-tooltip 
                                    text="The count of the containers, that will process the job." 
                                    location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-text-field name='podCount' type="number" disabled v-bind="props" :rules="[v => !!v || 'Pod count is required']" v-model.number="form.podCount" label="Pod count"></v-text-field>
                                    </template>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-tooltip 
                                    text="The number of the pages, that will be scraped. Leave it empty to set infinity." 
                                    location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-text-field name='pageCount' type="number" disabled v-bind="props" :rules="[v => !!v || 'PageCount count is required']" v-model.number="form.pageCount" label="Page count"></v-text-field>
                                    </template>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-tooltip 
                                    text="The number of the items on each page, that will be scraped. Leave it empty to set infinity." 
                                    location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-text-field name='itemsCount' type="number" disabled v-bind="props" :rules="[v => !!v || 'ItemsCount count is required']" v-model.number="form.itemsCount" label="Items count per page"></v-text-field>
                                    </template>
                                </v-tooltip>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="6">                        
                        <v-row>
                            <v-col>
                                <p class="font-weight-bold">Scraped item information</p>                                
                            </v-col>
                        </v-row>
                        <v-row v-for="(param, index) in form.params" :key="index">
                            <v-col cols="5">
                                <v-text-field  @input="updateUrlItemParams" :rules="[v => !!v || 'Parameter name is required']" v-model="param.name" :label="'Param ' + (index + 1) + ' name'"></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field  @input="updateUrlItemParams" :rules="[v => !!v || 'Parameter selector is required']" v-model="param.selector" :label="'Param ' + (index + 1) + ' selector'"></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-btn @click="form.params.splice(index, 1);updateUrlItemParams();" text color="red" class="my-3">-</v-btn>
                            </v-col>
                        </v-row>
                        <v-btn  justify="end" class="my-6" @click="addParam">+</v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-row justify="end" class="py-5">
                <v-btn type="submit" color="blue-darken-2">Submit</v-btn>
            </v-row>
        </v-form>
  </v-card>

  <v-card class="px-15 outlined mt-15" variant="outlined">    
    <v-row class="py-5">
        <v-col class="d-flex justify-space-between">
            <p class="font-weight-bold">Tasks</p>
            <v-btn @click="reloadStats" class="mdi mdi-refresh "></v-btn>    
        </v-col>        
    </v-row>

    <v-row class="mb-5">
      <v-col cols="12" md="6" lg="4" v-for="task in tasks" :key="task._id.$oid">
        <v-card>
          <v-card-title>
            <span class="headline">{{ task.type }}</span>
          </v-card-title>
          <v-card-text>
            <div><strong>URL: </strong>{{ task.url }}</div>
            <div><strong>Worker: </strong>{{ task.worker }}</div>
            <div><strong>Status: </strong>{{ task.status }}</div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>    
  </v-card>

  <v-card class="px-15 outlined mt-15" variant="outlined">    
    <v-row class="py-5">
        <v-col class="d-flex justify-space-between">
            <p class="font-weight-bold">Items</p>
            <v-btn @click="reloadStats" class="mdi mdi-refresh "></v-btn>    
        </v-col>        
    </v-row>

    <v-row class="mb-5">
      <v-col cols="12" md="6" lg="3" v-for="item in items" :key="item._id.$oid">
        <v-card>
          <v-card-text>
            <p v-for=" entry in Object.entries(item)"> <strong>{{ entry[0] }}</strong>:{{ entry[1] }}</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>    
  </v-card>
  <v-row class="d-flex justify-center">
    <v-btn color="blue-darken-2" class="mx-auto mt-15"  @click="goToCreatePage">Go to the create page</v-btn>
  </v-row>
</template>
<style>
    .outlined {
        border-color: #1976D2;
    }
</style>