<script setup>
import { ref, watch, onUnmounted } from 'vue';
import { defineProps } from 'vue';

// Define as propriedades do componente
const props = defineProps({
    successMessage: {
        type: String,
        default: null,
    },
    errorMessage: {
        type: String,
        default: null,
    }
});

// Estados reativos
const isVisible = ref(false);
const message = ref(null);
const typeClass = ref('');
let hideTimeout = null;

// Função para mostrar o Toast
function showToast() {
    if (props.successMessage) {
        message.value = props.successMessage;
        typeClass.value = 'toast-success';
    } else if (props.errorMessage) {
        message.value = props.errorMessage;
        typeClass.value = 'toast-error';
    }

    if (message.value) {
        isVisible.value = true;
        
        // Limpar qualquer timeout anterior
        if (hideTimeout) {
            clearTimeout(hideTimeout);
        }
        
        // Ocultar o Toast após 3 segundos
        hideTimeout = setTimeout(() => {
            isVisible.value = false;
        }, 3000);
    }
}

// Função para limpar o estado após a saída do Toast
function clearFlash() {
    message.value = null;
}

// Watch para detectar mudanças nas mensagens e chamar showToast
watch(() => [props.successMessage, props.errorMessage], showToast, { immediate: true });

// Limpa o timeout quando o componente for desmontado
onUnmounted(() => {
    if (hideTimeout) {
        clearTimeout(hideTimeout);
    }
});
</script>


<template>
    <transition name="fade" @after-leave="clearFlash">
        <div v-if="isVisible && message" :class="['toast', typeClass]">
            {{ message }}
        </div>
    </transition>
</template>


<style>
/* Estilos para a animação */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* Estilos para o Toast */
.toast {
    position: absolute;
    z-index: 1000;
    right: 20px;
    padding: 10px;
    border-radius: 12px;
    margin-bottom: 10px;
    font-weight: 600;
}
.toast-success {
    background-color: #d4edda;
    color: #155724;
}
.toast-error {
    background-color: #f8d7da;
    color: #721c24;
}
</style>
