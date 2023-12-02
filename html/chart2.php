<!DOCTYPE HTML>
<html>
<head>
<!--<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>-->
<script type="text/javascript" src="canvasjs/canvasjs.min.js"></script>
</head>
<body>


<?php 
$currentPage = 'DeKUT-IMS-Dasboard';
include('header.php');
include('sidebarnav.php');
?>

<div id="chartContainer" style="height: 400px; width: calc(75% - 220px); margin-top: 50px; padding: 20px; box-sizing: border-box; display: flex; justify-content: flex-end;"></div>


  <script type="text/javascript">
    window.onload = function () {
      var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
          text: "Nature of Counseling Cases by Course"
        },
        axisY: {
          title: "Number of Cases",
          interval: 1,
          includeZero: true
        },
        toolTip: {
          shared: true
        },
        legend: {
          verticalAlign: "top",
          horizontalAlign: "center",
          reversed: true,
          cursor: "pointer",
          itemclick: toggleDataSeries
        },
        data: []
      });

      function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
          e.dataSeries.visible = false;
        } else {
          e.dataSeries.visible = true;
        }
        chart.render();
      }

      fetch('get_counse_data.php')
        .then(response => response.json())
        .then(data => {
          var courses = {}; // Store data by course

          data.forEach(row => {
            var course = row.course;
            var nature = row.nature_of_case;
            var count = parseInt(row.case_count);

            if (!courses[course]) {
              courses[course] = {};
            }

            if (!courses[course][nature]) {
              courses[course][nature] = count;
            } else {
              courses[course][nature] += count;
            }
          });

          var series = [];
          for (var course in courses) {
            var dataPoints = [];
            for (var nature in courses[course]) {
              dataPoints.push({ label: nature, y: courses[course][nature] });
            }
            series.push({ type: "stackedBar", name: course, showInLegend: true, dataPoints: dataPoints });
          }

          chart.options.data = series;
          chart.render();
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  </script>
</body>
</html>
