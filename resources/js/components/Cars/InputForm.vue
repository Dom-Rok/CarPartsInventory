<!-- 
 Template for insert, update, and preview of car model  

 
-->
<script setup lang="ts">
import { Car } from '@/types/types';
import { router, useForm } from '@inertiajs/vue3';

import { route } from 'ziggy-js';

const props = defineProps<{
    /**  Initial car data (empty object for insert, car object for update/preview) */
    car?: Car,

    submitHandler?: Function,

    /** if true fields in read only mode */
    isPreview?: boolean
}>();

const form = useForm({
    name: props.car?.name ?? '',
    registration_number: props.car?.registration_number ?? '',
    is_registered: Boolean(props.car?.is_registered) ?? false
})

const onSubmit = () => {
    if (props.submitHandler) {
        console.log(form)
        props.submitHandler(form);
    }
}

function destroy() {
    if (!confirm('Are you sure you want to delete this item?')) {
        return
    }
    router.delete(route('cars.destroy', props.car?.id))
}
</script>



<template>
    <form @submit.prevent="onSubmit">
        <!-- Car Model -->
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Car model <span class="text-danger">*</span>
            </label>
            <input v-model="form.name" type="text" class="form-control form-control-lg"
                :class="{ 'is-invalid': form.errors.name }" :disabled="isPreview" placeholder="Enter car model" />
            <div v-if="form.errors.name" class="invalid-feedback">
                {{ form.errors.name }}
            </div>
        </div>

        <!-- Registered Checkbox -->
        <div class="mb-4">
            <div class="form-check form-switch">
                <input v-model="form.is_registered" type="checkbox" class="form-check-input" id="is_registered"
                    :disabled="isPreview" />
                <label class="form-check-label fw-medium" for="is_registered">
                    Registered vehicle
                </label>
            </div>
        </div>

        <!-- Registration Number -->
        <div class="mb-4" v-if="form.is_registered">

            <label class="form-label fw-semibold">Registration number</label>
            <input v-model="form.registration_number"
                @input="form.registration_number = form.registration_number.toUpperCase()" type="text"
                class="form-control" :class="{ 'is-invalid': form.errors.registration_number }" :disabled="isPreview"
                placeholder="AA123AA" />
            <div v-if="form.errors.registration_number" class="invalid-feedback">
                {{ form.errors.registration_number }}
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 mt-4 pt-3 border-top" v-if="!isPreview">
            <button type="submit" class="btn btn-primary btn-lg px-4" :disabled="form.processing">
                <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                {{ car ? 'Update' : 'Create' }}
            </button>

            <button v-if="car" type="button" class="btn btn-outline-danger btn-lg px-4" @click.prevent="destroy">
                Delete
            </button>
        </div>
    </form>
</template>
