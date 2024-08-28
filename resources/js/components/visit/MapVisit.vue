<template>
    <main>
        <l-map ref="map" v-model:zoom="zoom" v-model:center="center" :useGlobalLeaflet="false" @click="onMapClick">
            <l-tile-layer :url="url" layer-type="base" name="Stadia Maps Basemap"></l-tile-layer>
            <l-marker v-if="lat && lng" :lat-lng="[lat, lng]"></l-marker>
            <l-marker v-for="(visit, index) in visits" :key="index" :lat-lng="[visit.latitude, visit.longitude]" @click="flyToVisit(visit)">
                <l-popup>
                    <span class="text-primary">
                        Customer Name: <b class="text-primary">{{ visit.customer_name }}</b>
                    </span>
                    <br>
                    <span class="text-primary">
                        Customer Email: <b class="text-primary">{{ visit.customer_email }}</b>
                    </span>
                </l-popup>
            </l-marker>
        </l-map>
        <div class="search-container">
            <input type="text" v-model="searchQuery" @input="searchLocation" placeholder="Search for a location..." />
        </div>
        <div class="visits-list-container bg-primary card rounded" v-if="visits && visits.length">
            <div class="card-body p-0">
                <ul class="list-unstyled w-100">
                    <li role="button" class="w-100 p-2" v-bind:class="{'shadow border rounded-2': visit.id === selectedVisit?.id}" v-for="visit in visits" :key="visit.id">
                        <a href="#" class="text-white text-decoration-none" @click="flyToVisit(visit)">
                            {{ visit.customer_name }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </main>
</template>

<script>
import { defineComponent, ref } from 'vue';
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";

export default defineComponent({
    name: 'MapVisit',
    emits: ['setDefaultCoordinates'],
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup
    },
    props: {
        lat: {
            type: Number,
            default: null
        },
        lng: {
            type: Number,
            default: null
        },
        visits: {
            type: Array,
            required: false,
            default: () => []
        },
        onCoordinatesChange: {
            type: Function,
            required: false,
        }
    },
    setup(props) {
        const selectedVisit = ref(null);
        const url = ref('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png');
        const zoom = ref(6);
        const center = ref([props.lat || 4.7110, props.lng || -74.0721]); // Default to Bogotá coordinates
        const searchQuery = ref('');

        const updateCoordinates = (lat, lng) => {
            if (props.onCoordinatesChange) {
                props.onCoordinatesChange(lat, lng);
            }
            center.value = [lat, lng];
        };

        const onMapClick = (event) => {
            const { lat, lng } = event.latlng;
            updateCoordinates(lat, lng);
        };

        const searchLocation = async () => {
            if (searchQuery.value.trim() === '') return;

            const encodedQuery = encodeURIComponent(searchQuery.value);
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodedQuery}`;

            try {
                const response = await fetch(url);
                const data = await response.json();
                if (data.length > 0) {
                    const { lat, lon } = data[0];
                    updateCoordinates(parseFloat(lat), parseFloat(lon));
                }
            } catch (error) {
                console.error('Error fetching location:', error);
            }
        };

        const flyToVisit = (visit) => {
            selectedVisit.value = visit;
            center.value = [visit.latitude, visit.longitude];
            zoom.value = 15;
        };

        return {
            url,
            zoom,
            center,
            searchQuery,
            onMapClick,
            searchLocation,
            flyToVisit,
            selectedVisit,
        };
    }
});
</script>
