const userStatisticsCard = () => {
    $.get("/userStatisticsCard", function (res) {
        $("#userCount").html(res);
    });
}

function userStatisticsCardLoop() {
    userStatisticsCard();
    setTimeout(function () {
        userStatisticsCard();
        userStatisticsCardLoop();
    }, 600000);
}

userStatisticsCardLoop();

var chart;

const renderChart = (data) => {

    console.log(data);

    var options = {
        chart: {
            type: 'area',
            locales: [{
                "name": "ja",
                "options": {
                    "months": [
                        "1月", "2月", "3月", "4月", "5月", "6月",
                        "7月", "8月", "9月", "10月", "11月", "12月"
                    ],
                    "shortMonths": [
                        "1月", "2月", "3月", "4月", "5月", "6月",
                        "7月", "8月", "9月", "10月", "11月", "12月"
                    ],
                    "days": [
                        "日曜日", "月曜日", "火曜日", "水曜日",
                        "木曜日", "金曜日", "土曜日"
                    ],
                    "shortDays": ["日", "月", "火", "水", "木", "金", "土"],
                    "toolbar": {
                        "exportToSVG": "SVGで出力",
                        "exportToPNG": "PNGで出力",
                        "exportToCSV": "CSVダウンロード",
                        "menu": "メニュー",
                        "selection": "選択",
                        "selectionZoom": "選択ズーム",
                        "zoomIn": "ズームイン",
                        "zoomOut": "ズームアウト",
                        "pan": "パン",
                        "reset": "リセットズーム"
                    },
                    "export": {
                        "csv": {
                            "filename": "ユーザー統計データ",
                            "columnDelimiter": ",",
                            "headerCategory": "日付"
                        }
                    }
                }
            }],
            defaultLocale: "ja"
        },
        series: [{
            name: '登録者数',
            data: Object.values(data)
        }],
        xaxis: {
            categories: Object.keys(data)
        },
        colors: ['#FF5733']
    };

    $("#lineChart").html("");

    chart = new ApexCharts(document.querySelector("#lineChart"), options);

    chart.render();
}

const changeChartType = (type) => {
    $.get('/userStatisticsChart', {
        "type": type
    }, function(res){
        renderChart(res);
    });
}

changeChartType("daily");