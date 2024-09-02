<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3'

const props = defineProps(['book', 'authors']);

const bookForm = useForm({ ...props.book });

function updateBook() {
    bookForm.put(`/books/${bookForm.id}`, {
        onError: () => {
            console.log(bookForm.errors);
        }
    });
}

</script>

<template>
    <div>
      <h1>Editar Livro</h1>
      <form @submit.prevent="updateBook()">
        <div class="form-group">
          <label for="title">Título:</label>
          <input v-model="bookForm.title" type="text" id="title" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="published_year">Ano de Publicação:</label>
          <input v-model="bookForm.published_year" type="number" id="published_year" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="genre">Gênero:</label>
          <input v-model="bookForm.genre" type="text" id="genre" class="form-control">
        </div>
        <div class="form-group">
          <label for="author_id">Autor:</label>
          <select v-model="bookForm.author_id" id="author_id" class="form-control" required>
            <option v-for="author in authors" :key="author.id" :value="author.id">
              {{ author.name }}
            </option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="bookForm.processing">Salvar Alterações</button>
      </form>
    </div>
</template>    
  