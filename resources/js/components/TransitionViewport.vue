<template>
  <div ref="target" :style="{height: styleTargetHeight}">
    <transition :name="name" v-if="enable">
      <div v-if="show" :style="{'animation-duration': localDuration}">
        <slot></slot>
      </div>
    </transition>
    <div v-else>
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String
    },
    duration: {
      type: Number,
      default: 1
    },
    tolerance: {
      type: Number,
      default: 0
    }
  },
  computed: {
    localDuration() {
      return this.duration + 's'
    },
    styleTargetHeight() {
      if (this.targetHeight !== 'auto') {
        return this.targetHeight + 'px'
      }
      return this.targetHeight
    }
  },
  data() {
    return {
      show: true,
      targetHeight: 'auto',
      enable: false
    }
  },
  mounted() {
    this.$nextTick(function () {
      const target = this.$refs.target
      this.targetHeight = target.offsetHeight
      this.show = false
      this.enable = true
      window.addEventListener('scroll', () => {
        if (!this.show && this.isInViewport(target)) {
          this.targetHeight = 'auto'
          this.show = true
        }
      })
    })
  },
  methods: {
    isInViewport(elem) {
      const bounding = elem.getBoundingClientRect()

      // console.log(this._uid, bounding.top, this.targetHeight, (this.targetHeight/3)*2, bounding.top - ((this.targetHeight/3)*2))

      return bounding.top >= 0 && (bounding.top - this.targetHeight + this.tolerance) <= 0
    }
  }
}
</script>
