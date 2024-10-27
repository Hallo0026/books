<template>
    <div class="relative">
      <input
        :id="id"
        type="text"
        v-model="searchQuery"
        @focus="openDropdown"
        @input="filterOptions"
        @blur="closeDropdown"
        @keydown.down.prevent="highlightNext"
        @keydown.up.prevent="highlightPrev"
        @keydown.enter.prevent="selectHighlighted"
        :placeholder="placeholder || 'Pesquisar...'"
        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
      />
      <ul
        v-if="isOpen && filteredOptions.length"
        class="absolute w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 z-10 max-h-60 overflow-y-auto"
      >
        <li
          v-for="(option, index) in filteredOptions"
          :key="option.id"
          :class="{'bg-blue-500 text-white': index === highlightedIndex}"
          @mousedown.prevent="selectOption(option)"
          class="cursor-pointer px-4 py-2 hover:bg-blue-500 hover:text-white"
        >
          {{ option.name }}
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue';
  
  const props = defineProps({
    id: {
      type: String,
      required: true
    },
    options: {
      type: Array,
      required: true
    },
    modelValue: {
      type: [String, Number, null],
      default: null
    },
    placeholder: {
      type: String,
      default: ''
    }
  });
  
  const emit = defineEmits(['update:modelValue']);
  
  const searchQuery = ref('');
  const isOpen = ref(false);
  const highlightedIndex = ref(-1);
  
  const filteredOptions = computed(() => {
    if (!searchQuery.value) {
      return props.options;
    }
    return props.options.filter(option =>
      option.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  function openDropdown() {
    isOpen.value = true;
  }
  
  function closeDropdown() {
    setTimeout(() => {
      isOpen.value = false;
      highlightedIndex.value = -1;
    }, 200);
  }
  
  function filterOptions() {
    highlightedIndex.value = -1;
  }
  
  function highlightNext() {
    if (highlightedIndex.value < filteredOptions.value.length - 1) {
      highlightedIndex.value++;
    }
  }
  
  function highlightPrev() {
    if (highlightedIndex.value > 0) {
      highlightedIndex.value--;
    }
  }
  
  function selectHighlighted() {
    if (highlightedIndex.value >= 0 && highlightedIndex.value < filteredOptions.value.length) {
      selectOption(filteredOptions.value[highlightedIndex.value]);
    }
  }
  
  function selectOption(option) {
    emit('update:modelValue', option.id);
    searchQuery.value = option.name;
    closeDropdown();
  }
  
  onMounted(() => {
    if (props.modelValue) {
      const selectedOption = props.options.find(option => option.id === props.modelValue);
      if (selectedOption) {
        searchQuery.value = selectedOption.name;
      }
    }
  });
  </script>
  