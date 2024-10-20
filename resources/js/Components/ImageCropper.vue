<script setup>

    import { ref, onMounted, watch, nextTick } from 'vue';
    import { getCurrentInstance } from 'vue';
    import Cropper from 'cropperjs';
    import 'cropperjs/dist/cropper.css';
    
    const imageData = ref(null);
    const croppedImageData = ref(null);
    const cropper = ref(null);
    const emit = defineEmits(['image-cropped']);
    
    const { proxy } = getCurrentInstance(); // Obtém o contexto atual
  
    const onFileChange = (event) => {
        const file = event.target.files[0];
        if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageData.value = e.target.result;
        };
        reader.readAsDataURL(file);
        }
    };
  
    const cropImage = async () => {

        if (cropper.value) {
            const croppedCanvas = cropper.value.getCroppedCanvas({
                width: 380,
                height: 500,
            });
        
            croppedCanvas.toBlob((blob) => {
                const croppedFile = new File([blob], 'cropped-image.png', {
                type: 'image/png', // Tipo de imagem
                });
                croppedImageData.value = URL.createObjectURL(blob);
                emit('image-cropped', croppedFile);
            }, 'image/png');
        }

    };
  
    onMounted(() => {

        watch(imageData, async (newImage) => {

            if (newImage) {
                await nextTick(); // Aguarda a próxima atualização do DOM
                cropper.value = new Cropper(proxy.$refs.image, {
                aspectRatio: 280 / 400,
                viewMode: 1,
                });
            }

        });

    });
</script>

<template>
    <div>
        <input type="file" @change="onFileChange" accept="image/*" />

        <div v-if="imageData">
            <img ref="image" :src="imageData" />
            <button type="button" @click="cropImage">Recortar Imagem</button>
        </div>
        
        <img :src="croppedImageData" style="display: none;"/>

    </div>
</template>
  
  
<style scoped>
    img {
        max-width: 100%;
    }
</style>
  