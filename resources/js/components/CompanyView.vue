<script>

import { ref } from 'vue';
import { Input, Modal, Ripple, initMDB } from "mdb-ui-kit";

initMDB({ Input, Modal, Ripple });

export default {
    setup() {
        const isAdd = false;
        const companies = ref(false);
        const countries = ref(false);
        const company = ref({
            id: '',
            name: '',
            email: '',
            country_id: ''
        });
        const companyModal = ref(false);
        const companyModalEl = ref(false);

        return {
            isAdd,
            companies,
            countries,
            company,
            companyModal,
            companyModalEl,
        }
    },
    methods: {
        showEditModal(uuid) {
            this.isAdd = false;
            this.getCompany(uuid);
            this.companyModal.show();
        },
        showAddModal() {
            this.isAdd = true;
            this.companyModal.show();
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
        getCompany(uuid) {
            this.axios.get(`/api/company/${uuid}`).then((response) => {
                this.company = response.data;
            });
        },
        saveCompany() {
            if (this.isAdd) {
                this.axios.post(`/api/companies`, this.company).finally(() => {
                    this.companyModal.hide();
                    this.getCompanies();
                });
            } else {
                this.axios.put(`/api/companies/${this.company.id}`, this.company).then((response) => {
                    this.company = response.data;
                }).finally(() => {
                    this.companyModal.hide();
                    this.getCompanies();
                });
            }
        },
        deleteCompany(uuid) {
            this.axios.delete(`/api/companies/${uuid}`).finally(() => {
                this.getCompanies();
            });
        }
    },
    mounted() {
        this.getCountries();
        this.getCompanies();

        this.companyModalEl = document.getElementById('companyModal');
        this.companyModalEl.addEventListener('hidden.mdb.modal', (e) => {
            this.isAdd = false;
            this.company.name = '';
            this.company.email = '';
            this.company.country_id = '';
        });

        this.companyModal = new Modal(this.companyModalEl);
    }
}
</script>

<template>
    <div class="d-flex justify-content-center align-items-center">
        <h2>Companies View</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody v-if="this.companies !== false">
            <tr v-for="companyItem in this.companies">
                <td>{{ companyItem.name }}</td>
                <td>{{ companyItem.email }}</td>
                <td>
                    <button class="btn btn-primary mr-2" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#companyModal" v-on:click="showEditModal(companyItem.id)">Edit</button>
                    <button class="btn btn-danger" data-mdb-ripple-init @click="deleteCompany(companyItem.id)">Delete</button>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td colspan="3">No results</td>
            </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            <button class="btn btn-primary mb-2" data-mdb-ripple-init @click="showAddModal">Add</button>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Edit Company</h5>
                    <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form>
                        <!-- Name input -->
                        <div data-mdb-input-init class="mb-4">
                            <label class="form-label" for="input-name">Name</label>
                            <input v-model="this.company.name" type="text" id="input-name" class="form-control" maxlength="255" required />
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="mb-4">
                            <label class="form-label" for="input-email">Email</label>
                            <input v-model="this.company.email" type="email" id="input-email" class="form-control" required />
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="input-country">Country</label>
                            <select v-model="this.company.country_id" id="input-country" class="select-input form-control" required >
                                <option v-for="country in this.countries" :value="country.id">{{ country.name }}</option>
                            </select>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveCompany" data-mdb-ripple-init>Save</button>
                </div>
            </div>
        </div>
    </div>

</template>
<style scoped>

</style>
