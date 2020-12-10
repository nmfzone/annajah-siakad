<template>
  <div class="media-selector-wrapper">
    <div class="media-selector">
      <div class="close" @click="onClose">
        <i class="fa fa-times"></i>
      </div>
      <div class="content">
        <div class="top-nav">
          Pilih Media
        </div>
        <div class="tabs">
          <div class="navigator">
            <div class="nav" :class="{ active: activeTab === 1 }" @click="setActiveTab(1)">
              Unggah Berkas
            </div>
            <div class="nav" :class="{ active: activeTab === 2 }" @click="setActiveTab(2)">
              Pustaka Media
            </div>
          </div>
          <div class="content">
            <div class="content-inner">
              <div class="tab" v-if="activeTab === 1">
                <div class="h-full">
                  <div class="flex flex-col h-full items-center justify-center">
                    <div class="upload">
                      <input ref="fileInput" type="file" @change="uploadFile" hidden />

                      <button type="button" class="btn btn-secondary px-4 py-2" @click="onUploadBtnClick">
                        Pilih Berkas
                      </button>
                    </div>

                    <div class="mt-2 text-red-500" v-if="uploadError">
                      {{ errorMessage }}
                    </div>

                    <div class="mt-4 text-sm text-gray-700">
                      Ukuran maksimal berkas: 1MB
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab" v-if="activeTab === 2">
                <template v-if="!isFetchingMedia">
                  <div class="list-media" v-if="allMedia.length > 0">
                    <div
                      class="item w-1/2 pb-1/2-imp sm:w-1/4 sm:pb-1/4-imp
                              md:w-1/6 md:pb-1/6-imp lg:w-1/8 lg:pb-1/8-imp"
                      :class="{ selected: isMediaSelected(media) }"
                      v-for="media in allMedia"
                      :key="media.id"
                      @click="onSelectMedia($event, media)">
                      <div class="w-full h-full absolute p-2">
                        <div
                          class="w-full h-full flex items-center justify-center"
                          :class="{'bg-gray-400': media.uploading}">
                          <div v-if="isMediaSelected(media)" class="absolute text-5xl text-green-500">
                            <i class="fas fa-check-circle"></i>
                          </div>
                          <template v-if="!media.uploading">
                            <img :src="media.url">
                          </template>

                          <template v-else>
                            Uploading
                          </template>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="h-full" v-else>
                    <div class="flex flex-col h-full items-center justify-center">
                      <div class="mb-3">
                        Belum ada media.
                      </div>

                      <div class="upload">
                        <input ref="fileInput" type="file" @change="uploadFile" hidden />

                        <button type="button" class="btn btn-secondary px-4 py-2" @click="onUploadBtnClick">
                          Pilih Berkas
                        </button>
                      </div>

                      <div class="mt-2 text-red-500" v-if="uploadError">
                        {{ errorMessage }}
                      </div>

                      <div class="mt-4 text-sm text-gray-700">
                        Ukuran maksimal berkas: 1MB
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>

            <div class="sidebar hidden">
              <!-- -->
            </div>
          </div>
        </div>

        <div class="bottom-nav">
          <div class="float-left"></div>
          <div class="float-right">
            <button
              type="button"
              class="btn btn-primary"
              :disabled="buttonSelectorDisabled"
              @click="buttonSelectorClick">
              Pilih
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="backdrop"></div>
  </div>
</template>

<script>
import { v4 as uuidv4 } from 'uuid'

