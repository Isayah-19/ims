<!DOCTYPE HTML>
<html>
<head>
  <script type="text/javascript" src="canvasjs/canvasjs.min.js"></script>
</head>
<body>
  <div id="chartContainer" style="height: 400px; width: 100%;"></div>

  <script type="text/javascript">
    window.onload = function () {
      var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
          text: "Distribution of Birthdates of Students"
        },
        axisX: {
          title: "Birthdates"
        },
        axisY: {
          title: "Number of Students",
          includeZero: true
        },
        data: [{
          type: "line", // You can choose "line" or "column" based on preference
          dataPoints: []
        }]
      });

      fetch('get_birthdate_distribution.php') // Replace with your PHP file
        .then(response => response.json())
        .then(data => {
          var birthdateCounts = {}; // Store counts for each birthdate

          data.forEach(student => {
            var birthdate = student.stud_birth_date; // Adjust field name if needed

            if (!birthdateCounts[birthdate]) {
              birthdateCounts[birthdate] = 1;
            } else {
              birthdateCounts[birthdate]++;
            }
          });

          var dataPoints = [];
          for (var date in birthdateCounts) {
            dataPoints.push({ x: new Date(date), y: birthdateCounts[date] });
          }

          // Sort dataPoints by date
          dataPoints.sort((a, b) => a.x - b.x);

          chart.options.data[0].dataPoints = dataPoints;
          chart.render();
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  </script>
</body>
</html>
