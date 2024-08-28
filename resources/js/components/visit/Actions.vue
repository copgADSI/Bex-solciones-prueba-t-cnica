<template>
    <div class="btn-group w-100">
        <button class="btn btn-primary" @click="toggleNewVisitForm">Create visit</button>
        <a href="/visits/on-map" class="btn btn-primary">All visits on map</a>
    </div>
</template>
<script>
import { defineComponent, ref } from 'vue';

export default defineComponent({
    name: 'Actions',
    emits: ['toggleNewVisitForm'],
    setup(props, context) {
        const showVisitForm = ref(false);
        const toggleNewVisitForm = () => {
            showVisitForm.value = !showVisitForm.value
            context.emit('toggleNewVisitForm', showVisitForm.value)
        }

        return {
            showVisitForm,
            toggleNewVisitForm
        }
    }
})
</script>
