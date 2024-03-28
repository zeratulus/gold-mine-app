<script>

import { ref } from 'vue';
import { Input, Modal, Ripple, initMDB } from "mdb-ui-kit";

initMDB({ Input, Modal, Ripple });

export default {
    setup() {
        const isAdd = false;
        const countries = ref(false);
        const country = ref({
            id: '',
            name: '',
            plan: 100,
            weight_unit: 'g'
        });
        const editModal = ref(false);
        const editModalEl = ref(false);

        return {
            isAdd,
            countries,
            country,
            editModal,
            editModalEl,
        }
    },
    methods: {
        showEditModal(uuid) {
            this.isAdd = false;
            this.getCountry(uuid);
            this.editModal.show();
        },
        showAddModal() {
            this.isAdd = true;
            this.editModal.show();
        },
        getCountries() {
            this.axios.get('/api/countries').then((response) => {
                this.countries = response.data;
            });
        },
        getCountry(uuid) {
            this.axios.get(`/api/country/${uuid}`).then((response) => {
                this.country = response.data;
            });
        },
        saveCountry() {
            if (this.isAdd) {
                this.axios.post(`/api/country`, this.country).finally(() => {
                    this.editModal.hide();
                    this.getCountries();
                });
            } else {
                this.axios.put(`/api/country/${this.country.id}`, this.country).then((response) => {
                    this.country = response.data;
                }).finally(() => {
                    this.editModal.hide();
                    this.getCountries();
                });
            }
        },
        deleteCountry(uuid) {
            this.axios.delete(`/api/country/${uuid}`).finally(() => {
                this.getCountries();
            });
        }
    },
    mounted() {
        this.getCountries();

        //MDB routine
        this.editModalEl = document.getElementById('countryEditModal');
        this.editModalEl.addEventListener('hidden.mdb.modal', (e) => {
            this.isAdd = false;
            this.country.name = '';
            this.country.plan = 1;
            this.country.weight_unit = 'g';
        });

        this.editModal = new Modal(this.editModalEl);
    }
}
</script>

<template>
    <div class="d-flex justify-content-center align-items-center">
        <h2>Countries View</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Plan</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody v-if="this.countries !== false">
                <tr v-for="countryItem in this.countries">
                    <td>{{ countryItem.name }}</td>
                    <td>{{ countryItem.plan }}</td>
                    <td>
                        <button class="btn btn-primary mr-2" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#countryEditModal" v-on:click="showEditModal(countryItem.id)">Edit</button>
                        <button class="btn btn-danger" data-mdb-ripple-init @click="deleteCountry(countryItem.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                   <td colspan="3">No results</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <button class="btn btn-primary ml-2" data-mdb-ripple-init @click="showAddModal">Add</button>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="countryEditModal" tabindex="-1" aria-labelledby="countryEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="countryEditModalLabel">Edit Country</h5>
                    <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form>
                        <!-- Name input -->
                        <div data-mdb-input-init class="mb-4">
                            <label class="form-label" for="input-name">Name</label>
                            <input v-model="this.country.name" type="text" id="input-name" class="form-control" maxlength="255" required />
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="mb-4">
                            <label class="form-label" for="input-plan">Plan in grams</label>
                            <input v-model="this.country.plan" type="number" id="input-plan" class="form-control" min="100" step="100" max="10000000" required />
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveCountry()" data-mdb-ripple-init>Save</button>
                </div>
            </div>
        </div>
    </div>

</template>
<style scoped>

</style>
