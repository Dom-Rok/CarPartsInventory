<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const page = usePage();

// Function to check if route is active
const isActive = (name: string) => {
    return page.url === route(name);
}
</script>


<style scoped lang="scss">
footer {

    position: relative;
    bottom: 0;
    left: 0;
    right: 0;
}

nav {
    padding-bottom: 3%;
}

.nav-link {
    font-size: 1.25rem;

    &:hover {
        transform: scale(1.05);
    }
}
</style>
<template>
    <div>
        <header>
            <nav>
                <div
                    class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start shadow-sm">
                    <div class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 ">
                        <Link :href="route('cars.index')" class="nav-link px-2 link-body-emphasis">Cars</Link>
                        <Link :href="route('parts.index')" class="nav-link px-2 link-body-emphasis "> Parts</Link>
                    </div>

                </div>
            </nav>
        </header>
    </div>
    <main class="container min-vh-100">
        <slot />
    </main>
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 m-4 border-top ">
        <div class="col-md-4 d-flex align-items-center fw-light fst-italic">Created by Dominik Rokošny</div>
        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <a href="https://github.com/Dom-Rok" target="_blank" class="btn btn-close-white">
               <i class="bi bi-github"></i>
            </a>
        </ul>
    </footer>

</template>
