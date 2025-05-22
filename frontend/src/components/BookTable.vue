<template>
  <div>
    <SearchBar @search="fetchBooks" />
    <div v-if="books.length">
      <div v-for="book in books" :key="book.id" class="book-card">
        <h3>{{ book.title }}</h3>
        <p>{{ book.description }}</p>
        <button @click="borrow(book.id)">Borrow</button>
      </div>
    </div>
    <div>
      <button @click="page--" :disabled="page <= 1">Prev</button>
      <button @click="page++" :disabled="page >= lastPage">Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from '../axios';
import SearchBar from './SearchBar.vue';

const books = ref([]);
const page = ref(1);
const lastPage = ref(1);

async function fetchBooks(search = '') {
  const res = await axios.get('/books', { params: { page: page.value, search } });
  books.value = res.data.data;
  lastPage.value = res.data.last_page;
}

async function borrow(id) {
  await axios.post(`/books/${id}/borrow`);
  alert("Book borrowed!");
}

watch(page, () => fetchBooks());
fetchBooks();
</script>
