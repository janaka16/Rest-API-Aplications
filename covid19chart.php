<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <title>COVID19 Information in Europe - Bar Chart</title>

    <style>
        section {
            padding: 5rem 0;
            max-width: 1700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<section>
    <div class="container">
        <h3 class="text-center">COVID19 Information in Europe - Bar Chart</h3>
        <div id="chart_div"></div>
    </div>

    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var apiKey = "606a565222msh11a3fc50796560fp1ec259jsn55ce72275eb8";
            var endpoint = 'https://covid-193.p.rapidapi.com/statistics';

            var xhr = new XMLHttpRequest();
            xhr.open("GET", endpoint, true);
            xhr.setRequestHeader("X-RapidAPI-Key", apiKey);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response && response.response) {
                        var statistics = response.response;
                        var europeanData = statistics.filter(function (countryData) {
                            return countryData.continent === 'Europe' && countryData.country !== 'Europe';
                        });

                        var chartData = europeanData.map(function (countryData) {
                            return [countryData.country, countryData.cases.total];
                        });

                        var data = google.visualization.arrayToDataTable([['Country', 'Cases']].concat(chartData));
                        var options = {
                            title: 'Cases vs. Countries in Europe',
                            width: 1100,
                            height: 570,
                            bar: {groupWidth: "60%"},
                            legend: {position: 'bottom', textStyle: {color: 'black', fontSize: 16}},
                        };

                        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                    }
                }
            };

            xhr.send();
        }
    </script>
</section>
</body>
</html>
