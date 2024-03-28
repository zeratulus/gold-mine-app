import { createMemoryHistory, createRouter } from 'vue-router';

import CompanyView from './components/CompanyView.vue';
import CountriesView from './components/CountriesView.vue';
import LeadersView from './components/LeadersView.vue';
import NotFound from './components/NotFound.vue';

const routes = [
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
    { path: '/', component: CompanyView },
    { path: '/companies', component: CompanyView },
    { path: '/countries', component: CountriesView },
    { path: '/leaders', component: LeadersView }
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router
