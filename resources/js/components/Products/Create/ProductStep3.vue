<template>
  <h1>Step 3</h1>
  <form @submit.prevent="proceedToNextStep">
    <label>Date and Time</label>
    <div class="form-group">
      <input type="date" class="form-control" v-model="dateAndTime" />
      <p class="text-danger">{{ errors.dateAndTime?.replace('dateAndTime', 'Date and time') }}</p>
    </div>
    <div class="form-group mt-2">
      <div class="float-end">
        <button class="btn btn-primary"
          :class="mode.toLowerCase() === 'edit' ? 'btn-success' : 'btn-primary'">Submit</button>
      </div>
    </div>
  </form>
</template>

<script>
import { watch } from "vue";
import { useField, useForm } from "vee-validate";
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

    const schema = yup.object({
      dateAndTime: yup.date().required(),
    });

    const { errors } = useForm({
      validationSchema: schema,
      validateOnMount: true,
    });

    const { value: dateAndTime } = useField("dateAndTime");

    watch(props.data, (newVal, oldVal) => {
      dateAndTime.value = newVal.date_and_time;
    }, { immediate: true });


    const proceedToNextStep = () => {
      if (Object.values(errors.value).length === 0) {
        props.data.isDone = true;
        props.data.date_and_time = dateAndTime;
        emit("next-step", props.data);
      }
    };

    return {
      dateAndTime,
      errors,
      proceedToNextStep,
    };
  },
};
</script>