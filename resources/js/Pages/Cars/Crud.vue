<script setup lang="ts">
import { Car } from '@/types/types';
import { InertiaForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';
import InputForm from '@/components/Cars/InputForm.vue';
import FormCard from '@/components/FormCard.vue';



const props = defineProps<{
  mode: 'Insert' | 'Update' | 'View'
  car?: Car
}>();
const title = computed(() => {
  switch (props.mode) {
    case 'Insert':
      return 'Create Car'

    case 'Update':
      return 'Edit Car'

    case 'View':
      return 'Car Details'

    default:
      return ''
  }
})
const isPreview = props.mode === 'View';

const handleSubmit = (form: InertiaForm<any>) => {
  switch (props.mode) {
    case 'Insert':
      form.post(route('cars.store'))
      break

    case 'Update':
      if (!props.car?.id) return
      form.put(route('cars.update', { car: props.car.id }))
      break

    case 'View':
      // Do nothing in preview mode
      break
  }
}
</script>

<template>
  <FormCard>
    <InputForm :car="props.car" :submit-handler="handleSubmit" :is-preview="isPreview" />

  </FormCard>

  <!-- todo show parts for each car in view/edit mode-->
</template>
