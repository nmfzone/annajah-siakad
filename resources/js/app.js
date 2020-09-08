import './bootstrap'
import './container-screen'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'


Vue.use(vClickOutside)

window.Vue = Vue

import Alert from './components/Alert'
import FormInput from './components/form/FormInput'
import FormButton from './components/form/FormButton'
import NavbarMenuItem from './components/navbar/MenuItem'

Vue.component('alert', Alert)
Vue.component('form-input', FormInput)
Vue.component('form-button', FormButton)
Vue.component('navbar-menu-item', NavbarMenuItem)


const app = new Vue({
    el: '#app',
})
