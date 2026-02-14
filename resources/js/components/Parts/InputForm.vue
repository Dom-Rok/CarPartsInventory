<!-- Form for creating / updating parts -->
<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3';
import { Car, Part } from '@/types/types';
import { route } from 'ziggy-js';

const props = defineProps<{
  part?: Part,
  cars?: Car[],
  submitHandler: Function,
  isPreview?: boolean

}>();
const part = props.part ?? ({} as Part)
const cars = props.cars ?? []
const form = useForm({
  name: part.name ?? '',
  serialnumber: part.serialnumber ?? '',
  car_id: part.car_id ?? 0
})

const onSubmit = () => {
  props.submitHandler(form);
}


function destroy() {
  if (!confirm('Are you sure you want to delete this item?')) {
    return
  }
  router.delete(route('parts.destroy', props.part?.id))
}
</script>
<template>
  <form @submit.prevent="onSubmit">
    <!--name-->
    <div class="mb-3 form-group">
      <label class="form-label fw-semibold">Part Name <span class="text-danger">*</span></label>
      <input v-model="form.name" type="text" class="form-control" placeholder="Enter part name"
        :class="{ 'is-invalid': form.errors.name }" required :disabled="isPreview" />
    <div v-if="form.errors.name" class="invalid-feedback">
      {{ form.errors.name }}
    </div>
      </div>


    <!--serial no.-->
    <div class="mb-3 form-group">
      <label class="form-label fw-semibold">Serial Number <span class="text-danger">*</span></label>
      <input v-model="form.serialnumber" type="text" class="form-control" placeholder="Enter serial number" required
          :class="{ 'is-invalid': form.errors.serialnumber }"
        :disabled="isPreview" />
    <div v-if="form.errors.serialnumber" class="invalid-feedback">
    {{ form.errors.serialnumber }}
  </div>
      </div>


    <!--car select-->
    <div v-if="!isPreview" class="mb-3 form-group">
      <label class="form-label fw-semibold">Select Car <span class="text-danger">*</span></label>
      <select v-model.number="form.car_id" class="form-select" :disabled="isPreview" required>
        <option value="0" >Select a car</option>

        <option v-for="car in cars" :key="car.id" :value="car.id">
          {{ car.name }}
        </option>
      </select>
    </div>
    <div v-else class="mb-3 form-group">

      <label class="form-label">Serial Number</label>
      <input v-model="part.car.name" type="text" class="form-control" disabled />
    </div>
    <div v-if="form.errors.car_id" class="invalid-feedback">
      {{ form.errors.car_id }}
    </div>

    <!--save btn-->
    <div class="d-flex gap-3 mt-4 pt-3 border-top" v-if="!isPreview">
      <button type="submit" class="btn btn-primary btn-lg px-4" :disabled="form.processing">
        <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
        {{ props.part ? 'Update' : 'Create' }}
      </button>
  
      <button v-if="props.part" type="button" class="btn btn-outline-danger btn-lg px-4" @click.prevent="destroy">
        Delete
      </button>
    </div>
  </form>

</template>
