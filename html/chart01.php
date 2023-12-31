<!DOCTYPE HTML>
<html>
<head>
<!--<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>-->
<script type="text/javascript" src="canvasjs/canvasjs.min.js"></script>
</head>
<body>
  <div id="pieChartContainer" style="height: 300px; width: 100%;"></div>

  <script type="text/javascript">
    window.onload = function () {
      var pieChart = new CanvasJS.Chart("pieChartContainer", {
        animationEnabled: true,
        title: {
          text: "Distribution of Counseling Cases by Course"
        },
        data: [{
          type: "pie",
          startAngle: 240,
          yValueFormatString: "##0",
          indexLabel: "{label} - {y}",
          dataPoints: []
        }]
      });

      fetch('get_couns_data.php')
        .then(response => response.json())
        .then(data => {
          var dataPointsPie = {};

          data.forEach(row => {
            var course = row.course;
            var count = parseInt(row.case_count);

            if (!dataPointsPie[course]) {
              dataPointsPie[course] = count;
            } else {
              dataPointsPie[course] += count;
            }
          });

          var seriesDataPie = [];
          for (var course in dataPointsPie) {
            seriesDataPie.push({ label: course, y: dataPointsPie[course] });
          }
          pieChart.options.data[0].dataPoints = seriesDataPie;

          pieChart.render();
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  </script>
</body>
</html>