export default {
  props: {
    modelType: {
      type: String,
      required: true
    },
    modelId: [Number, String],
    onChooseMedia: {
      type: Function,
      required: true
    }
  },
  data() {
    return {
      localModelId: null,
      buttonSelectorDisabled: true,
      selectedMedia: null,
      activeTab: 2,
      allMedia: [],
      uploadError: false,
      errorMessage: null,
      isFetchingMedia: false
    }
  },
  computed: {
    currentModelId() {
      return this.modelId ? this.modelId : this.localModelId
    }
  },
  async mounted() {
    if (!window.mediaSelectorData) {
      window.mediaSelectorData = {}
    }

    if (!this.modelId) {
      this.localModelId = _.get(window.mediaSelectorData, this.modelType)
    }

    await this.fetchMedia()
  },
  methods: {
    async fetchMedia() {
      this.isFetchingMedia = true
      const { data } = await axios.get('/api/media/wysiwyg', {
        params: {
          model: this.modelType
        }
      })
      this.allMedia = this.allMedia.concat(data.data)
      this.isFetchingMedia = false
    },
    async uploadFile(e) {
      this.uploadError = false
      this.errorMessage = null
      const formData = new FormData()
      formData.append('model', this.modelType)
      if (this.currentModelId) {
        formData.append('model_id', this.currentModelId)
      }
      formData.append('file', e.target.files[0])

      this.$refs.fileInput.value = null
      const tmpId = uuidv4()

      const fromTab = this.activeTab
      this.activeTab = 2
      this.allMedia.unshift({
        id: tmpId,
        uploading: true
      })

      try {
        const { data } = await axios.post('/api/media/wysiwyg', formData)

        if (!this.currentModelId) {
          this.localModelId = data.data.model.id
          _.set(window.mediaSelectorData, this.modelType, this.localModelId)
        }

        const newMediaIdx = _.findIndex(this.allMedia, (m) => m.id == tmpId)
        this.$set(this.allMedia, newMediaIdx, data.data)

        window.onbeforeunload = () => ''
      } catch (e) {
        const newMediaIdx = _.findIndex(this.allMedia, (m) => m.id == tmpId)
        this.allMedia.splice(newMediaIdx, 1)
        this.uploadError = true
        this.errorMessage = _.get(e, 'response.data.errors.file.0')

        if (fromTab === 1) {
          this.activeTab = 1
        }
      }
    },
    onSelectMedia(event, media) {
      if (!media.uploading) {
        if (this.isMediaSelected(media)) {
          this.selectedMedia = null
          this.buttonSelectorDisabled = true
        } else {
          this.selectedMedia = media
          this.buttonSelectorDisabled = false
        }
      }
    },
    buttonSelectorClick() {
      if (this.selectedMedia) {
        this.onChooseMedia(this.selectedMedia)
        this.selectedMedia = null
        this.onClose()
      }
    },
    setActiveTab(value) {
      this.activeTab = value
    },
    onUploadBtnClick() {
      this.$refs.fileInput.click()
    },
    isMediaSelected(media) {
      return _.get(this.selectedMedia, 'id') == media.id
    },
    onClose() {
      this.$emit('close')
    }
  }
}
</script>

<style lang="scss" scoped>
  .media-selector-wrapper {
    .media-selector {
      position: fixed;
      top: 30px;
      left: 30px;
      right: 30px;
      bottom: 30px;
      z-index: 2000;

      > .close {
        @apply absolute right-0 mt-4 mr-4 cursor-pointer;
      }

      > .content {
        @apply w-full h-full;

        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
        background: #fcfcfc;

        .tabs {
          @apply w-full h-full;

          .navigator {
            @apply flex px-4 border-b border-solid border-gray-400;

            .nav {
              @apply p-2 border border-transparent cursor-pointer;

              margin-bottom: -1px;

              &.active {
                @apply bg-white border-gray-400 border-b-white;
              }
            }
          }

          .content {
            @apply bg-white absolute right-0 left-0 h-auto;

            top: 85px;
            bottom: 70px;

            .content-inner {
              @apply h-full w-full overflow-hidden;

              .tab {
                @apply overflow-auto h-full p-4;

                .list-media {
                  @apply flex flex-wrap;

                  .item {
                    @apply cursor-pointer relative overflow-hidden;

                    > div {
                      img {
                        @apply w-full h-full border-2 border-transparent;
                        object-fit: cover;
                        object-position: center;
                      }
                    }

                    &.selected {
                      img {
                        @apply border-blue-400;
                      }
                    }
                  }
                }
              }
            }
          }
        }

        > .top-nav {
          @apply px-4 py-2 text-lg;
        }

        > .bottom-nav {
          @apply absolute h-auto w-full p-4 bottom-0;
        }
      }
    }

    .backdrop {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      min-height: 360px;
      background: #000;
      opacity: 0.7;
      z-index: 1999;
    }
  }
</style>
