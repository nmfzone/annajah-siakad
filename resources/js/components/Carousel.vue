<template>
  <v-carousel
    class="carousel"
    ref="carousel"
    :style="cssVars"
    :perPage="1"
    v-bind="attrs"
    v-on="$listeners">
    <slide
      v-for="(slide, index) in slides"
      :key="slide.id"
      :class="slideClass"
      ref="slide">
      <img :src="slide.image" @load="onImgLoad($event, slide, index)" />
    </slide>
  </v-carousel>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel'
import { GlobalMixin } from '@mixins'

export default {
  inheritAttrs: false,
  mixins: [
    GlobalMixin,
  ],
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
    slideClass: {
      type: String
    }
  },
  data() {
    return {
      mounted: false,
      resize: 0,
      firstSlideImage: null,
      firstSlideImageHeight: null
    }
  },
  computed: {
    cssVars() {
      if (!this.mounted) {
        return {}
      }

      const resize = this.resize
      const el = $(this.$refs.carousel.$el)
      const mHeight = el.offset().top + el.height()

      return {
        '--top': mHeight-((mHeight/10)*2)-70 + 'px'
      }
    }
  },
  mounted() {
    this.mounted = true
    const slideRefs = this.$refs.slide || []

    slideRefs.forEach((slide) => {
      slide._computedWatchers['activeSlides'].run()
      slide._computedWatchers['isActive'].run()
      // slide.$forceUpdate()
    })
    // this.$forceUpdate()
    this.patchVueCarousel()
    window.addEventListener('resize', this.resizeHeight)
  },
  methods: {
    onImgLoad(event, slide, index) {
      if (index === 0) {
        this.firstSlideImage = slide
        window.dispatchEvent(new Event('resize'))
      }
    },
    resizeHeight() {
      this.resize++
    },
    patchVueCarousel() {
      const vCarousel = this.$refs.carousel
      if ((vCarousel.isTouch && vCarousel.touchDrag) || vCarousel.mouseDrag) {
        vCarousel.$refs["VueCarousel-wrapper"].removeEventListener(
          vCarousel.isTouch ? "touchstart" : "mousedown",
          vCarousel.onStart
        )
        vCarousel.$refs["VueCarousel-wrapper"].addEventListener(
          vCarousel.isTouch ? "touchstart" : "mousedown",
          this.vCarouselOnStart
        )
      }
    },
    vCarouselOnStart(e) {
      const vCarousel = this.$refs.carousel
      vCarousel.onStart(e)
      document.removeEventListener(
        vCarousel.isTouch ? "touchend" : "mouseup",
        vCarousel.onEnd,
        true
      )
      document.addEventListener(
        vCarousel.isTouch ? "touchend" : "mouseup",
        this.vCarouselOnEnd,
        true
      )
    },
    vCarouselOnEnd(e) {
      const vCarousel = this.$refs.carousel
      vCarousel.onEnd(e)
      vCarousel.startAutoplay()
    }
  }
}
</script>

<style lang="scss" scoped>
  .carousel {
    overflow: hidden;
  }
  .carousel ::v-deep {
    .VueCarousel-pagination {
      position: absolute;
      top: var(--top);
    }

    .VueCarousel-slide {
      img {
        height: 100%;
        object-fit: cover;
        object-position: center;
        width: 100%;
      }
    }
  }
</style>
