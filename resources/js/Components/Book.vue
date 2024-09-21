<script setup>

const props = defineProps(['book']);

</script>

<template>
    <div>
        <div v-if="book.isRead" class="readIt">
            <i class="fa-solid fa-eye"></i>
        </div>

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

        <progress class="book-progress-bar" value="50" max="100">
        </progress>
    </div>
</template>

<style>

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
    }
</style>