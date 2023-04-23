import {createRouter, createWebHistory} from 'vue-router';
import Main from './pages/Main.vue'
import Create from './pages/Create.vue'
import JobPage from './pages/JobPage.vue'
import List from './pages/List.vue'
import Try from './pages/Try.vue'
const routes = [
    { path: '/create', component: Create },
    { path: '/scrapes/:id', component: JobPage },
    { path: '/scrapes', component: List },
    { path: '/try', component: Try },
    { path: '/', component: Main },
]

const router = createRouter({
    
  history: createWebHistory(),
  routes
})
export default router;