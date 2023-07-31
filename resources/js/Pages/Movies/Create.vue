<template>
    <div class="container">
      <h1 class="title">Add Movie</h1>

      <div class="header">
        <h2>Add Movie</h2>
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
          <div>
                                <InputLabel for="email" value="email" />

                                <TextInput id="email" type="email" class="mb-4 block w-full" v-model="form.email" />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

          <div class="form-group">
            <label for="pic">Product Picture</label>
            <input type="file" @input="form.pic = $event.target.files[0]" class="input" accept="image/jpeg" />
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
              {{ form.progress.percentage }}%
            </progress>
          </div>
          <button class="button">Add Movie</button>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import InputError from '@/Components/InputError.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import TextInput from '@/Components/TextInput.vue';
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    title: null,
    description: null,
    email: '',
    pic: null,
  });

  function submit() {
    form.post('/movies');
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
