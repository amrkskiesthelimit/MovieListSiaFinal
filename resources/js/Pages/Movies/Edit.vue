<template>
    <div class="container">
      <h1 class="title">Edit Movie</h1>

      <div class="header">
        <h2>Edit Movie</h2>
        <div>
          <a href="/movies" class="button">Back</a>
        </div>
      </div>

      <div class="form-container">
        <form @submit.prevent="submit" class="form">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" v-model="form.title" class="input" />
            <div class="error" v-if="form.errors.title">{{ form.errors.title }}</div>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" v-model="form.description" class="textarea"></textarea>
            <div class="error" v-if="form.errors.description">{{ form.errors.description }}</div>
          </div>


          <button class="button" type="submit">Save Movie</button>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import { reactive } from 'vue';


  const props = defineProps({
    movie: Object
  });

  const form = useForm({
    title: props.movie.title,
    description: props.movie.description

  });

  function submit() {
    form.patch('/movies/' + props.movie.id);
  }
  </script>

  <style scoped>
  .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px;
  }

  .title {
    font-size: 24px;
    margin-bottom: 20px;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .form-container {
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 8px;
  }

  .form {
    display: flex;
    flex-direction: column;
  }

  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: bold;
    margin-bottom: 8px;
  }

  .input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
  }

  .textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    height: 100px;
  }

  .error {
    color: red;
    margin-top: 4px;
  }

  .button {
    padding: 10px 20px;
    background-color: #3490dc;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .progress {
    margin-top: 8px;
  }
  </style>
