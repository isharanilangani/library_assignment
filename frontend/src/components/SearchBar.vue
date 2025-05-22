<template>
  <input type="text" v-model="search" @input="$emit('search', search)" placeholder="Search...">
</template>
<script setup>
import { ref } from 'vue';
const search = ref('');
</script>
