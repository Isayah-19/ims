<!DOCTYPE HTML>
<html>
<head>
<!--<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>-->
<script type="text/javascript" src="canvasjs/canvasjs.min.js"></script>
</head>
<body>


  <div id="pieChartContainer" style="height: 300px; width: 33%; float: left;"></div>
  <div id="barChartContainer" style="height: 300px; width: 33%; float: center;"></div>
  <div id="scatterChartContainer" style="height: 300px; width: 33%; float: right;"></div>
  <div id="chartContainer" style="height: 300px; width: 50%;"></div>


  <script type="text/javascript">
    window.onload = function () {
      // Pie Chart
      var pieChart = new CanvasJS.Chart("pieChartContainer", {
        animationEnabled: true,
        title: {
          text: "Distribution of Counseling Cases by Nature"
        },
        data: [{
          type: "pie",
          startAngle: 240,
          yValueFormatString: "##0",
          indexLabel: "{label} - {y}",
          dataPoints: []
        }]
      });

      // Bar Chart
      var barChart = new CanvasJS.Chart("barChartContainer", {
        animationEnabled: true,
        title: {
          text: "Counseling Academic Year vs Nature of Case"
        },
        axisX: {
          title: "Academic Year"
        },
        axisY: {
          title: "Number of Cases",
          interval: 1,
          includeZero: true
        },
        data: []
      });

      // Scatter Chart
      var scatterChart = new CanvasJS.Chart("scatterChartContainer", {
        animationEnabled: true,
        title: {
          text: "Counseling Cases by Date and Nature"
        },
        axisX: {
          title: "Date"
        },
        axisY: {
          title: "Number of Cases",
          interval: 1,
          includeZero: true
        },
        data: []
      });

      //Line graph
      var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
          text: "Counseling Cases Over Time"
        },
        axisX: {
          title: "Date",
          valueFormatString: "YYYY MMM DD" // Customize the date format as needed
        },
        axisY: {
          title: "Number of Cases",
          interval: 1,
          includeZero: true
        },
        data: [{
          type: "line",
          dataPoints: []
        }]
      });

      // Fetch data using AJAX or fetch API
      fetch('get_counseling_data.php')
        .then(response => response.json())
        .then(data => {
          var dataPointsPie = {};
          var dataPointsBar = {};
          var dataPointsScatter = [];
          var dataPointsLine = [];

          // Extract data from JSON response
          var dataCounsDate = data.couns_date;
          var dataCounsAcadYr = data.couns_acadYr;

          // Loop through data for couns_date
          dataCounsDate.forEach(row => {
            var date = new Date(row.couns_date);
            var count = parseInt(row.case_count);
            dataPointsLine.push({ x: date, y: count });
          });

          // Loop through data for couns_acadYr
          dataCounsAcadYr.forEach(row => {
            var nature = row.nature_of_case;
            var count = parseInt(row.case_count);
            var year = row.couns_acadYr;

            if (!dataPointsPie[nature]) {
              dataPointsPie[nature] = count;
            } else {
              dataPointsPie[nature] += count;
            }

            if (!dataPointsBar[year]) {
              dataPointsBar[year] = {};
            }

            if (!dataPointsBar[year][nature]) {
              dataPointsBar[year][nature] = count;
            } else {
              dataPointsBar[year][nature] += count;
            }

            dataPointsScatter.push({ x: new Date(row.couns_date), y: count, label: nature });
          });

          var seriesDataPie = [];
          for (var nature in dataPointsPie) {
            seriesDataPie.push({ label: nature, y: dataPointsPie[nature] });
          }
          pieChart.options.data[0].dataPoints = seriesDataPie;

          var seriesDataBar = [];
          for (var year in dataPointsBar) {
            var dataSeriesBar = {
              type: "bar",
              name: year,
              showInLegend: true,
              dataPoints: []
            };
            for (var nature in dataPointsBar[year]) {
              dataSeriesBar.dataPoints.push({ label: nature, y: dataPointsBar[year][nature] });
            }
            seriesDataBar.push(dataSeriesBar);
          }
          barChart.options.data = seriesDataBar;

          var seriesDataScatter = {
            type: "scatter",
            toolTipContent: "<b>{label}</b><br>Date: {x}<br>Number of Cases: {y}",
            dataPoints: dataPointsScatter
          };
          scatterChart.options.data.push(seriesDataScatter);

          chart.options.data[0].dataPoints = dataPointsLine;

          pieChart.render();
          barChart.render();
          scatterChart.render();
          chart.render();
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  </script>
</body>
</html>