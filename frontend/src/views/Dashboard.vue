<template>
<Sidebar/>

<div class=" h-full w-full">
    <div v-for="(module, index) in moduleStore.modules" :key="index">
        {{ module.name }}
    </div>
</div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue';
import { useModulesStore } from '@/stores/modulesStore';

const moduleStore = useModulesStore()

onMounted(() => {
    moduleStore.getAll()
})
</script>