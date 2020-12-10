<template>
  <div>
    <div class="flex">
      <div class="cursor-pointer" @click="onClick">
        <i class="fa fa-upload"></i> Tambah Gambar
      </div>
    </div>

    <media-selector
      v-if="showSelector"
      :modelType="modelType"
      :modelId="modelId"
      :onChooseMedia="appendMediaToEditor"
      @close="onCloseSelector" />
  </div>
</template>

<script>
import MediaSelector from './MediaSelector'

export default {
  components: {
    MediaSelector
  },
  props: {
    wysiwygId: {
      type: String,
      required: true
    },
    modelType: {
      type: String,
      required: true
    },
    modelId: [Number, String],
  },
  data() {
    return {
      showSelector: false
    }
  },
  methods: {
    onClick() {
      this.showSelector = true
    },
    onCloseSelector() {
      this.showSelector = false
    },
    appendMediaToEditor(data) {
      const editor = window.tinyMCE.get(this.wysiwygId)
      const range = editor.selection.getRng()
      const newNode = editor.getDoc().createElement('img')
      newNode.src = data.url
      range.insertNode(newNode)
    }
  }
}
</script>
