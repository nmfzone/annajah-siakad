<template>
  <li
    ref="list"
    @mouseleave="onMouseLeave"
    :class="localLiClassRoot">
    <a
      :href="data.url"
      @mouseover="onMouseOver"
      :class="linkClass">
      <template v-if="showChildren && childOpenDirection === 'open-left' && this.level !== 1">
        <span class="indicator left">
          <i :class="childIndicatorClassDisplayLeft" />
        </span>
      </template>
      <span class="title">{{ data.title }}</span>
      <template v-if="showChildren && (['open-right', ''].includes(childOpenDirection) || this.level === 1)">
        <span class="indicator right">
          <i :class="childIndicatorClassDisplayRight" />
        </span>
      </template>
    </a>

    <template v-if="showChildren">
      <navbar-sub-menu
        ref="children"
        :parent="data"
        :li-class="liClass"
        :link-class="childLinkClass"
        :class="childOpenDirection" />
    </template>
  </li>
</template>

<script>
  import { GlobalMixin } from '@mixins'

  export default {
    mixins: [
      GlobalMixin
    ],
    props: {
      data: {
        type: Object,
        required: true,
      },
      liClass: {
        type: [String, Object, Array],
      },
      liClassRoot: {
        type: [String, Object, Array],
      },
      linkClass: {
        type: [String, Object, Array],
      },
      childLinkClass: {
        type: [String, Object, Array],
      },
      level: {
        type: Number,
        default: 1,
      },
      maxLevel: {
        type: Number,
        default: 3,
      }
    },
    data() {
      return {
        show: false,
        grandchildIndicatorClassLeftHover: 'fa fa-chevron-left',
        grandchildIndicatorClassRightHover: 'fa fa-chevron-right',
        grandchildIndicatorClassLeft: 'fa fa-chevron-left',
        grandchildIndicatorClassRight: 'fa fa-chevron-right',
        childIndicatorClassHover: 'fa fa-chevron-up',
        childIndicatorClass: 'fa fa-chevron-down',
        childIndicatorClassDisplayLeft: '',
        childIndicatorClassDisplayRight: '',
        childOpenDirection: '',
      }
    },
    computed: {
      showChildren() {
        return this.hasChildren && this.level < this.maxLevel
      },
      hasChildren() {
        return this.data.hasOwnProperty('children')
      },
      localLiClass() {
        return this.mergeClasses({
          'show': this.show,
          'has-children': this.showChildren,
          [`level-${this.level}`]: true,
        }, this.liClass)
      },
      localLiClassRoot() {
        return this.mergeClasses(this.localLiClass, this.liClassRoot)
      }
    },
    mounted() {
      if (this.level === 1) {
        this.childIndicatorClassDisplayRight = this.childIndicatorClass
      } else {
        this.childIndicatorClassDisplayRight = this.grandchildIndicatorClassRight
        this.childIndicatorClassDisplayLeft = this.grandchildIndicatorClassLeft
      }
    },
    methods: {
      shouldOpenRight() {
        if (!this.$parent ||
          (this.level > 1 && this.$parent.$el.className.includes('open-left')) ||
          !this.showChildren) {
          return false
        }

        const bounding = this.$refs.list.getBoundingClientRect()
        const childrenBounding = this.$refs.children.$el.getBoundingClientRect()

        if (this.level === 1) {
          // Because level 1 placed dropdown in the bottom of it's list,
          // we should treat it differently.
          return (bounding.x + childrenBounding.width) < window.screen.width
        }

        return (bounding.x + bounding.width + childrenBounding.width) < window.screen.width
      },
      onMouseOver() {
        if (!this.showChildren) {
          return
        }

        const shouldOpenRight = this.shouldOpenRight()
        this.show = true

        if (shouldOpenRight) {
          this.childOpenDirection = 'open-right'
        } else {
          this.childOpenDirection = 'open-left'
        }

        if (this.level === 1) {
          this.childIndicatorClassDisplayRight = this.childIndicatorClassHover
        } else {
          this.childIndicatorClassDisplayRight = this.grandchildIndicatorClassRightHover
          this.childIndicatorClassDisplayLeft = this.grandchildIndicatorClassLeftHover
        }
      },
      onMouseLeave() {
        if (!this.showChildren) {
          return
        }

        this.show = false

        if (this.level === 1) {
          this.childIndicatorClassDisplayRight = this.childIndicatorClass
        } else {
          this.childIndicatorClassDisplayRight = this.grandchildIndicatorClassRight
          this.childIndicatorClassDisplayLeft = this.grandchildIndicatorClassLeft
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  li {
    @apply relative py-4;

    > a {
      @apply flex justify-between items-center;

      .title {
        @apply relative;

        &::before {
          @apply bg-white bottom-0 absolute left-2/4 w-full invisible left-0 h-0.5;

          content: "";
          transform: translate3d(0, 0, 0) scaleX(0);
          transition: all .3s ease 0s;
        }

        &:hover::before {
          @apply visible;

          transform: translate3d(0, 0, 0) scaleX(1);
        }
      }

      .indicator {
        @apply align-middle text-xs;

        &.left {
          @apply pr-2;
        }

        &.right {
          @apply pl-2;
        }
      }
    }

    &.level-1 {
      &.active {
        > a {
          .title {
            &::before {
              @apply visible;
              transform: translate3d(0, 0, 0) scaleX(1);
            }
          }
        }
      }
    }

    &:not(.level-1) {
      @apply px-5;

      > a {
        @apply relative align-middle whitespace-no-wrap px-5;

        margin: 0 -9.375px;
      }
    }

    &.has-children {
      @apply relative z-10;
      perspective: 1000px;

      &:not(.show) {
        overflow: hidden;
      }
    }

    &.show {
      perspective: 0;

      ::v-deep > .dropdown {
        @apply absolute opacity-100 visible;
        transform: translate(0, 0);
      }
    }
  }
</style>
