<template>
    <div class="movie-card" :class="{ 'movie-card--enabled': movie.enabled }" @click="openMovie">
      <img :src="movie.picUrl" alt="Product photo" class="aspect-square w-full object-cover mb-4">

      <h4 class="text-2xl">Movie Title: {{ movie?.title }}</h4>
      <div class="text-gray-400">Description: {{ movie?.description }}</div>
      <div class="flex justify-between mt-4">
        <div>&nbsp;</div>
        <label :for="'enabled' + '-' + movie.id" class="switch">
          <input type="checkbox" :id="'enabled' + '-' + movie.id" :checked="movie.enabled" @change.prevent="toggleEnabled(movie)">
          <span class="slider round"></span>
        </label>
      </div>
    </div>
  </template>

  <style scoped>
  .movie-card {
    background-color: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
  }

  .movie-card:hover {
    background-color: #f7fafc;
  }

  .movie-card--enabled {
    background-color: #edf2f7;
  }

  .movie-card img {
    width: 100%;
    aspect-ratio: 1/1;
    object-fit: cover;
    margin-bottom: 1rem;
  }

  .movie-card h4 {
    font-size: 1.5rem;
  }

  .movie-card .text-gray-400 {
    color: #718096;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    border-radius: 34px;
    transition: 0.4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    border-radius: 50%;
    transition: 0.4s;
  }

  input:checked + .slider {
    background-color: #2196f3;
  }

  input:checked + .slider:before {
    transform: translateX(20px);
  }

  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
  </style>

  <script setup>
  import { defineProps } from 'vue';
  import { router } from '@inertiajs/vue3';

  const prop = defineProps({
    movie: Object
  });

  function openMovie() {
    router.visit('/movies/' + prop.movie.id);
  }

  function toggleEnabled(movie) {
    movie.enabled = !movie.enabled; // Toggle the enabled state locally
    router.visit('/movies/toggle/' + movie.id, {
      method: 'post',
      preserveScroll: true
    });
  }
  </script>
