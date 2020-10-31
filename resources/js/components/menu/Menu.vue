<template>
  <div>
    <div class="toggler-wrapper">
      <button type="button" class="navbar-toggler text-white" @click="menuToggler">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <transition name="show">
      <div :class="{'menu-wrapper uppercase text-sm': true, 'force-open': showMenu}">
        <ul class="menu">
          <navbar-menu-item
            v-for="item in data"
            :li-class="liClass"
            :li-class-root="liClassRoot"
            :link-class="linkClass"
            :child-link-class="childLinkClass"
            :key="item.id"
            :data="item" />
        </ul>
      </div>
    </transition>
  </div>
</template>

<script>
  export default {
    props: {
      data: {
        type: Array,
        required: true,
      },
      liClass: {
        type: null,
      },
      liClassRoot: {
        type: null,
      },
      linkClass: {
        type: null,
      },
      childLinkClass: {
        type: null,
      }
    },
    data () {
      return {
        showMenu: false
      }
    },
    mounted() {
      window.addEventListener('resize', () => {
        this.showMenu = false
      })
    },
    methods: {
      menuToggler () {
        this.showMenu = !this.showMenu

        if (this.showMenu) {
          window.scrollTo(0, 0)
          $('body').addClass('full-menu')
          $('main-navbar').removeClass('sticky')
        } else {
          $('body').removeClass('full-menu')
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .menu {
    @apply flex flex-col;
  }

  .toggler-wrapper,
  .menu-wrapper:not(.force-open) {
    display: none;
  }

  @screen sm {
    .menu {
      @apply flex-row;
    }
  }

  @screen md {
    .menu-wrapper {
      display: block !important;
    }
  }

  @screen max-md {
    .toggler-wrapper {
      display: block;
    }

    .menu ::v-deep {
      @apply absolute left-0 top-14 z-50 bg-white h-full w-full overflow-y-auto;

      li a {
        @apply text-gray-700;
      }
    }

    .show-enter-active, .show-leave-active {
      transition: height .25s ease-in-out;
    }
    .show-enter, .show-leave-to {
      height: 0;
    }
  }
</style>

<style lang="scss">
@screen max-md {
  body.full-menu {
    height: 100%;
    overflow: hidden;

    .menu {
      @apply flex-col;
    }

    .content-wrapper {
      display: none;
    }
  }
}
</style>
