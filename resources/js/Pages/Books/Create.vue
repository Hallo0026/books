<script setup>

    import { useForm, Head, router, usePage } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import PageTitle from '@/Components/PageTitle.vue';
    import Toast from '@/Components/Toast.vue';
    import { defineProps, ref } from 'vue';
    import ImageCropper from '@/Components/ImageCropper.vue';

    const props = defineProps(['authors']);

    const form = useForm({
        title: "",
        published_year: "",
        genre: "",
        author_id: "",
        isbn: "",
        description: "",
        cover_image: null,
        total_pages: null,
    });

    let toastMessage = ref('');


    function addBook() {

        if(!checkFields()) {
            return;
        }
        
        form.post('/books', {
            onSuccess: () => {
                form.reset();            
            },
            onError: () => {
                console.log(form.errors);
                toastMessage.value = getFirstErrorMessage();

                setTimeout(() => {
                    toastMessage.value = '';
                }, 5000);

            }
        });


    };


    function checkFields() {

        setTimeout(function() {
            form.errors = {};
        }, 6000);

        if(!form.title) {
            form.errors.title = 'O título é obrigatório.';
            return false;
        }

        if(!form.total_pages) {
            form.errors.total_pages = 'Informe a quantidade a páginas.';
            return false;
        }

        if(!form.genre) {
            form.errors.genre = 'O gênero é obrigatório.';
            return false;
        }

        return true;

    }


    function handleFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            resizeImage(file, 800, 800, (resizedFile) => {
                form.cover_image = resizedFile;
            });
        }
    }


    function resizeImage(file, maxWidth, maxHeight, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (event) => {
            const img = new Image();
            img.src = event.target.result;
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Calcula o novo tamanho da imagem
                let width = img.width;
                let height = img.height;

                if (width > maxWidth || height > maxHeight) {
                    if (width > height) {
                        height = Math.floor((height * maxWidth) / width);
                        width = maxWidth;
                    } else {
                        width = Math.floor((width * maxHeight) / height);
                        height = maxHeight;
                    }
                }

                // Redimensiona a imagem
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // Converte o canvas para um arquivo Blob
                canvas.toBlob((blob) => {
                    const resizedFile = new File([blob], file.name, {
                        type: file.type,
                        lastModified: Date.now(),
                    });
                    callback(resizedFile);
                }, file.type);
            };
        };
    }


    function getFirstErrorMessage() {
        const errors = Object.values(form.errors);
        return errors.length ? errors[0] : 'Ocorreu um erro.';
    }
    

    function handleImageCropped(croppedFile) {
        form.cover_image = croppedFile;
        console.log(form.cover_image);
    }


</script>

<template>
    <Head title="Cadastrar Livro"></Head>

    <AuthenticatedLayout>

        <div class="container mx-auto px-4 py-8">

            <Toast :errorMessage="toastMessage" />

            <PageTitle>Cadastrar Livro</PageTitle>

            <form @submit.prevent="addBook()" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-6">
                
                <div class="space-y-2">
                    <label for="title" class="block text-lg font-medium text-gray-700">
                        Título: 
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="form.title"
                        type="text"
                        id="title"
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        
                    />
                    <div class="form-error-text" v-if="form.errors.title">{{ form.errors.title }}</div>
                </div>


                <div class="flex space-x-4">

                    <div class="flex-1 space-y-2">
                        <label for="isbn" class="block text-lg font-medium text-gray-700">ISBN:</label>
                        <input
                            v-model="form.isbn"
                            type="text"
                            id="isbn"
                            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div class="form-error-text" v-if="form.errors.isbn">{{ form.errors.isbn }}</div>
                    </div>

                    <div class="flex-1 space-y-2">
                        <label for="total_pages" class="block text-lg font-medium text-gray-700">
                            Número de páginas:
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.total_pages"
                            type="number"
                            id="total_pages"
                            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div class="form-error-text" v-if="form.errors.total_pages">{{ form.errors.total_pages }}</div>
                    </div>

                </div>

                


                <div class="flex space-x-4">

                    <div class="flex-1 space-y-2">
                        <label for="published_year" class="block text-lg font-medium text-gray-700">Ano de Publicação:</label>
                        <input
                            v-model="form.published_year"
                            type="number"
                            id="published_year"
                            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div class="form-error-text" v-if="form.errors.published_year">{{ form.errors.published_year }}</div>
                    </div>

                    <div class="flex-1 space-y-2">
                        <label for="author_id" class="block text-lg font-medium text-gray-700">Autor:</label>
                        <select
                            v-model="form.author_id"
                            id="author_id"
                            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option :value="null">
                                Não informar
                            </option>

                            <option v-for="author in authors" :key="author.id" :value="author.id">
                                {{ author.name }}
                            </option>
                        </select>
                        <div class="form-error-text" v-if="form.errors.author_id">{{ form.errors.author_id }}</div>
                    </div>

                </div>


                <div class="space-y-2">
                    <label for="genre" class="block text-lg font-medium text-gray-700">
                        Gênero:
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="form.genre"
                        type="text"
                        id="genre"
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div class="form-error-text" v-if="form.errors.genre">{{ form.errors.genre }}</div>
                </div>


                <div class="space-y-2">
                    <label for="description" class="block text-lg font-medium text-gray-700">Descrição:</label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        rows="4"
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        maxlength="255"
                    ></textarea>
                    <div class="form-error-text" v-if="form.errors.description">{{ form.errors.description }}</div>
                </div>


                <div class="space-y-2">
                    <label for="cover_image" class="block text-lg font-medium text-gray-700">Imagem da Capa:</label>
                    <ImageCropper @image-cropped="handleImageCropped" />
                    <!--<input
                        type="file"
                        id="cover_image"
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        @change="handleFileChange"
                        accept="image/*"
                    />-->              

                </div>


                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-blue-700 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-bold text-md"
                    :disabled="form.processing"
                >
                    Salvar Livro
                </button>

                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                    class="w-full"
                >
                    {{ form.progress.percentage }}%
                </progress>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

    @media(min-width: 1024px) {
        form {
            width: 60%;
            margin: 0 auto;
        }
    }

</style>