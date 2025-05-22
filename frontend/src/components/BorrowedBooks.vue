<template>
  <div>
    <h2>Borrowed Books</h2>
    <ul>
      <li v-for="book in borrowed" :key="book.id">
        {{ book.title }}
        <button @click="returnBook(book.id)">Return</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../axios';

const borrowed = ref([]);

async function getBorrowed() {
  const res = await axios.get('/books/borrowed');
  borrowed.value = res.data;
}

async function returnBook(id) {
  await axios.post(`/books/${id}/return`);
  getBorrowed();
}

onMounted(getBorrowed);
</script>
