<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="canvasjs/canvasjs.min.js"></script>
</head>
<body>

<?php 
$currentPage = 'DeKUT-IMS-Dashboard';
include('header.php');
include('sidebarnav.php');
?>

<div id="coursePieChartContainer" style="height: 300px; width: calc(75% - 220px); margin-top: 50px; padding: 20px; box-sizing: border-box; display: flex; justify-content: flex-end;"></div>

<div id="genderPieChartContainer" style="height: 300px; width: calc(75% - 220px); margin-top: 50px; padding: 20px; box-sizing: border-box; display: flex; justify-content: flex-end;"></div>

<script type="text/javascript">
    window.onload = function () {
        // Course Pie Chart
        var coursePieChart = new CanvasJS.Chart("coursePieChartContainer", {
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

        // Gender Pie Chart
        var genderPieChart = new CanvasJS.Chart("genderPieChartContainer", {
            animationEnabled: true,
            title: {
                text: "Distribution of Counseling Cases by Gender"
            },
            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0",
                indexLabel: "{label} - {y}",
                dataPoints: []
            }]
        });

        // Fetch data for course Pie Chart
        fetch('get_couns_data.php')
            .then(response => response.json())
            .then(data => {
                var dataPointsPieCourse = {};
                data.forEach(row => {
                    var course = row.course;
                    var count = parseInt(row.case_count);
                    if (!dataPointsPieCourse[course]) {
                        dataPointsPieCourse[course] = count;
                    } else {
                        dataPointsPieCourse[course] += count;
                    }
                });
                var seriesDataPieCourse = [];
                for (var course in dataPointsPieCourse) {
                    seriesDataPieCourse.push({ label: course, y: dataPointsPieCourse[course] });
                }
                coursePieChart.options.data[0].dataPoints = seriesDataPieCourse;
                coursePieChart.render();
            })
            .catch(error => {
                console.error('Error fetching data for course Pie Chart:', error);
            });

        // Fetch data for gender Pie Chart
        fetch('get_gender.php')
            .then(response => response.json())
            .then(data => {
                var dataPointsPieGender = [];
                var dataGender = data.gender_data;
                dataGender.forEach(row => {
                    var gender = row.stud_gender;
                    var count = parseInt(row.case_count);
                    dataPointsPieGender.push({ label: gender, y: count });
                });
                var seriesDataPieGender = [];
                seriesDataPieGender.push({ type: "pie", startAngle: 240, yValueFormatString: "##0", indexLabel: "{label} - {y}", dataPoints: dataPointsPieGender });
                genderPieChart.options.data = seriesDataPieGender;
                genderPieChart.render();
            })
            .catch(error => {
                console.error('Error fetching data for gender Pie Chart:', error);
            });
    }
</script>
</body>
</html>
