<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps<{
    model: string
    id: number
}>()

</script>

<template>
    
    <div class="options">
        <Link class="btn btn-info btn-sm" :href="route(props.model + 's.edit', { [props.model]: props.id })"
            @click.stop>
            Edit
        </Link>
    </div>

</template>
