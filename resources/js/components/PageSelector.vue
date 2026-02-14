<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Link {
  url: string | null;
  label: string;
  active: boolean;
}

// Tell Vue that `links` is an array of `Link`
const { paginated } = defineProps<{
  paginated: {
    links: Array<{ url: string | null, label: string, active: boolean }>,
    current_page: number,
    last_page: number,
    per_page: number,
    total: number
  },
}>
  ();

const currentPage = computed(() => paginated.current_page);
const perPage = computed(() => paginated.per_page);
const total = computed(() => paginated.total);


const startIndex = computed(() => {
  if (total.value === 0) return 0;
  return (currentPage.value - 1) * perPage.value + 1;
});

const endIndex = computed(() => {
  const possibleEnd = currentPage.value * perPage.value;
  return possibleEnd > total.value ? total.value : possibleEnd;
});
</script>


<template>

  <!-- if one page only dont render -->
  <div class="pagination-summary ">
    <p>Showing <span class="fw-bold"> {{ startIndex }}–{{ endIndex }} </span> of <span class="fw-bold">{{ total
        }}</span> cars</p>
  </div>

  <div v-if="paginated.links.length > 3" class="pagination d-flex">


    <!--filter empty previous / next links -->
    <Link v-for="link in paginated.links.filter(link => link.url)" :key="link.label" :href="link.url ?? '#'"
      class="page-item text-decoration-none" :class="{ 'active': link.active }">
      <span class=" page-link text-decoration-non" v-html="link.label"></span>
    </Link>
  </div>
</template>