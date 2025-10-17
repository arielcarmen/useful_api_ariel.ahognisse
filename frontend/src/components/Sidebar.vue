<template>
<div class="bg-blue-500 p-2">
    <h2>Modules</h2>
<SidebarItem v-for="(module, index) in props.modules" :key="index" :module="module" v-show="module.active"/>
</div>
</template>

<script setup>
import SidebarItem from './SidebarItem.vue';
const props = defineProps({
    modules: {
        type: Array,
        required: true
    }
})
</script>