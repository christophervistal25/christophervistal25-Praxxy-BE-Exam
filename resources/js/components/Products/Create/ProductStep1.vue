<script>
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import { useField, useForm } from "vee-validate";
import { VueEditor } from "vue3-editor";
import * as yup from "yup";

export default {
  components: {
    VueEditor,
  },
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
    let categories = ref([]);

    const fetchCategories = async () => {
      const response = await axios.get(`/api/v1/categories`);
      categories.value = response.data;
    };

    const schema = yup.object({
      name: yup.string().required().min(2),
      category: yup.array().required(),
      description: yup.string().required().max(200),
    });

    const { handleSubmit, errors } = useForm({
      validationSchema: schema,
      validateOnMount: true,
    });

    const { value: name } = useField("name");
    const { value: description } = useField("description");
    const { value: category } = useField("category");

    watch(props.data, (newVal, oldVal) => {
      name.value = newVal.name;
      description.value = newVal.description;
      category.value = newVal.category;
    }, { immediate: true });


    const proceedToNextStep = () => {
      if (Object.values(errors.value).length === 0) {
        props.data.name = name.value;
        props.data.description = description.value;
        props.data.category = category.value;
        props.data.isDone = true;
        emit("next-step", props.data);
      }
    };

    onMounted(fetchCategories);

    return {
      name,
      description,
      category,
      categories,
      errors,
      proceedToNextStep,
    };
  },
};
</script>

<template>
  <form @submit.prevent="proceedToNextStep">
    <div class="form-group mt-2">
      <label class="form-label required">Name</label>
      <input class="form-control" v-model.trim="name" />
      <span class="text-danger">{{ errors.name }}</span>
    </div>

    <div class="form-group mt-2">
      <label class="form-label required">Categories</label>
      <select class="form-select" v-model="category" multiple>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
      <span class="text-danger">{{ errors.category }}</span>
    </div>

    <div class="form-group mt-2">
      <label class="form-label required">Description</label>
      <vue-editor v-model.trim="description"></vue-editor>
      <span class="text-danger">
        {{ errors.description }}
      </span>
    </div>


    <div class="form-group mt-2">
      <div class="float-end">
        <button class="btn btn-primary"
          :class="mode.toLowerCase() === 'edit' ? 'btn-success' : 'btn-primary'">Next</button>
      </div>
    </div>
  </form>
</template>