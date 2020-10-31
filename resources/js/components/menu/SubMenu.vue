<template>
  <ul class="dropdown">
    <navbar-menu-item
      v-for="item in parent.children"
      :link-class="linkClass"
      :li-class="liClass"
      :key="item.id"
      :level="level+1"
      :data="item" />
  </ul>
</template>

<script>
  import { GlobalMixin } from '@mixins'

  export default {
    mixins: [
      GlobalMixin
    ],
    props: {
      parent: {
        type: Object,
        required: true,
      },
      level: {
        type: Number,
        default: 1,
      },
      linkClass: {
        type: null,
      },
      liClass: {
        type: null,
      }
    },
    mounted() {
      //
    }
  }
</script>

<style lang="scss" scoped>
  .dropdown {
    @apply fixed invisible opacity-0 min-w-40 max-w-50vw top-full;
    transition: all .25s ease-in-out;
    transform: translate(0, -20px);
    background: #04696d;

    &.open-right {
      @apply left-0 right-auto;
    }

    &.open-left {
      @apply left-auto right-0;
    }

    ::v-deep li {
      &:not(:last-child) {
        @apply border-b;
        border-color: rgba(255, 255, 255, 0.09);
      }
    }

    ::v-deep {
      .dropdown {
        @apply top-0;

        &.open-right {
          @apply left-full;
        }

        &.open-left {
          @apply right-full;
        }
      }
    }
  }

  @screen max-md {
    body.full-menu {
      .dropdown {
        @apply max-w-full bg-white;

        transform: translate(0, 0);
        transition: none;

        ::v-deep li {
          &:first-child {
            @apply pt-8;
          }

          &:last-child {
            @apply pb-0;
          }
        }
      }
    }
  }
</style>
