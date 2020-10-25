import './bootstrap'
import './container-screen'
import './front/sticky-menu'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import vSelect from 'vue-select'


Vue.use(vClickOutside)

window.Vue = Vue

import Alert from './components/Alert'
import FormInput from './components/form/FormInput'
import FormSelect from './components/form/FormSelect'
import FormButton from './components/form/FormButton'
import NavbarMenu from './components/menu/Menu'
import NavbarMenuItem from './components/menu/MenuItem'
import NavbarSubMenu from './components/menu/SubMenu'
import Carousel from './components/Carousel'

Vue.component('v-select', vSelect)
Vue.component('alert', Alert)
Vue.component('form-input', FormInput)
Vue.component('form-select', FormSelect)
Vue.component('form-button', FormButton)
Vue.component('navbar-menu', NavbarMenu)
Vue.component('navbar-menu-item', NavbarMenuItem)
Vue.component('navbar-sub-menu', NavbarSubMenu)
Vue.component('carousel', Carousel)

const app = new Vue({
    el: '#app',
})
