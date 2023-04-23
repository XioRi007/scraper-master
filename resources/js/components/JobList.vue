
  
  <script>
  import { ref, computed } from 'vue';
  
  export default {
    name: 'JobList',
    props: {
      jobs: {
        type: Array,
        required: true,
      },
    },
    setup(props) {
      const filterParams = ref({
        status:null,
        url:null
      });
  
      // const jobs = computed(() => {
      //   //
        
      //   return jobs;
      // });
      const filter = () => {
        console.log(filterParams.value);
      }
  
      const statusItems = ['created', 'processing', 'finished', 'stopped', 'resumed'];
  
      const extractDomain = (url) => {
        const matches = url.match(/^https?:\/\/([^/?#]+)(?:[/?#]|$)/i);
        const domain = matches && matches[1];
        return domain;
      };
  
      return {
        // jobs,
        statusItems,
        extractDomain,
        filter,
        filterParams
      };
    },
  };
  </script>
  <template>
    <v-container>
      <v-row>
        <v-col cols="5">
          <v-text-field v-model="filterParams.url" label="Search" clearable></v-text-field>
        </v-col>
        <v-col cols="5">
          <v-select v-model="filterParams.status" :items="statusItems" label="Status" clearable ></v-select>
        </v-col>
        <v-col cols="2" class="mt-3">
          <v-btn color="blue-darken-2" text @click="filter">Filter</v-btn>
        </v-col>
      </v-row>
  
      <v-row>
        <v-col v-for="task in jobs" :key="task._id" cols="12" md="6" lg="3">
          <v-card>
            <router-link :to="'/scrapes/'+task._id" class="link">
              <v-card-title>{{ extractDomain(task.params.url) }}</v-card-title>
              <v-card-text>
                <div><strong>Start Time:</strong> {{ task.start_time }}</div>
                <div><strong>Pod Count:</strong> {{ task.pod_count }}</div>
                <div><strong>Status:</strong> {{ task.status }}</div>
                <div><strong>Duration:</strong> {{ task.duration }}</div>
              </v-card-text>
            </router-link>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
<style scoped>
.link{
  color: inherit;
  text-decoration: none;
}
</style>