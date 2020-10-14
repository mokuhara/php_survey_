import Barc from '../src/chart/bar.js'
import Piec from '../src/chart/pie.js'

const app = new Vue({
    el: "#app",
    data: {
        message: "Vue.js"
    },
    components: {
        Barc,
        Piec
    }
})