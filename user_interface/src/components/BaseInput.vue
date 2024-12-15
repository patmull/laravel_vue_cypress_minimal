<template>
    <div :class="divClass">
      <label
        :for="name"
        class="block text-sm font-medium leading-6 text-gray-900"
        :class="{ 'sr-only': !showLabel }"
        v-if="label"
      >
        {{ label }}
      </label>
      <div :class="divClass">
        <input
          :id="name"
          :type="type"
          :value="modelValue"
          :required="required"
          :minlength="minlength"
          :placeholder="placeholder"
          :autocomplete="autocomplete"
          :class="inputClass"
          :pattern="pattern"
          :maxlength="maxlength"
          v-on:input="updateValue($event.target.value)"
        />
      </div>
    </div>
  </template>
  
<script setup>
import { defineEmits } from 'vue';

const props = defineProps({
  divClass: {
    type: String,
    default: "mt-2",
  },
  name: {
    type: String,
    required: true,
  },
  modelValue: String,
  label: {
    type: String,
    default: "",
  },
  value: {
    type: [String, Number],
  },
  type: {
    type: String,
    default: "text",
  },
  minlength: {
    type: Number,
    default: null
  },
  showLabel: {
    type: Boolean,
    default: true,
  },
  required: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: null,
  },
  autocomplete: {
    type: String,
    default: null,
  },
  inputClass: {
    type: String,
    default: "block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6",
  },
  maxlength: {
    type: [String, Number],
    default: null
  },
  pattern: {
    type: [String, Number],
    default: null
  },
});

const emit = defineEmits(["update:modelValue"]);

function updateValue(value) {
  emit('update:modelValue', value)
};
</script>