<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Book from '@/Components/Book.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'


const props = defineProps(['books']);

function toggleisRead(id) {
    router.put(`/books/${id}/toggleisRead`);
}

function deleteBook(id) {
    if (confirm('Tem certeza que deseja excluir este livro?')) {
        router.delete(`/books/${id}`);
    }
}

</script>

<template>
    
    <AuthenticatedLayout>

        <div class="container">

            <Head title="Livros"></Head>

            <div class="text-right">
                <a href="/books/create" class="new-book-btn">Adicionar novo livro</a>
            </div>

            <div class="books-list">

                <div v-for="book in books" :key="book.id" class="book">

                    <Book :book="book"></Book>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

    .books-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .new-book-btn {
        background-color: rgb(100, 180, 117);
        padding: 10px;
        border-radius: 8px;
        margin: 9px;
        font-weight: 600;
        font-size: 1.2rem;
        color: #313131;
    }

</style>