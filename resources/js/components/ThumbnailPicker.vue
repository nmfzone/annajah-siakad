<template>
  <div>
    <div class="thumbnail-picker">
      <div class="picker" v-if="!displayImage" @click="onClick">
        Pilih Gambar Unggulan
      </div>
      <div class="display-holder" v-if="displayImage">
        <div class="display" @click="changeImage">
          <img :src="selectedImage.url" />
        </div>
        <div class="action mt-2 flex">
          <span
            class="text-blue-600 hover:text-blue-800"
            @click="changeImage">
            Ganti Gambar
          </span>
          <span class="font-bold px-2">|</span>
          <span
            class="text-red-600 hover:text-red-800"
            @click="removeImage">
            Batal memilih
          </span>
        </div>
      </div>
    </div>
    <media-selector
      v-if="showSelector"
      :modelType="modelType"
      :modelId="modelId"
      :onChooseMedia="onChooseMedia"
      @close="onCloseSelector" />
  </div>
</template>

<script>
import MediaSelector from './media-selector/MediaSelector'

export default {
  components: {
    MediaSelector
  },
  props: {
    modelType: {
      type: String,
      required: true
    },
    modelId: [Number, String],
  },
  data() {
    return {
      showSelector: false,
      displayImage: false,
      selectedImage: {}
    }
  },
  methods: {
    onClick() {
      this.showSelector = true
    },
    onCloseSelector() {
      this.showSelector = false
    },
    onChooseMedia(data) {
      this.$set(this, 'selectedImage', data)
      this.$emit('selected-image', data)
      this.displayImage = true
    },
    changeImage() {
      this.showSelector = true
    },
    removeImage() {
      this.selectedImage = {}
      this.displayImage = false
      this.$emit('deselect-image')
    }
  }
}
</script>

<style lang="scss" scoped>
  .thumbnail-picker {
    @apply cursor-pointer;

    .picker {
      @apply flex justify-center items-center h-40 bg-gray-300;

      &:hover {
        @apply bg-gray-400;
      }
    }

    .display-holder {
      .display {
        @apply h-40 overflow-hidden relative;

        img {
          @apply absolute object-cover m-auto w-full;
        }
      }
    }
  }
</style>
