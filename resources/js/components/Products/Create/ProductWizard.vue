<script>
import axios from "axios";
import { defineComponent, ref, reactive, onMounted } from "vue";
import ProductStep1 from "./ProductStep1.vue";
import ProductStep2 from "./ProductStep2.vue";
import ProductStep3 from "./ProductStep3.vue";
import Product from "@/models/Product.js";

export default defineComponent({
  components: {
    ProductStep1,
    ProductStep2,
    ProductStep3,
  },
  emits: ["next-step"],
  props: {
    mode: {
      type: String,
      required: true,
    },
    productId: {
      type: Number,
    },
  },
  setup(props) {
    const product = reactive({
      step_one: {
        name: "",
        category: [],
        description: "",
        isDone: false,
      },
      step_two: {
        images: [],
        isDone: false,
      },
      step_three: {
        date_and_time: "",
      },
    });

    const getProduct = async () => {
      let response = await axios.get(`/api/v1/product/${props.productId}`);
      product.step_one.name = response.data.name;
      product.step_one.description = response.data.description;
      product.step_one.category = response.data.categories.map((category) => category.id);

      product.step_two.images = response.data.images;

      product.step_three.date_and_time = response.data.date_and_time;
    };


    let onStepOneNext = (stepOneData) => {
    };

    let onStepTwoNext = (stepTwoData) => {
    };

    let onFinalStepSubmit = () => {
      if (props.mode.toLowerCase() === 'edit') {
        product.step_two.images = product.step_two.images.filter((image) => image instanceof File);
      }

      const productModel = new Product({
        name: product.step_one.name,
        categories: product.step_one.category,
        description: product.step_one.description,
        images: product.step_two.images,
        date_and_time: product.step_three.date_and_time,
      });

      if (props.mode.toLowerCase() === 'edit') {
        axios.post(`/api/v1/product/${props.productId}`, productModel.toFormData()).then((response) => {
          if (response.data.success) {
            window.location.href = '/products';
          }
        });
      } else {
        axios.post(`/api/v1/product/store`, productModel.toFormData()).then((response) => {
          if (response.data.success) {
            window.location.href = '/products';
          }
        });
      }
    };

    onMounted(() => {
      if (props.mode.toLowerCase() === 'edit') {
        getProduct();
      }
    });

    return {
      product,
      onStepOneNext,
      onStepTwoNext,
      onFinalStepSubmit,
    };
  },
});
</script>

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="card-title">{{ mode }} Product</div>
      </div>
      <div class="card-body">
        <ProductStep1 v-if="!product.step_one.isDone" :data="product.step_one" :mode="mode" @next-step="onStepOneNext" />
        <ProductStep2 v-if="product.step_one.isDone && !product.step_two.isDone" :mode="mode" :data="product.step_two"
          @next-step="onStepTwoNext" />
        <ProductStep3 v-if="product.step_one.isDone && product.step_two.isDone" :mode="mode" :data="product.step_three"
          @next-step="onFinalStepSubmit" />
      </div>
    </div>
  </div>
</template>