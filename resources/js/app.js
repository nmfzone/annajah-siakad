import './bootstrap'
import './global'
import './container-screen'
import './front/sticky-menu'
import vClickOutside from 'v-click-outside'
import vSelect from 'vue-select'


Vue.use(vClickOutside)

import FormSelect from './components/form/FormSelect'
import FormButton from './components/form/FormButton'
import NavbarMenu from './components/menu/Menu'
import NavbarMenuItem from './components/menu/MenuItem'
import NavbarSubMenu from './components/menu/SubMenu'
import Carousel from './components/Carousel'
import TransitionViewport from './components/TransitionViewport'

Vue.component('v-select', vSelect)
Vue.component('form-select', FormSelect)
Vue.component('form-button', FormButton)
Vue.component('navbar-menu', NavbarMenu)
Vue.component('navbar-menu-item', NavbarMenuItem)
Vue.component('navbar-sub-menu', NavbarSubMenu)
Vue.component('carousel', Carousel)
Vue.component('transition-viewport', TransitionViewport)

import Ppdb from './components/Ppdb'

Vue.component('ppdb', Ppdb)

const app = new Vue({
    el: '#app',
})
