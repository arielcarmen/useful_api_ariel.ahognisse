<template>
<div class=" rounded-lg p-2 flex flex-row">
    <p>{{ props.module.name }}</p>
    <p>{{ props.module.description }}</p>
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