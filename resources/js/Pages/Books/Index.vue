<script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Book from '@/Components/Book.vue';
    import Modal from '@/Components/Modal.vue';
    import Toast from '@/Components/Toast.vue';
    import { Head, router, usePage } from '@inertiajs/vue3';
    import { defineProps, ref, computed, watch } from 'vue';

    const props = defineProps(['books']);
    const page = usePage();
    const flash = computed(() => page.props?.flash || { success: null, error: null });

    let isModalOpen = ref(false);
    let selectedBook = ref(null);


    function openModal(book) {
        selectedBook.value = book;
        isModalOpen.value = true;
        console.log(selectedBook.value);
    }

    function closeModal() {
        isModalOpen.value = false;
        selectedBook.value = null;
    }

    function toggleisRead(id) {
        router.put(`/books/${id}/toggleisRead`);
    }

    function deleteBook(id) {
        if (confirm('Tem certeza que deseja excluir este livro?')) {
            router.delete(`/books/${id}`);
        }
    }

    function updateBookPagesRead(id, pages_read) {
        router.put(`/books/${id}/updatePagesRead`, { pages_read });
    }

</script>

<template>
    
    <AuthenticatedLayout>

        <div class="container">

            <Toast :successMessage="flash.success" :errorMessage="flash.error" />

            <Head title="Livros"></Head>

            <div class="text-right">
                <a href="/books/create" class="new-book-btn">Adicionar novo livro +</a>
            </div>

            <div class="books-list">

                <div v-for="book in books" :key="book.id" class="book" @click="openModal(book)">

                    <Book :book="book"></Book>

                </div>

            </div>

        </div>



        <Modal v-show="isModalOpen" @close="closeModal">

            <template #header>
                <h2>{{ selectedBook?.title || 'Detalhes do Livro' }}</h2>
                <p v-if="selectedBook?.author" class="book-author">
                    {{ selectedBook?.author.name || '' }}
                </p>
            </template>

            <template #body>
                <p class="modal-book-description">
                    {{ selectedBook?.description || '' }}
                </p>

                <div class="modal-book-pages text-center">

                    <div>
                        <div class="modal-pages-read-title">
                            Página atual:
                        </div>
                        <input
                            v-if="selectedBook"
                            class="modal-pages-read-input"
                            type="number"
                            v-model="selectedBook.pages_read"
                            @change="updateBookPagesRead(selectedBook.id, selectedBook.pages_read)"
                        >
                    </div>

                    <!--<div>{{ selectedBook?.pages_read || 0 }} de {{ selectedBook?.total_pages || 0 }} páginas lidas</div>
                    <progress :value="selectedBook?.pages_read || 0" :max="selectedBook?.total_pages || 0"></progress>-->
                </div>

            </template>

            <!--<template #footer>
                <button @click="closeModal">Fechar</button>
            </template>-->

        </Modal>

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
        padding: 10px;
        border-radius: 8px;
        margin: 9px;
        font-size: 1.2rem;
        color: #313131;
    }

</style>