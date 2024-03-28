<script>

import { ref } from "vue";
import moment from "moment";
import { Dropdown, Ripple, initMDB } from "mdb-ui-kit";

initMDB({ Dropdown, Ripple });

export default {
    setup() {
        const reportMonth = ref(1);
        const reportData = ref(false);
        const isReportLoading = ref(false);
        const monthsList = ref(moment.months());
        return {
            reportMonth,
            isReportLoading,
            reportData,
            monthsList
        }
    },
    methods: {
        generate() {
            this.showPreloader();
            this.axios('/api/generate').finally(() => {
                this.hidePreloader();
            });
        },
        clear() {
            this.showPreloader();
            this.axios('/api/clear').finally(() => {
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
        selectMonth() {

        }
    }, mounted() {
        this.domParser = new DOMParser();

        //MDB routine
        const dropDownEl = document.querySelector('.dropdown-toggle');
        const dropdown = new Dropdown(dropDownEl);
    }
}
</script>

<template>
    <h2 class="text-center">Leaders View</h2>
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
            <ul class="dropdown-menu" aria-labelledby="dropdownMonths">
                <li v-for="(month, idx) in this.monthsList"><button class="dropdown-item" @click="selectMonth(idx)">{{ month }}</button></li>
            </ul>
        </div>

        <button @click="generate" class="btn btn-primary mr-2">Generate</button>
        <button @click="clear" class="btn btn-danger">Clear</button>
    </div>
</template>

<style scoped>

</style>
