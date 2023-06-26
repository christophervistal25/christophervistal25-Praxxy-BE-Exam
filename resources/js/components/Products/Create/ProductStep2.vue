<template>
  <form @submit.prevent="submitForm">

    <h1>Step 2</h1>
    <div class="form-group mt-2">
      <div class="avatar-group">
        <div v-for="image in data.images" :key="image.id" class="avatar">
          <img :src="`/storage/${image.path}`" alt="">
        </div>
      </div>
      <label>Images <span class="text-primary">(You can upload multiple)</span></label>
      <input type="file" class="form-control" multiple ref="images" @change="onFileInputChange">
      <span class="text-danger">{{ errors[0] }}</span>
    </div>

    <div class="form-group mt-2">
      <div class="float-end">
        <button class="btn btn-primary"
          :class="mode.toLowerCase() === 'edit' ? 'btn-success' : 'btn-primary'">Next</button>
      </div>
    </div>

  </form>
</template>

<script>
import { ref, watch } from "vue";
import * as yup from "yup";

export default {
  props: {
    data: {
      type: Object,
      required: true,
    },
    mode: {
      type: String
    }
  },
  emits: ["next-step"],
  setup(props, { emit }) {
    const images = ref([]);
    const errors = ref({});



    const onFileInputChange = (event) => {
      images.value = Array.from(event.target.files);
    };

    const submitForm = () => {
      const schema = yup.object({
        images: yup
          .array()
          .min(1, "Please select at least one image"),
      });

      schema
        .validate({ images: images.value })
        .then(() => {
          errors.value = [];
          props.data.isDone = true;
          props.data.images = images.value;
          emit("next-step", props.data);
        })
        .catch((err) => {
          errors.value = err.errors;
        });
    };

    watch(props.data, (newVal, oldVal) => {
      images.value = newVal.images;
    }, { immediate: true });


    return {
      errors,
      onFileInputChange,
      submitForm,
    };
  },
};
</script>
