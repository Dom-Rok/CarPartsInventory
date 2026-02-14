<script setup lang="ts">
import { Car, Part } from '@/types/types';
import { InertiaForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';
import InputForm from '@/components/Parts/InputForm.vue';
import FormCard from '@/components/FormCard.vue';



const props = defineProps<{
  mode: 'Insert' | 'Update' | 'View',
  part?: Part,
  cars?: Car[]
}>();
const title = computed(() => {
  switch (props.mode) {
    case 'Insert':
      return 'Create Part'

    case 'Update':
      return 'Edit Part'

    case 'View':
      return 'Part Details'

    default:
      return 'nic'
  }
})
const isPreview = props.mode === 'View';

const handleSubmit = (form: InertiaForm<any>) => {
  switch (props.mode) {
    case 'Insert':
      form.post(route('parts.store'))
      break

    case 'Update':
      if (!props.part?.id) return
      form.put(route('parts.update', { part: props.part.id }))
      break

    case 'View':
      // Do nothing in preview mode
      break
  }
}
</script>

<template>
  <h2> {{ title }} </h2>
  <FormCard>
    <InputForm :part="props.part" :cars="props.cars" :submit-handler="handleSubmit" :is-preview="isPreview" />

  </FormCard>
</template>
