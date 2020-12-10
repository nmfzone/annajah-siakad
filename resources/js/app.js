import './bootstrap'
import './global'
import './container-screen'
import './front/sticky-menu'
import vClickOutside from 'v-click-outside'


Vue.use(vClickOutside)

import NavbarMenu from './components/menu/Menu'
import NavbarMenuItem from './components/menu/MenuItem'
import NavbarSubMenu from './components/menu/SubMenu'
import Carousel from './components/Carousel'
import TransitionViewport from './components/TransitionViewport'


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
