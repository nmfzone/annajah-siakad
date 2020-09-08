import './bootstrap'
import './container-screen'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import vSelect from 'vue-select'


Vue.use(vClickOutside)

window.Vue = Vue

import Alert from './components/Alert'
import FormInput from './components/form/FormInput'
import FormSelect from './components/form/FormSelect'
import FormButton from './components/form/FormButton'
import NavbarMenuItem from './components/navbar/MenuItem'

Vue.component('v-select', vSelect)
Vue.component('alert', Alert)
Vue.component('form-input', FormInput)
Vue.component('form-select', FormSelect)
Vue.component('form-button', FormButton)
Vue.component('navbar-menu-item', NavbarMenuItem)


const app = new Vue({
    el: '#app',
})
