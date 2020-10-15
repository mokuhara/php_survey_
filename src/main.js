import Barc from '../src/chart/bar.js'
import Piec from '../src/chart/pie.js'

const app = new Vue({
    el: "#app",
    data: {
        selected: 'bar',
    },
    components: {
        Barc,
        Piec
    },
})