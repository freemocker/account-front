(function ($) {

    homepageobj = {};

    homepageobj.onlineUserOptions = null;
    homepageobj.onlineUserChart = null;

    /**
     * 初始化图表
     */
    homepageobj.initOnlineUserCharts = function () {
        portal_tools_obj.doAjax(G_webrootPath + "/service/home/serviceHome", {
            cmd: "getOnlineUserInfo"
        }, function (result) {
            if (result.errmsg) {
                AUI.chart.distroyChart(homepageobj.onlineUserChart);
                AUI.dialog.alert(result.errmsg, null, 3);
            } else if (result.info) {
                homepageobj.createChart(result.info);
            }
        }, "POST", false, "json", true, function (obj, message, exception) {
            AUI.chart.distroyChart(homepageobj.onlineUserChart);
            AUI.dialog.alert(message, null, 3);
        });
    };

    /**
     * 生成图表
     *
     * @param info
     */
    homepageobj.createChart = function (info) {
        homepageobj.onlineUserOptions = {
            tooltip: {
                formatter: "{a} <br/>{b} : {c} 人"
            },
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {
                        show: true
                    }
                }
            },
            series: [{
                title: {
                    show: true,
                    offsetCenter: [0, '-40%'], // x, y，单位px
                    textStyle: { // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                        fontWeight: 'bolder'
                    }
                },
                max: info.total,
                name: '用户数',
                type: 'gauge',
                splitNumber: info.splitNumber, // 分割段数，默认为5
                axisTick: { // 坐标轴小标记
                    splitNumber: info.axisTick.splitNumber // 每份split细分多少段
                },
                detail: {
                    formatter: '{value} 人',
                    textStyle: { // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                        color: 'auto',
                        fontWeight: 'bolder'
                    }
                },
                data: [{
                    value: info.usercounts,
                    name: '用户数'
                }]
            }]
        };
        homepageobj.onlineUserChart = AUI.chart.initChart("homepage_chart_onlineuser", homepageobj.onlineUserOptions);
    };

    /**
     * 显示统计界面
     */
    homepageobj.showOnlineUserStatistical = function () {
        homepageobj.initOnlineUserCharts();
        $("#homepage_charts_reload,#homepage_charts_fullscreen").click(function () {
            homepageobj.initOnlineUserCharts();
        });
        $("#homepage_charts_collapse").click(function () {
            setTimeout(function(){
                resizeChart();
            },0);
        });
    };

    var resizeChart = function () {
        if (homepageobj.onlineUserChart != null) {
            AUI.chart.resize(homepageobj.onlineUserChart);
        }
    };

    $(function () {
        homepageobj.showOnlineUserStatistical();
        $(window).unbind("resize", resizeChart);
        $(window).bind("resize", resizeChart);
    });
})($);