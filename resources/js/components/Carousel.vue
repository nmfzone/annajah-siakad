<template>
  <v-carousel
    class="carousel"
    :paginationColor="paginationColor"
    :paginationActiveColor="paginationActiveColor"
    :perPage="1">
    <slide v-for="slide in slides" :key="slide.id" :style="{height: slideHeight}">
      <img width="100%" :src="slide.image" />
    </slide>
  </v-carousel>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel'

export default {
  components: {
    'v-carousel': Carousel,
    Slide
  },
  props: {
    paginationColor: {
      default: '#efefef'
    },
    paginationActiveColor: {
      default: '#03989e'
    },
    slides: {
      type: Array,
      default: []
    },
    slideHeight: {
      type: String,
      default: 'auto'
    }
  }
}
</script>

<style lang="scss" scoped>
  .carousel {
    overflow: hidden;
  }
  .carousel ::v-deep .VueCarousel-pagination {
    position: absolute;
    top: 85%;
  }
</style>
