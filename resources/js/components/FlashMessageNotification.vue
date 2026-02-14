<script setup lang="ts">
import { FlashProps } from '@/types/inertia';

defineProps<{
  flash: FlashProps
}>()

</script>


<template>
  <div>
    <!-- Success message -->
    <div v-if="flash.success" class="alert alert-success">
      {{ flash.success }}
    </div>

    <!-- Error message -->
    <div v-if="flash.error" class="alert alert-danger">
      {{ flash.error }}
    </div>
  </div>

</template>