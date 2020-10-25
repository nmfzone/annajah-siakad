<template>
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
    mounted() {
      //
    }
  }
</script>

<style lang="scss" scoped>
  .menu {
    @apply flex flex-col;
  }

  @screen sm {
    .menu {
      @apply flex-row;
    }
  }
</style>
