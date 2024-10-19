<script setup>

    import { ref } from 'vue';

    const props = defineProps(['bookId']);

</script>

<template>

    <transition name="modal-fade">

        <div class="modal-backdrop">

            <div class="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">

            <header class="modal-header" id="modalTitle">

                {{ props.bookId }}

                <slot name="header">

                </slot>

                <button
                type="button"
                class="btn-close"
                @click="$emit('close')"
                aria-label="Close modal"
                >
                    x
                </button>

            </header>
    
            <section class="modal-body" id="modalDescription">
                <slot name="body">
                    
                </slot>
            </section>
    
            <footer class="modal-footer">

                <slot name="footer">
                    
                </slot>

                    <!--<button
                    type="button"
                    class="btn-green"
                    @click="$emit('close', false)"
                    aria-label="Close modal"
                    >
                    Fechar
                </button>-->
                
            </footer>
            </div>
        </div>

    </transition>

</template>
  
<style>
    .modal-backdrop {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background: #FFFFFF;
        box-shadow: 2px 2px 20px 1px;
        overflow-x: auto;
        display: flex;
        flex-direction: column;
        width: 380px;
        min-height: 220px;
        border-radius: 8px;
    }

    .modal-header,
    .modal-footer {
        padding: 15px;
        display: flex;
        flex-direction: column;
    }

    .modal-header .book-author {
        font-size: .9rem;
        color: #7e7e7e;
    }

    .modal-header {
        position: relative;
        background-color: #ededed;
        font-size: 1.4rem;
        font-weight: 500;
        justify-content: space-between;
    }

    .modal-footer {
        border-top: 1px solid #eeeeee;
        flex-direction: column;
    }

    .modal-pages-read-title {
        font-size: 1.2rem;
        font-weight: 500;
    }

    .modal-pages-read-input {
        border: 1px solid #ccc;
        border-radius: 36px;
        text-align: center;
        font-size: 1.2rem;
        font-weight: 500;
        /*border: none;
        border-bottom: 1px solid #ccc;*/
        padding: 14px 10px;
        margin: 6px;
        width: 40%;
    }

    .modal-pages-read-input:focus {
        border: 1px solid #ccc;
        box-shadow: none;
        border-radius: 36px;
    }

    .modal-body {
        position: relative;
        padding: 20px 10px;
    }

    .btn-close {
        position: absolute;
        top: 0;
        right: 2px;
        border: none;
        font-size: 26px;
        padding: 10px;
        cursor: pointer;
        font-weight: bold;
        color: #7e7e7e;
        background: transparent;
    }

    .btn-green {
        color: white;
        background: #4AAE9B;
        border: 1px solid #4AAE9B;
        border-radius: 2px;
    }

    .modal-fade-enter,
    .modal-fade-leave-to {
        opacity: 0;
    }

    .modal-fade-enter-active,
    .modal-fade-leave-active {
        transition: opacity .5s ease;
    }

</style>