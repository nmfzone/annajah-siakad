<template>
  <div ref="outer">
    <div ref="head" class="h-full" v-if="!form">
      <slot name="header" :displayForm="displayForm"></slot>
    </div>

    <transition name="slideUp">
      <div v-if="form">
        <slot name="form"></slot>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    openForm: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      form: this.openForm,
    }
  },
  methods: {
    displayForm() {
      $('html, body').animate({
        scrollTop: $(this.$refs.outer).offset().top - 100
      }, 1000)

      setTimeout(() => {
        this.form = true
      }, 1100)
    }
  }
}
</script>
