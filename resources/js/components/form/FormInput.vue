<template>
  <div>
    <template v-if="!withAddOn">
      <input
        :class="{ 'is-invalid': state === false }"
        :type="localTypeLower"
        class="form-control"
        v-bind="attrs"
        v-on="$listeners">

      <div class="invalid-feedback" v-if="state === false">
        <strong>{{ errorMessage }}</strong>
      </div>
    </template>
    <template v-else>
      <div class="input-group">
        <input
          :class="{ 'is-invalid': state === false }"
          :type="localTypeLower"
          class="form-control"
          v-bind="$attrs"
          v-on="$listeners">

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
  </div>
</template>

<script>
  import { GlobalMixin } from '@mixins'

  export default {
    inheritAttrs: false,
    mixins: [
      GlobalMixin,
    ],
    props: {
      value: [Number, String],
      state: {
        type: Boolean,
        default: null
      },
      type: {
        type: String,
        default: 'text'
      },
      errorMessage: String,
      withAddOn: Boolean,
      addOnClass: [String, Object, Array]
    },
    data () {
      return {
        localValue: this.value,
        localType: this.type,
        localAddOnClass: this.addOnClass
      }
    },
    computed: {
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
      }
    },
    watch: {
      value (v) {
        this.localValue = v
      },
      localValue (v) {
        this.$emit('input', v)
      }
    },
    methods: {
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
</style>
