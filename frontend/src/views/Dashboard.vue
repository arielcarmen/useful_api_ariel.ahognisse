<template>
    <div class="flex flex-row h-screen">
        <Sidebar :modules="moduleStore.modules" />

        <div class=" h-full w-full">
            <Module v-for="(module, index) in moduleStore.modules" :key="index" :module="module"
                @toggle="moduleStore.toggleActive(module.id, module.active)" />
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue';
import Module from '@/components/Module.vue';
import { useModulesStore } from '@/stores/modulesStore';
import { onMounted } from 'vue';

const moduleStore = useModulesStore()
onMounted(() => {
    moduleStore.getAll()
})
</script>