<template>
  <main class="container">
    <h1>Online Library</h1>
    <BookTable />
    <BorrowedBooks />
  </main>
</template>

<script setup>
import BookTable from './components/BookTable.vue';
import BorrowedBooks from './components/BorrowedBooks.vue';
</script>

<style>
.container {
  max-width: 800px;
  margin: auto;
  padding: 1rem;
}
</style>
