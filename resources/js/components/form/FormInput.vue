<template>
  <div>
    <template v-if="!withAddOn || typeIsCheckboxRadioSelect">
      <template v-if="typeLower === 'radio'">
        <div class="flex flex-wrap" :class="[inline ? 'flex-row' : 'flex-col']">
          <label
            v-for="(item, i) in data"
            :key="i"
            class="inline-flex items-center mt-3 pr-5"
            @click="onClick($event, item)">
            <input
              type="radio"
              :class="{ 'is-invalid': state === false }"
              class="form-radio h-5 w-5 text-gray-600"
              v-bind="attrs"
              v-on="listeners"
              :value="item.value"
              :checked="item.value === localValue">
            <span class="ml-2 text-gray-700">{{ item.text }}</span>
          </label>
        </div>
      </template>
      <template v-else-if="typeLower === 'checkbox'">
        <div class="flex flex-col">
          <label
            v-for="(item, i) in data"
            :key="i"
            :class="{ 'is-invalid': state === false }"
            class="inline-flex mt-3 pr-5"
            @click="onClick($event, item)">
            <input
              type="checkbox"
              class="form-checkbox text-gray-600 mt-1.5"
              v-bind="attrs"
              v-on="listeners"
              :value="item.value"
              :checked="isSelected(item)">
            <span class="ml-2 text-gray-700">{{ item.text }}</span>
          </label>
        </div>
      </template>
      <template v-else-if="typeLower === 'select'">
        <select
          @change="onChange"
          :class="{ 'is-invalid': state === false }"
          class="form-control"
          :value="localValue"
          v-bind="attrs"
          v-on="listeners">
          <option
            v-for="(item, i) in data"
            :key="i"
            :value="item.value">
            {{ item.text }}
          </option>
        </select>
      </template>
      <template v-else-if="typeLower === 'wysiwyg'">
        <media-selector-button
          class="mb-3"
          :wysiwyg-id="localWysiwygId"
          v-bind="attrs" />
        <editor
          :id="localWysiwygId"
          :init="wysiwygConfig"
        />
      </template>
      <template v-else>
        <input
          :class="{ 'is-invalid': state === false }"
          :type="localTypeLower"
          class="form-control"
          @click="onClick"
          :autocomplete="autocomplete"
          v-model="localValue"
          v-bind="attrs"
          v-on="listeners">
      </template>

      <div class="invalid-feedback" v-if="state === false">
        <strong>{{ errorMessage }}</strong>
      </div>
    </template>
    <template v-else>
      <div class="input-group" @click="onClick">
        <input
          :class="{ 'is-invalid': state === false }"
          :type="localTypeLower"
          class="form-control"
          :autocomplete="autocomplete"
          v-model="localValue"
          v-bind="$attrs"
          v-on="listeners">

        <div
          :class="{'password-eye': displayEye, 'input-group-append': true, 'invalid': state === false}">
          <span class="input-group-text">
            <slot>
              <i
                :class="computedAddOnClass"
                aria-hidden="true"
                @click="showHidePassword" />
            </slot>
          </span>
        </div>

        <div class="invalid-feedback" v-if="state === false">
          <strong>{{ errorMessage }}</strong>
        </div>
      </div>
    </template>
    <div class="note btw" v-if="note">
      {{ note }}
    </div>
    <date-picker
      ref="datePickerRef"
      :init="initDate"
      :selectedDate="selectedDate"
      :startDate="startDate"
      :endDate="endDate"
      @change="onChangedDate"
      v-if="datePicker"></date-picker>
  </div>
</template>

