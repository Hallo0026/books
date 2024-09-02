<script setup>

const props = defineProps(['book']);

</script>

<template>
    <div>
      <h1>{{ book.title }}</h1>
      <p><strong>Ano de Publicação:</strong> {{ book.published_year }}</p>
      <p><strong>Gênero:</strong> {{ book.genre }}</p>
      <p><strong>Autor:</strong> {{ book.author.name }}</p>
      <a :href="`/books/${book.id}/edit`" class="btn btn-warning">Editar</a>
      <a href="/books" class="btn btn-primary">Voltar</a>
    </div>
</template>
  
  
  