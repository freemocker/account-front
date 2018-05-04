/** charts start */
(function ($) {

    var chart = {};

    /**
     * 生成图表
     *
     * @param areaid
     *            图表区域id
     * @param options
     *            图表配置参数
     * @return myChart
     */
    chart.initChart = function (areaid, options) {
        var option = $.extend({}, options);
        var myChart = echarts.init(document.getElementById(areaid));
        myChart.setOption(option);
        return myChart;
    };

    /**
     * 清空并释放图表
     *
     * @param myChart
     */
    chart.distroyChart = function (myChart) {
        if (myChart && !myChart.isDisposed()) {
            myChart.clear();
            myChart.dispose();
        }
    };

    chart.resize = function (myChart) {
        if (myChart && !myChart.isDisposed()) {
            myChart.resize();
        }
    };

    AUI.chart = chart;
})($);
/** charts end */
