import Vue from 'vue'
import dayjs from 'dayjs'
import 'dayjs/locale/id'

window.Vue = Vue
dayjs.locale('id')

import FormInput from './components/form/FormInput'
import Alert from './components/Alert'

Vue.component('form-input', FormInput)
Vue.component('alert', Alert)
