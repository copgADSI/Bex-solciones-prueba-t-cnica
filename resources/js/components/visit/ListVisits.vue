<template>
    <actions @toggleNewVisitForm="(value) => {
        showVisitForm = value
        visit = null
    }" />
    <div class="container-fluid p-0">
        <div class="row">
            <!-- Main Content -->
            <transition name="resize">
                <div :class="{ 'col-md-6': showVisitForm, 'col-md-12': !showVisitForm }" key="main-content">
                    <div class="row">
                        <div class="my-3" v-if="isLoading || isFetching">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            <span>Loading visits...</span>
                        </div>
                        <div class="text-center my-4" v-if="!visits?.length">
                            <span class="text-white">No visits found</span>
                        </div>
                        <div v-for="(visit, index) in visits" :key="visit.id"
                            :class="{ 'col-12': showVisitForm, 'col-md-6 col-sm-12': !showVisitForm }">
                            <single-visit
                                :visit="visit"
                                @action="({ type, visit }) => handleAction({ type, visit, index })"
                                @showVisit="showVisit"
                            >
                            </single-visit>
                        </div>
                    </div>
                    <!-- prev and next -->
                    <div class="d-flex justify-content-start">
                        <!-- <button class="btn btn-secondary me-1" @click="fetchPreviousPage">Show Less</button> -->
                        <button class="btn btn-primary" @click="fetchNextPage" :disabled="!hasNextPage" v-if="hasNextPage">
                            Show More
                        </button>
                    </div>
                </div>
            </transition>

            <!-- Visit Form -->
            <transition name="fade">
                <div v-if="showVisitForm" v-bind:class="{'col-12': !visits?.length, 'col-md-6 col-sm-12': visits?.length}" key="visit-form">
                    <new-visit-form :visit="visit" />
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import Actions from './Actions.vue';
import NewVisitForm from './NewVisitForm.vue';
import SingleVisit from './SingleVisit.vue';
import visitService from '../../services/visit';
import { useInfiniteQuery } from 'vue-query';
import useNotificationToast from '../../hooks/useNotificationToast';

function useVisitsInfiniteQuery() {
    return useInfiniteQuery("visits",
        ({ pageParam = 1 }) => visitService.fetch(pageParam),
        {
            getNextPageParam: ({ data }) => {
                const lastPage = data
                return lastPage.next_page_url ? lastPage.current_page + 1 : undefined
            },
            select: (data) => {
                return data.pages.flatMap(({ data: page }) => page.data);
            },
            retry: 3,
            retryDelay: 1000,
            refetchOnWindowFocus: false,
            refetchOnReconnect: false,
            refetchInterval: false,

        });
}

export default defineComponent({
    components: { SingleVisit, Actions, NewVisitForm },
    name: 'ListVisits',
    setup() {
        const notification = useNotificationToast();
        const showVisitForm = ref(false);
        const visit = ref(null)

        const showVisit = (value) => {
            showVisitForm.value = true
            visit.value = value
        }

        const handleAction = ({ type, visit, index }) => {
            const actions = {
                edit: () => {
                    visit.value = visit
                    showVisitForm.value = true
                },
                delete: () => {
                    const toastId = notification.toastLoading('Deleting visit...')
                    visitService.destroy(visit.id).then(({ data }) => {
                        console.log('index', index);
                        visits.value.splice(index, 1)
                        if (data.deleted) {
                            notification.toastUpdate(toastId, 'success', data.message)
                            showVisitForm.value = false
                            visit.value = null
                        }
                    }).catch((error) => {
                        console.log(error)
                        notification.toastUpdate(toastId, 'error', 'Error deleting visit')
                    })
                },
                show: () => {
                    showVisit(visit)
                }
            }

            actions[type] ? actions[type]() : null
        }

        const {
            data: visits,
            isLoading,
            isFetching,
            fetchNextPage,
            hasNextPage,
            fetchPreviousPage
        } = useVisitsInfiniteQuery();

        return {
            showVisitForm,
            visits,
            showVisit,
            visit,
            handleAction,

            isFetching,
            isLoading,
            fetchPreviousPage,
            fetchNextPage,
            hasNextPage,
        };
    }
});
</script>
