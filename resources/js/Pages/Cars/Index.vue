<script lang="ts" setup>
import { Car } from '@/types/types';
import { Link, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';
import { usePage } from '@inertiajs/vue3'
import { PageProps } from '@/types/inertia';
import { debounce } from 'lodash-es';
import PageSelector from '@/components/PageSelector.vue';
import FlashMessageNotification from '@/components/FlashMessageNotification.vue';

import EditBtn from '@/components/EditBtn.vue';
import NoResults from '@/components/NoResults.vue';

const { flash } = usePage<PageProps>().props


const { paginated, search } = defineProps<{
  paginated: {
    data: Car[],
    links: Array<{ url: string | null, label: string, active: boolean }>,
    current_page: number,
    last_page: number,
    per_page: number,
    total: number
  },
  search?: string | null
}>()
const cars = computed(() => paginated.data as Car[]);
const searchTerm = ref(search || '');


//search with delay 
const sendSearch = debounce((val: string) => {
  router.get(route('cars.index'), { search: val }, {
    preserveState: true,
    replace: true,
  });
}, 300);

watch(searchTerm, (val) => {
  sendSearch(val);
});
</script>

<template>
  <h1>My Cars
  </h1>

  <FlashMessageNotification :flash="flash" />

  <div v-if="cars.length || searchTerm">
    <div class="mb-3 d-flex flex-column flex-sm-row gap-2">
    <input v-model="searchTerm" type="text" class="form-control me-2 " placeholder="Search by model name" />

    <button class="btn btn-primary">Search</button>
  </div>
  <div class="d-flex flex-column  flex-sm-row gap-3 justify-content-center ">
    <Link :href="route('cars.create')" class="btn btn-success"> Create new</Link>

  </div>

    <table v-if="cars.length" class="table table-stripped mt-3">
      <thead>
        <tr>
          <th>Model</th>
          <th>Registration number</th>
          <th></th>

        </tr>

      </thead>
      <tbody>
        <tr v-for="car in cars" :key="car.id" @click="$inertia.visit(route('cars.show', { car: car.id }))"
          style="cursor: pointer;">
          <td class="fw-semibold">{{ car.name }}</td>
          <td> {{ car.registration_number || 'not registered' }}</td>
          <td>
            <EditBtn :model="'car'" :id="car.id" />
          </td>
        </tr>

      </tbody>
    </table>
    <!--if empty parts result while filtering -->
    <NoResults v-if="cars.length == 0 && (searchTerm)" />
    <PageSelector :paginated="paginated" />
  </div>
  <div v-else class=" d-flex justify-content-center gap-5">
    <h1> No existing cars</h1>
  </div>

  

</template>