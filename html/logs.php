<?php

require("config.php");
$result = mysqli_query($db, "SELECT * FROM counseling ORDER BY couns_Id ASC");
while($row=mysqli_fetch_array($result)){
echo "<div class='comments_content'>";
echo "<h4><a href='delete.php?id=" . $row['couns_Id'] . "'> X</a></h4>";
echo "<h1>" . $row['counseling_type'] . "</h1>";
echo "<h2>" . $row['couns_date'] . "</h2></br></br>";
echo "<h3>" . $row['couns_comment'] . "</h3>";
echo "</div>";
}
mysqli_close($db);

?>

<head>
	<style>

h1{
    font-size:16px;
    font-family:Verdana, Geneva, sans-serif;
    color:#4040E6;
    padding-bottom:0px;
    margin-bottom:0px;
}
h2{
    font-size:10px;
    font-family:Verdana, Geneva, sans-serif;
    color:#CECED6;
}
h3{
    font-size:12px;
    font-family:Verdana, Geneva, sans-serif;
    color:#75A3A3;
    padding-bottom:5px;
    margin-bottom:5px
}
h4{
    font-size:14px;
    font-family:Verdana, Geneva, sans-serif;
    color:#CECED6;
    text-decoration:none;
    float:right;
}

.comment_input{
	background:#CCC;
	margin:10px;
	padding:10px;
	border:1px solid #CCC;
}

.button{
	padding:5px 15px 5px 15px;
    background:#567373;
    color: #FFF;
	border-radius: 3px;
}

.button:hover{
	background:#4D9494;
}

a{
	text-decoration:none;
}

.comment_logs{
	margin:5px;
	padding:5px;
	border:1px solid #CCC;
}

.comments_content{
	margin:10px;
	padding:15px;
	border:1px solid #CCC;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
	</style>
</head>