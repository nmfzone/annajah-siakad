import './bootstrap'
import './container-screen'
import './front/sticky-menu'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import vSelect from 'vue-select'
import dayjs from 'dayjs'
import 'dayjs/locale/id'


Vue.use(vClickOutside)
dayjs.locale('id')

window.Vue = Vue

import Alert from './components/Alert'
import FormInput from './components/form/FormInput'
import FormSelect from './components/form/FormSelect'
import FormButton from './components/form/FormButton'
import NavbarMenu from './components/menu/Menu'
import NavbarMenuItem from './components/menu/MenuItem'
import NavbarSubMenu from './components/menu/SubMenu'
import Carousel from './components/Carousel'
import TransitionViewport from './components/TransitionViewport'
import DatePicker from './components/picker/DatePicker'

Vue.component('v-select', vSelect)
Vue.component('alert', Alert)
Vue.component('form-input', FormInput)
Vue.component('form-select', FormSelect)
Vue.component('form-button', FormButton)
Vue.component('navbar-menu', NavbarMenu)
Vue.component('navbar-menu-item', NavbarMenuItem)
Vue.component('navbar-sub-menu', NavbarSubMenu)
Vue.component('carousel', Carousel)
Vue.component('transition-viewport', TransitionViewport)
Vue.component('date-picker', DatePicker)

import Ppdb from './components/Ppdb'

Vue.component('ppdb', Ppdb)

const app = new Vue({
    el: '#app',
})
