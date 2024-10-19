<script setup>

const props = defineProps(['book']);

</script>

<template>
    <div>
        <div v-if="book.isRead" class="readIt">
            <i class="fa-solid fa-eye"></i>
        </div>

        <div class="book">

            <div class="book-cover">

                <img v-if="book.cover" :src="`/storage/${book.cover}`" />
                <img v-else :src="`/storage/${book.cover}`"/>

                <!--<button @click="$emit('toggleisRead', book.id)" :class="{isRead : book.isRead}">
                    <i class="fa-solid fa-eye"></i>
                    <span>{{ book.isRead ? 'Já li' : 'Ainda não li' }}</span>
                </button>-->

            </div>

            <div class="book-details">                        
                <h3 class="book-title">{{ book.title }}</h3>
                <p v-if="book.author" class="book-author">
                    {{ book.author.name }}
                </p>
                <p class="book-description">{{ book.description }}</p>
                <p class="book-published_year">Publicado em {{ book.published_year }}</p>
                <p><i class="fa-solid fa-hashtag icon"></i> {{ book.isbn }}</p>
            </div>

            <div v-if="book.total_pages">

                <template v-if="book.completed">
                    <p class="text-center text-green-600 text-lg font-medium">Livro Concluído</p>
                </template>

                <template v-else>
                    <progress class="book-progress-bar" :value="book.pages_read" :max="book.total_pages"/>
                    <p class="book-progress-text">{{ book.pages_read }} de {{ book.total_pages }} páginas lidas</p>
                </template>
                
            </div>

        </div>

        
        
    </div>
</template>

<style>

    .book {
        cursor: pointer;
    }

    .book-title {
        font-size: 1.3rem;
        font-weight: 500;
    }

    .book-published_year {
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