<script>
  import { GlobalMixin, InitialValueMixin } from '@mixins'
  import { isEmpty } from '@root/utils'
  import dayjs from 'dayjs'
  import DatePicker from '@components/picker/DatePicker'
  import Editor from '@tinymce/tinymce-vue'
  import MediaSelectorButton from '@components/media-selector/MediaSelectorButton'

  export default {
    inheritAttrs: false,
    mixins: [
      GlobalMixin,
      InitialValueMixin
    ],
    components: {
      Editor,
      DatePicker,
      MediaSelectorButton
    },
    props: {
      value: [Number, String],
      selectFirstItem: {
        type: Boolean,
        default: false
      },
      multiple: {
        type: Boolean,
        default: false
      },
      data: [Array],
      state: {
        type: Boolean,
        default: null
      },
      inline: {
        type: Boolean,
        default: false
      },
      type: {
        type: String,
        default: 'text'
      },
      datePicker: {
        type: Boolean,
        default: false
      },
      initDate: {
        type: Boolean,
        default: false
      },
      autocomplete: {
        type: String,
        default: 'off'
      },
      note: {
        type: String,
        default: null
      },
      errorMessage: String,
      withAddOn: Boolean,
      dateFormat: {
        type: String,
        default: 'DD-MM-YYYY'
      },
      startDate: {
        type: String,
      },
      endDate: {
        type: String,
      },
      addOnClass: [String, Object, Array],
      wysiwygId: String,
      onSaveCallback: Function
    },
    data () {
      return {
        prevValue: null,
        viaPicker: false,
        localValue: this.value,
        localType: this.type,
        localAddOnClass: this.addOnClass,
        selectedDate: null
      }
    },
    computed: {
      listeners() {
        const { input, ...listeners } = this.$listeners
        return listeners
      },
      computedAddOnClass: {
        set (v) {
          this.localAddOnClass = v
        },
        get () {
          if (this.displayEye) {
            return this.mergeClasses(this.localAddOnClass, ['fa', 'fa-eye-slash'])
          }

          return this.localAddOnClass
        }
      },
      typeLower () {
        return this.type.toLowerCase()
      },
      localTypeLower () {
        return this.localType.toLowerCase()
      },
      displayEye () {
        return this.localTypeLower === 'password' && this.withAddOn
      },
      typeIsCheckboxRadioSelect() {
        return ['radio', 'checkbox', 'select'].includes(this.typeLower)
      },
      localWysiwygId() {
        return this.wysiwygId ? this.wysiwygId : 'wysiwyg-' + this._uid
      },
      wysiwygConfig() {
        return {
          base_url: '/vendor/tinymce/',
          language: 'id',
          height: 500,
          menubar: false,
          branding: false,
          relative_urls: false,
          remove_script_host: false,
          plugins: [
            'advlist autolink autosave lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code wordcount'
          ],
          toolbar:
            'undo redo | formatselect | bold italic underline strikethrough | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | forecolor backcolor removeformat | image media',
          setup: (editor) => {
            editor.on('init', () => {
              if (this.localValue) {
                editor.setContent(this.localValue)
              }
              editor.addShortcut('meta+s', 'Custom Ctrl/Command+S', 'custom_meta_s');
              editor.addCommand('custom_meta_s', () => {
                if (this.onSaveCallback) {
                  editor.setProgressState(true)
                  editor.save()
                  this.$nextTick(async () => {
                    try {
                      await this.onSaveCallback()
                    } catch (e) {
                      //
                    }
                    editor.setProgressState(false)
                  })
                }
              })
            })

            editor.on('Change', () => {
              this.localValue = editor.getContent()
            })
          }
        }
      }
    },
    watch: {
      localValue (v) {
        if (this.datePicker && !this.viaPicker && this.prevValue) {
          this.localValue = this.prevValue
        } else {
          this.prevValue = v
        }

        if (!this.datePicker || (this.datePicker && this.viaPicker)) {
          this.viaPicker = false
          this.$emit('input', v)
        }
      }
    },
    beforeMount() {
      if (this.datePicker) {
        if (this.initialValue) {
          this.selectedDate = dayjs(this.initialValue, this.dateFormat)
        }
      } else {
        let value = this.castInitialValue
        if (this.selectFirstItem && this.typeIsCheckboxRadioSelect && isEmpty(this.initialValue)) {
          value = _.get(this.data, '0.value')
        }

        if (!isEmpty(value)) {
          this.localValue = value
        }
      }
    },
    methods: {
      isSelected(item) {
        if (this.typeLower === 'checkbox' && this.multiple) {
          return this.localValue.includes(item.value)
        }
        return item.value === this.localValue
      },
      onChange(event) {
        this.localValue = event.target.value
      },
      onClick(event, data) {
        if (this.typeLower === 'radio') {
          this.localValue = data.value
        } if (this.typeLower === 'checkbox') {
          if (this.isSelected(data)) {
            this.localValue = _.remove(this.localValue, (n) => {
              return n === data.value
            })
          } else {
            this.localValue.push(data.value)
          }
        } else if (this.datePicker) {
          const datePickerRef = this.$refs.datePickerRef
          datePickerRef.programmableClick = true
          this.$refs.datePickerRef.onFeedBack()
        }
      },
      onChangedDate(date) {
        this.viaPicker = true
        this.localValue = date.format(this.dateFormat)
      },
      showHidePassword () {
        if (this.typeLower === 'password') {
          if (this.localTypeLower === 'password') {
            this.computedAddOnClass = this.mergeClasses(
              this.computedAddOnClass,
              'fa-eye',
              'fa-eye-slash'
            )
            this.localType = 'text'
          } else {
            this.computedAddOnClass = this.mergeClasses(
              this.computedAddOnClass,
              'fa-eye-slash',
              'fa-eye'
            )
            this.localType = 'password'
          }
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .input-group-text {
    cursor: pointer;
  }

  .input-group {
    @apply relative flex flex-wrap items-stretch w-full;

    > .form-control {
      @apply relative mb-0 border-r-0;

      flex: 1 1 auto;
      width: 1%;
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
  }

  .input-group-append {
    @apply shadow flex;

    border-radius: 0 .25rem .25rem 0;

    > .input-group-text {
      @apply flex items-center mb-0 text-base font-normal text-center;

      padding: .375rem .75rem;
      line-height: 1.5;
      color: #495057;
      white-space: nowrap;
      background-color: #e9ecef;
      border: 1px solid #ced4da;
      border-radius: 0 .25rem .25rem 0;
    }

    &.invalid {
      > .input-group-text {
        @apply border-red-600 border-l-0;
      }
    }
  }

  .note {
    @apply text-gray-700 pt-2 text-sm;
  }
</style>
