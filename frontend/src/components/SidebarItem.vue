<template>
<div class=" pb-2 rounded-lg bg-blue-800 text-white mb-2">
    <p>{{ props.module.name }}</p>
</div>
</template>

<script setup>
const props = defineProps({
    module: {
        type: Object,
        required: true
    }
})
</script>