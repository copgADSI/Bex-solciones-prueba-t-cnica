<template>
    <section class="container shadow bg-primary rounded p-4 mt-4" id="new-visit-form">
        <form class="needs-validation" novalidate @submit.prevent="handleScheduleVisit">
            <!-- Basic Information Section -->
            <div class="form-group">
                <h6 class="text-white fw-bold mb-3">Basic Information</h6>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control bg-transparent text-light" id="customer-name"
                        placeholder="Customer Name" v-model="form.customer_name" required>
                    <label for="customer-name">Customer Name</label>
                    <div class="invalid-feedback">
                        <small class="text-danger">Please provide a valid customer name.</small>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control bg-transparent text-light" id="customer-email"
                        placeholder="Customer Email" v-model="form.customer_email" required>
                    <label for="customer-email">Customer Email</label>
                    <div class="invalid-feedback">
                        <small class="text-danger">Please provide a valid customer email.</small>
                    </div>
                </div>
            </div>

            <!-- Coordinates Section -->
            <div class="form-group">
                <h6 class="text-white fw-bold mb-3">Coordinates <small>(Latitude - Longitude)</small></h6>
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control bg-transparent text-light" id="latitude"
                                placeholder="Latitude" v-model="form.latitude" readonly required>
                            <label for="latitude">Latitude</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control bg-transparent text-light" id="longitude"
                                placeholder="Longitude" v-model="form.longitude" readonly required>
                            <label for="longitude">Longitude</label>
                        </div>
                    </div>
                </div>
                <div class="map-container">
                    <map-visit :lat="form.latitude" :lng="form.longitude" :onCoordinatesChange="updateCoordinates">
                    </map-visit>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-secondary" :disabled="isLoading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                        v-if="isLoading"></span>
                    <span v-else>Schedule Visit</span>
                </button>
            </div>
        </form>
    </section>
</template>

<script>
import { defineComponent, ref, watch } from 'vue';
import MapVisit from './MapVisit.vue';
import visitService from '../../services/visit';
import useNotificationToast from '../../hooks/useNotificationToast';
import { useQueryClient } from 'vue-query';

export default defineComponent({
    components: { MapVisit },
    props: {
        visit: {
            type: Object,
        }
    },
    name: 'NewVisitForm',
    setup(props) {
        const queryClient = useQueryClient();
        const notification = useNotificationToast();
        const isLoading = ref(false);
        const form = ref({
            customer_name: '',
            customer_email: '',
            latitude: 4.624335, //Bogotá :D
            longitude: -74.063644
        });

        watch(() => props.visit, (newVal) => {
            if (newVal) {
                form.value = newVal
            }
        })


        const updateCoordinates = (lat, lng) => {
            form.value.latitude = lat;
            form.value.longitude = lng;
        };

        const clearForm = () => {
            form.value = {
                customer_name: '',
                customer_email: '',
                latitude: 4.624335,
                longitude: -74.063644
            };
        };
        const handleSuccess = (response, message, toastId) => {
            if (response.data.saved) {
                clearForm();
                queryClient.invalidateQueries('visits');
                notification.toastUpdate(toastId, 'success', message);
            }
        };

        const handleError = (error, toastId) => {
            console.error('Error scheduling visit:', error);
            notification.toastUpdate(toastId, 'error', 'Error scheduling visit');
        };

        // Función para almacenar una visita
        const storeVisit = async () => {
            try {
                const toastId = notification.toastLoading('Saving visit...');
                const response = await visitService.store(form.value);
                handleSuccess(response, response.data.message, toastId);
            } catch (error) {
                handleError(error, toastId);
            } finally {
                isLoading.value = false;
            }
        };

        const updateVisit = async () => {
            try {
                const toastId = notification.toastLoading('Updating visit...');
                const response = await visitService.update(form.value);
                handleSuccess(response, response.data.message, toastId);
            } catch (error) {
                handleError(error, toastId);
            } finally {
                isLoading.value = false;
            }
        };

        // Manejar el agendamiento de la visita
        const handleScheduleVisit = async (event) => {
            if (!event.target.checkValidity()) {
                return event.target.classList.add('was-validated');
            }
            if (isLoading.value) return;

            isLoading.value = true;

            if (form.value?.id) {
                console.log('Update visit:', form.value);
                await updateVisit();
            } else {
                await storeVisit();
            }
        };



        return {
            form,
            updateCoordinates,
            handleScheduleVisit,
            isLoading,
        };
    }
});
</script>
