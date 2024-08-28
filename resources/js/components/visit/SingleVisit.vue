<template>
    <div class="card text-white shadow rounded my-4 p-4 bg-primary" role="button" @click="$emit('action', { type: 'show', visit })">
        <div class="position-absolute top-0 end-0">
            <button class="btn btn-sm btn-transparent" @click="$emit('action', { type: 'edit', visit })">
                <i class="fas fa-pen"></i>
            </button>
            <button class="btn btn-sm btn-transparent" @click="$emit('action', { type: 'delete', visit })">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <span class="fs-3">Customer information</span>
        <div class="my-4">
            <span class="fw-bolder">
                Customer name:
                <b>{{ visit.customer_name }}</b>
            </span><br>
            <span class="fw-bolder">
                Customer email:
                <b>{{ visit.customer_email }}</b>
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <small>
                Coordinates:
                {{ visit.latitude }}, {{ visit.longitude }}
            </small>
            <small>
                Created at:
                {{ formattedDate() }}
            </small>
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'SingleVisit',
    emits: ['action'],
    props: {
        visit: Object
    },
    setup(props) {

        const formattedDate = () => {
            return new Date(props.visit.created_at).toLocaleString();
        };

        return {
            formattedDate
        }
    }
})
</script>
