<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3'


const props = defineProps(['books']);

console.log(props.books);

function deleteBook(id) {
    if (confirm('Tem certeza que deseja excluir este livro?')) {
        router.delete(`/books/${id}`);
    }
}

</script>

<template>
    
    <AuthenticatedLayout>

        <h1>Livros</h1>

        <a href="/books/create" class="btn btn-primary">Adicionar Novo Livro</a>

        <table v-if="books.length" class="table">
            <thead>
            <tr>
                <th>Título</th>
                <th>Ano de Publicação</th>
                <th>Gênero</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.title }}</td>
                <td>{{ book.published_year }}</td>
                <td>{{ book.genre }}</td>
                <td>{{ book.author.name }}</td>
                <td>
                <a :href="`/books/${book.id}`" class="btn btn-info">Ver</a>
                <a :href="`/books/${book.id}/edit`" class="btn btn-warning">Editar</a>
                <button @click="deleteBook(book.id)" class="btn btn-danger">Excluir</button>
                </td>
            </tr>
            </tbody>
        </table>

    </AuthenticatedLayout>
  </template>