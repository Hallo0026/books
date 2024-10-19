<script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Book from '@/Components/Book.vue';
    import Modal from '@/Components/Modal.vue';
    import { Head, router } from '@inertiajs/vue3';
    import { defineProps, ref } from 'vue';

    const props = defineProps(['book']);

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
            <div v-if="book.isRead" class="readIt">
                <i class="fa-solid fa-eye"></i>
            </div>

            <div class="book">

                <div class="book-cover">

                    <div class="alter-book-cover-icon">+</div>

                    <img v-if="book.cover" :src="`/storage/${book.cover}`" />
                    <img v-else :src="`/storage/${book.cover}`"/>

                </div>

                <div class="book-details">                        

                    <input class="book-title" type="text" :value="book.title">

                    <input type="text" v-if="book.author" class="book-author" :value="book.author.name" />

                    <input v-if="book.description" type="text" class="book-description" :value="book.description" />

                    <div v-if="book.published_year">
                        <input type="text" id="book-published-year" class="book-published-year" :value="book.published_year" />                   
                    </div>

                    <p><i class="fa-solid fa-hashtag icon"></i> {{ book.isbn }}</p>

                </div>

                <div v-if="book.total_pages">
                    <progress class="book-progress-bar" :value="book.pages_read" :max="book.total_pages"/>
                    <p class="book-progress-text">{{ book.pages_read }} de {{ book.total_pages }} páginas lidas</p>
                </div>

            </div>
                        
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

    input {
        display: block;
        width: 100%;
        background: transparent;
        border: none;
        padding: 0 4px;
    }

    .book {
        position: relative;
        cursor: pointer;
        width: 400px;
        margin: 0 auto;
    }

    .book-cover {
        max-width: 400px;
    }

    .alter-book-cover-icon {
        position: absolute;
        right: 10px;
        width: 15px;
        height: 15px;
    }

    .book-title {
        font-size: 1.4rem;
        font-weight: 500;     
    }

    .book-published-year {
        font-size: .8rem;
        color: #999;
    }

    .book-progress-bar {
        width: 100%;
        height: 4px;
    }

    .book-progress-text {
        text-align: center;
        font-size: .8rem;
        color: #999;
    }
</style>