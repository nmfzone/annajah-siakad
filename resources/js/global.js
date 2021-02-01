import Vue from 'vue'
import lodash from 'lodash'
import vSelect from 'vue-select'
import dayjs from 'dayjs'
import 'dayjs/locale/id'
import dayjsTimezone from 'dayjs/plugin/timezone'
import vClickOutside from 'v-click-outside'


window.Vue = Vue
Vue.prototype._ = lodash
Vue.use(vClickOutside)

window.dayjs = dayjs
dayjs.locale('id')
dayjs.extend(dayjsTimezone)
dayjs.tz.setDefault('Asia/Jakarta')

import FormInput from './components/form/FormInput'
import Alert from './components/Alert'
import FormSelect from './components/form/FormSelect'
import FormButton from './components/form/FormButton'
import DynamicFormInput from './components/form/DynamicFormInput'

Vue.component('form-input', FormInput)
Vue.component('alert', Alert)
Vue.component('v-select', vSelect)
Vue.component('form-select', FormSelect)
Vue.component('form-button', FormButton)
Vue.component('dynamic-form-input', DynamicFormInput)
