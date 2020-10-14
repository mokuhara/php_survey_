export default {
    name: "Piec",
    methods: {
        makeData() {
            const elem = document.querySelector('.data')
            const json = JSON.parse(elem.dataset.name)
            const labels = _.map(json, 'favorite');
            const data = _.map(json, 'cnt');
            return {
                labels,
                data
            }
        },
        creatChart() {
            const {
                labels,
                data
            } = this.makeData()

            //グラフ描画
            const ctxPie = document.querySelector('#pieChart').getContext('2d');
            const myPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "好きな言語",
                        data: data,
                        backgroundColor: ['rgba(255,182,185,1)', 'rgba(250,227,217,1)', 'rgba(187,222,214,1)', 'rgba(138,198,209,1)']
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        colorschemes: {
                            scheme: 'brewer.Paired12'
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: '好きな言語調査'
                    },
                }
            });
        }
    },
    mounted: function () {
        this.creatChart();
    },
    template: '<canvas id="pieChart" width="400" height="400"></canvas>'
}