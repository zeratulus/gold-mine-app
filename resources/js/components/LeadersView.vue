<script>

import { ref } from "vue";
import moment from "moment";
import { Dropdown, Ripple, initMDB } from "mdb-ui-kit";

initMDB({ Dropdown, Ripple });

export default {
    setup() {
        const reportData = ref(false);
        const reportType = ref(false);
        const countries = ref(false);
        const companies = ref(false);
        const monthsList = ref(moment.months());
        const currentMonth = ref(moment().month());
        return {
            reportData,
            reportType,
            countries,
            companies,
            monthsList,
            currentMonth
        }
    },
    methods: {
        generate() {
            this.showPreloader();
            this.axios('/api/generate').finally(() => {
                this.refreshAll()
                this.hidePreloader();
            });
        },
        clear() {
            this.showPreloader();
            this.axios('/api/clear').finally(() => {
                this.refreshAll()
                this.hidePreloader();
            });
        },
        showPreloader() {
            let body = document.querySelector('body');
            body.append(this.domParser.parseFromString('<div id="preloader"><div class="spinner"></div></div>', 'text/html').body.childNodes[0]);
        },
        hidePreloader() {
            document.querySelector('#preloader')?.remove();
        },
        selectMonth(idx) {
            this.currentMonth = idx;
        },
        fetchCountriesReport() {
            this.showPreloader();
            this.axios.get(`/api/report_countries/${this.currentMonth + 1}`).then((res) => {
                this.reportData = res.data;
                this.reportType = 'countries';
            }).finally(() => {
                this.hidePreloader();
            })
        },
        fetchCompaniesReport() {
            this.showPreloader();
            this.axios.get(`/api/report_companies/${this.currentMonth + 1}`).then((res) => {
                this.reportData = res.data;
                this.reportType = 'companies';
            }).finally(() => {
                this.hidePreloader();
            })
        },
        getCountries() {
            this.axios.get('/api/countries').then((response) => {
                this.countries = response.data;
            });
        },
        getCompanies() {
            this.axios.get('/api/companies').then((response) => {
                this.companies = response.data;
            });
        },
        refreshAll() {
            this.getCountries();
            this.getCompanies();
            this.reportType = false;
            this.reportData = false;
            this.countries = false;
            this.companies = false;
            this.currentMonth = moment().month();
        }
    }, mounted() {
        this.getCountries();
        this.getCompanies();

        this.domParser = new DOMParser();

        //MDB routine
        const dropDownEl = document.querySelector('.dropdown-toggle');
        const monthDropdown = new Dropdown(dropDownEl);
    }
}
</script>

<template>
    <h2 class="text-center">Leaders View for {{ monthsList[currentMonth] }}</h2>
    <div class="d-flex justify-content-center align-items-center">

        <div class="dropdown">
            <button
                class="btn btn-primary dropdown-toggle mr-2"
                type="button"
                id="dropdownMonths"
                data-mdb-dropdown-init
                data-mdb-ripple-init
                aria-expanded="false"
            >Months</button>
            <ul class="dropdown-menu months" aria-labelledby="dropdownMonths">
                <li v-for="(month, idx) in this.monthsList"><button class="dropdown-item" :id="idx" @click="selectMonth(idx)">{{ month }}</button></li>
            </ul>
        </div>

        <button @click="fetchCountriesReport" class="btn btn-success mr-2">Show report by Countries</button>
        <button @click="fetchCompaniesReport" class="btn btn-warning mr-2">Show report by Companies</button>
        <button @click="generate" class="btn btn-primary mr-2">Generate</button>
        <button @click="clear" class="btn btn-danger">Clear</button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Mined Total</td>
                    <td>Plan</td>
                </tr>
            </thead>
            <template v-if="this.reportType === 'countries'">
                <tbody>
                    <tr v-for="item in this.reportData">
                        <td>{{ item.name }}</td>
                        <td>{{ item.total }}</td>
                        <td>{{ item.plan }}</td>
                    </tr>
                </tbody>
            </template>
            <template v-else-if="this.reportType === 'companies'">
                <tbody v-for="(data, country_id) in this.reportData">
                    <tr>
                        <td colspan="3" class="text-center fw-bold">{{ countries[country_id].name }}</td>
                    </tr>
                    <tr v-for="company in data">
                        <td>{{ company.name }}</td>
                        <td>{{ company.total }}</td>
                        <td>{{ company.plan }}</td>
                    </tr>
                </tbody>
            </template>
            <tbody v-else-if="this.reportType === false">
                <tr><td colspan="3">No data</td></tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
