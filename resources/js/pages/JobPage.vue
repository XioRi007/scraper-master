<template>
    <v-container>
      <h1 class="text-center my-5">
        Job Info
      </h1>
      <v-card class="outlined" variant="outlined">
        <v-card-text>
          <v-row>
            <v-col cols="6">
              <v-row>
                  <v-col>
                      <p class="font-weight-bold">Job information</p>                                
                  </v-col>
              </v-row>
              <v-list>
                <v-list-item>
                  <v-list-item-title>Start time:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.start_time }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Start url:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.start_url }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Pod count:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.pod_count }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Page count:</v-list-item-title>
                  <v-list-item-subtitle v-if="job.page_count !=null">{{ job.page_count }}</v-list-item-subtitle>
                  <span v-else class="mdi mdi-infinity"></span>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Item count:</v-list-item-title>
                  <v-list-item-subtitle v-if="job.item_count !=null">{{ job.item_count }}</v-list-item-subtitle>
                  <span v-else class="mdi mdi-infinity"></span>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Status:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.status }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Duration:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.duration }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-col>
            <v-col cols="6">              
              <v-row>
                  <v-col>
                      <p class="font-weight-bold">Selectors</p>                                
                  </v-col>
              </v-row>
              <v-list>
                <v-list-item>
                  <v-list-item-title>Item Page Link Selector:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.params.item_page_link_selector }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Next Page Selector:</v-list-item-title>
                  <v-list-item-subtitle>{{ job.params.next_page_selector }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>         
              <v-row>
                  <v-col>
                      <p class="font-weight-bold">Item selectors</p>                                
                  </v-col>
              </v-row>
              <v-list>
                <v-list-item v-for="param in job.params.params">
                  <v-list-item-title>{{ param.name }}:</v-list-item-title>
                  <v-list-item-subtitle>{{ param.selector }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>  

            </v-col>
          </v-row>          
        </v-card-text>
      </v-card>

      <v-card class="px-15 outlined mt-15" variant="outlined">    
        <v-row class="py-5">
            <v-col class="d-flex justify-space-between">
                <p class="font-weight-bold">Ststistics</p>
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
    </v-container>
  </template>
  
  <script>
  import { ref } from 'vue'
  
  export default {
    name: 'JobPage',
    setup() {
      const job = ref({
        "_id": {
          "$oid": "643a8f1d0d658265f50d7a32"
        },
        "start_time": "04/15/2023, 11:48:44",
        "start_url": "https://books.toscrape.com/catalogue/page-50.html",
        "params": {
          "params": [
            {
              "name": "title",
              "selector": "h1 text"
            },
            {
              "name": "price",
              "selector": ".product_main>.price_color text"
            }
          ],
          "item_page_link_selector": "h3>a href",
          "next_page_selector": "li[class=next] a href"
        },
        "pod_count": 1,
        "page_count": null,
        "item_count": 1,
        "status": "finished",
        "pods": [],
        "duration": 43
      })
  
      return { job }
    }
  }
  </script>