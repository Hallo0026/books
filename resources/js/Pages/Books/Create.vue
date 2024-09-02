<script setup>

import { useForm } from '@inertiajs/vue3'

const props = defineProps(['authors']);

const newBook = useForm({
    title: "",
    published_year: "",
    genre: "",
    author_id: "",
});

function addBook() {

    newBook.post('/books', {
        onSuccess: () => {
            newBook.reset();
        },
        onError: () => {
            console.log(newBook.errors);
        }
    });
};

</script>

<template>
    <div>
      <h1>Criar Novo Livro</h1>
      <form @submit.prevent="addBook()">
        <div class="form-group">
          <label for="title">Título:</label>
          <input v-model="newBook.title" type="text" id="title" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="published_year">Ano de Publicação:</label>
          <input v-model="newBook.published_year" type="number" id="published_year" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="genre">Gênero:</label>
          <input v-model="newBook.genre" type="text" id="genre" class="form-control">
        </div>
        <div class="form-group">
          <label for="author_id">Autor:</label>
          <select v-model="newBook.author_id" id="author_id" class="form-control">
            <option v-for="author in authors" :key="author.id" :value="author.id">
              {{ author.name }}
            </option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="newBook.processing">Salvar Livro</button>


        <progress v-if="newBook.progress" :value="newBook.progress.percentage" max="100">
            {{ newBook.progress.percentage }}%
        </progress>

      </form>
    </div>
</template>