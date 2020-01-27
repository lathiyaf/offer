import {Line, mixins} from 'vue-chartjs';
const { reactiveProp } = mixins;

export default ({
    mixins: [reactiveProp],
    extends:Line,
    props: ['options','chartData'],
    watch: {
        chartData: function() {
            this.renderChart(this.chartData,this.options);
        }
    },
    mounted() {
        this.renderChart(this.chartData,this.options);
    }
});
