<script setup lang="ts">
import NoResults from '@/components/NoResults.vue';
import { Car, Part } from '@/types/types';
import { computed, ref, watch } from 'vue';
import { debounce, initial } from 'lodash-es';
import { route } from 'ziggy-js';
import { Link, router, usePage } from '@inertiajs/vue3';
import PageSelector from '@/components/PageSelector.vue';
import EditBtn from '@/components/EditBtn.vue';
import { PageProps } from '@/types/inertia';
import FlashMessageNotification from '@/components/FlashMessageNotification.vue';
import GlobalLayout from '@/Layouts/GlobalLayout.vue';

defineOptions({ layout: GlobalLayout });

const { flash } = usePage<PageProps>().props
const { cars, paginated, initialPartName, initialSelectedCars } = defineProps<{
    cars: Car[];
    paginated:
    {
        data: Part[],
        links: Array<{ url: string | null, label: string, active: boolean }>,
        current_page: number,
        last_page: number,
        per_page: number,
        total: number
    }, initialPartName?: string;
    initialSelectedCars?: number[]; // car IDs from search
}>();

const parts = computed(() => paginated.data as Part[]);
const partName = ref(initialPartName || '');
const selectedCars = ref<number[]>([]);

const selectedCarNames = computed(() => {
    return cars
        .filter(car => selectedCars.value.includes(car.id))
        .map(car => car.name);
});


//search with delay 
const sendSearch = debounce(() => {
    router.get(route('parts.index'), {
        part_name: partName.value,
        cars: selectedCars.value,
    }, {
        preserveState: true,
        replace: true,
    })
}, 300)
watch([partName, selectedCars], () => {
    sendSearch()
})

function resetFilter() {
    partName.value = ''
    selectedCars.value = []
}

//tels whether parts are not returnet because search query was not found or bc nothing is in 
const isPartsDbEmpty = computed(() => {
 
  return parts.value.length || (initialPartName || ((initialSelectedCars?.length)))
})

</script>

<template>
    <FlashMessageNotification :flash="flash" />

    <h1>My parts</h1>
    <div v-if="isPartsDbEmpty">
        <div class="col-12">

            <div class="filter mb-3 container">
                <!-- Row 1: Search Input -->
                <div class="row mb-3">
                    <div class="">
                        <input v-model="partName" type="text" placeholder="Search part name..." class="form-control" />
                    </div>
                </div>

                <!-- Row 2: Car Model Dropdown -->
                <div class="row mb-3">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label fw-semibold">Please choose car model</label>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                data-bs-toggle="dropdown">
                                Select cars
                            </button>
                            <ul class="dropdown-menu p-2 w-100">
                                <li v-for="car in cars" :key="car.id" class="dropdown-item-text">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" :value="car.id"
                                            v-model="selectedCars" :id="'car-' + car.id" />
                                        <label class="form-check-label" :for="'car-' + car.id">
                                            {{ car.name }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Selected Cars Display -->
                <div class="row mb-3" v-if="selectedCars.length !== 0">
                    <div class="col-12">
                        <div class="alert alert-info py-2 ">
                            <strong class="bg-transparent">Selected Cars:</strong>
                            <span class="ms-2 bg-transparent">{{ selectedCarNames.join(', ') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Action Buttons -->
                <div class="row">
                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary">Search</button>
                        <button class="btn btn-outline-danger" @click="resetFilter">Reset filter</button>
                        <Link class="btn btn-success ms-auto" :href="route('parts.create')">New Part</Link>

                    </div>
                </div>
            </div>

        </div>
        <div class="content">
            <table v-if="parts.length" class="table">
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th> Serial NO.</th>
                        <th> For car</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="part in parts" @click="$inertia.visit(route('parts.show', { part: part.id }))"
                        style="cursor: pointer;">
                        <td class="fw-semibold"> {{ part.name }}</td>
                        <td> {{ part.serialnumber }}</td>
                        <td> {{ part.car.name }}</td>
                        <td>
                            <EditBtn :model="'part'" :id="part.id" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--if empty parts result while filtering -->
            <NoResults v-if="parts.length == 0 && (initialPartName ||  initialSelectedCars?.length)" />
            <PageSelector :paginated="paginated" />

        </div>

    </div>
    <div v-else class="d-flex justify-content-center">
        <h1> No existing parts</h1>
    </div>

</template>
