<template>
  <li
    :class="{'menu-item': true, 'bg-gray-50': hoverBg}"
    @click="onClick"
    @mouseover="onMouseOver"
    @mouseleave="onMouseLeave"
    v-click-outside="onClickOutside">
    <slot></slot>

    <transition name="slide">
      <div v-if="hasDropdown && show" class="dropdown">
        <slot name="dropdown"></slot>
      </div>
    </transition>
  </li>
</template>

<script>
  export default {
    props: {
      hasDropdown: Boolean,
    },
    data() {
      return {
        show: false,
        hoverBg: false
      }
    },
    methods: {
      onClick() {
        this.show = !this.show
        this.hoverBg = true
      },
      onClickOutside() {
        this.show = false
        this.hoverBg = false
      },
      onMouseOver() {
        this.hoverBg = true
      },
      onMouseLeave() {
        if (!this.show) {
          this.hoverBg = false
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  li.menu-item {
    @apply flex relative items-center align-middle px-4 py-4;

    > .dropdown {
      @apply absolute block bg-white overflow-hidden left-auto right-0 w-auto;

      top: 100%;
      margin-right: 0.6px;
      margin-top: 1px;
      min-width: 200px;
      max-width: 300px;
      box-shadow: 0 2px 5px 0 rgba(88, 104, 125, 0.5);

      ::v-deep .dropdown-item {
        @apply block w-full px-4 py-3;

        &:hover {
          @apply bg-gray-200;
        }
      }
    }
  }

  .slide-enter-active {
    transition-duration: 0.15s;
    transition-timing-function: ease-in;
  }
  .slide-leave-active {
    transition-duration: 0.15s;
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  }
  .slide-enter-to, .slide-leave {
    @apply h-full;
  }
  .slide-enter, .slide-leave-to {
    @apply h-0;
  }
</style>
