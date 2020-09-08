<template>
  <transition name="fade">
    <div :class="['alert', localState, {'pr-12-imp': dismissible}]" v-if="localShow">
      <slot>
        <div class="header" v-if="hasMessage" v-html="message"></div>
        <ul class="list" v-if="hasMessages">
          <li v-for="message in messages">
            <div v-html="message"></div>
          </li>
        </ul>

        <span class="close" v-if="dismissible" v-on:click="dismiss">
          <i class="fa fa-times"></i>
        </span>
      </slot>
    </div>
  </transition>
</template>

<script>
  import _ from 'lodash'

  export default {
    props: {
      state: {
        type: String,
        default: 'default'
      },
      message: String,
      messages: Array,
      dismissible: Boolean,
      timer: Number,
      showErrorList: {
        type: Boolean,
        default: true
      }
    },
    data () {
      return {
        show: true,
        countDownTimerId: null,
        dismissed: false
      }
    },
    computed: {
      hasMessage() {
        return !_.isEmpty(this.message)
      },
      hasMessages() {
        return !_.isEmpty(this.messages)
      },
      localState () {
        return `alert-${this.state}`
      },
      localShow () {
        return !this.dismissed && (this.countDownTimerId || this.show)
      }
    },
    mounted () {
      this.init()
    },
    methods: {
      dismiss () {
        this.dismissed = true
        this.$emit('dismissed')
        this.clearCounter()
        this.countDownTimerId = null
      },
      clearCounter () {
        if (this.countDownTimerId) {
          clearInterval(this.countDownTimerId)
        }
      },
      init () {
        if (!this.show || this.timer === undefined || this.timer < 1) {
          return
        }

        this.dismissed = false
        let dismissCountDown = this.timer

        this.$emit('dismiss-count-down', dismissCountDown)
        this.clearCounter()

        this.countDownTimerId = setInterval(() => {
          if (dismissCountDown < 2) {
            return this.dismiss()
          }

          dismissCountDown--

          this.$emit('dismiss-count-down', dismissCountDown)
        }, 1000)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .alert {
    @apply border px-4 py-3 mb-5 rounded relative;

    &.alert-success {
      @apply bg-green-200 border-green-300 text-teal-900;
    }

    &.alert-danger {
      @apply bg-red-100 border-red-400 text-red-700;
    }

    &.alert-warning {
      @apply bg-orange-100 border-orange-300 text-orange-700;
    }

    .close {
      @apply absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer;
    }
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
</style>
