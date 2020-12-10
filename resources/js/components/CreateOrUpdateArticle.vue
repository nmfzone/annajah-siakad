<template>
  <div class="w-full">
    <slot
      :title="title"
      :modelId="modelId"
      :content="content"
      :submitted="submitted"
      :isLoading="isLoading"
      :isDirty="isDirty"
      :wysiwygId="wysiwygId"
      :successMessage="successMessage"
      :loadingSaveDraft="loadingSaveDraft"
      :loadingUpdateOrPublish="loadingUpdateOrPublish"
      :updateProps="updateProps"
      :saveDraft="saveDraft"
      :updateOrPublishArticle="updateOrPublishArticle"
      :onSaveCallback="onSaveCallback"></slot>
  </div>
</template>

<script>
import Url from 'url-parse'
import { isEmpty } from '@root/utils'
import dayjs from 'dayjs'

export default {
  props: {
    type: {
      type: String,
      required: true
    },
    model: Object
  },
  data() {
    return {
      submitted: false,
      modelId: null,
      title: null,
      content: null,
      successMessage: null,
      loadingSaveDraft: false,
      loadingUpdateOrPublish: false,
    }
  },
  computed: {
    attributes() {
      return [
        'title', 'content',
      ]
    },
    isLoading() {
      return this.loadingSaveDraft || this.loadingUpdateOrPublish
    },
    wysiwygId() {
      return 'wysiwyg-' + this._uid
    },
    isDirty() {
      return ! isEmpty(this.title) || ! isEmpty(this.content)
    },
    currentUrl() {
      return new Url(window.location)
    },
    editor() {
      return window.tinyMCE.get(this.wysiwygId)
    }
  },
  mounted() {
    this.attributes.forEach(key => {
      this.$watch(key, this.watchValueChanges)
    })

    window.addEventListener('keydown', async (e) => {
      if (e.key === 's' && (e.ctrlKey || e.metaKey)) {
        e.preventDefault();

        await this.onSaveCallback()
      }
    })
  },
  methods: {
    async updateOrPublishArticle() {
      this.editor.save()

      await this.$nextTick(async () => {
        this.editor.setProgressState(true)
        const publishedAt = _.get(this.model, 'published_at')
        this.loadingSaveOrPublish = true

        if (isEmpty(publishedAt)) {
          try {
            await this.performSave({
              published_at: dayjs().format('YYYY-MM-DD HH:mm:ss'),
            })
            this.successMessage = 'Artikel berhasil dipublish.'
          } catch (e) {
            //
          }
        } else {
          try {
            await this.performSave()
            this.successMessage = 'Artikel berhasil diperbarui.'
          } catch (e) {
            //
          }
        }

        this.loadingSaveOrPublish = false
        this.editor.setProgressState(false)
      })
    },
    async saveDraft() {
      this.editor.save()

      await this.$nextTick(async () => {
        this.editor.setProgressState(true)
        this.loadingSaveDraft = true

        try {
          if (this.modelId) {
            await this.onSaveCallback()
          } else {
            if (!this.isDirty) {
              return
            }
            const {data} = await axios.post(`/api/artikel`, {
              type: this.type,
              title: this.title,
              content: this.content
            })

            this.modelId = data.data.id
            this.redirectToEditPage()
          }
        } catch (e) {
          //
        }

        this.loadingSaveDraft = false
        this.editor.setProgressState(false)
      })
    },
    async onSaveCallback() {
      const cachedModelId = _.get(window.mediaSelectorData, 'article')

      if (cachedModelId) {
        this.modelId = cachedModelId
      }

      if (this.modelId) {
        await this.performSave()

        const publishedAt = _.get(this.model, 'published_at')

        if (isEmpty(publishedAt)) {
          this.successMessage = 'Draf berhasil diperbarui.'
        } else {
          this.successMessage = 'Artikel berhasil diperbarui.'
        }
      }
    },
    async performSave(data) {
      this.submitted = false

      await axios.put(`/api/artikel/${this.modelId}`, {
        title: this.title,
        content: this.content,
        ...data && data
      })

      window.onbeforeunload = undefined
      this.submitted = true

      this.redirectToEditPage()
    },
    redirectToEditPage() {
      if (!(/\/artikel\/([0-9]+)\/edit$/).test(this.currentUrl.pathname)) {
        window.location.replace(`/artikel/${this.modelId}/edit`);
      }
    },
    watchValueChanges() {
      window.onbeforeunload = () => ''
    },
    updateProps(value, field) {
      this[field] = value
    }
  }
}
</script>
