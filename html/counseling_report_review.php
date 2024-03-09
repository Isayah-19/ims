<?php
require('fpdf.php');
session_start();
include('config.php');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establish database connection
$db = mysqli_connect("localhost", "root", "", "imsdb");

if (!$_SESSION['Logged_In']) {
    header('Location:login.php');
    exit;
}

class PDF extends FPDF
{
    // Colored table
    public function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Times', '', 11);
        // Move to the right

        // Framed title

        $this->Image('images/dkut_logo.jpg', 15, 5, 30, 30);
        $this->Ln(3);
        $this->Cell(130, 10, 'Republic of Kenya', 0, 0, 'C');
        $this->SetFont('Times', 'B', 11);
        $this->Ln(2);
        $this->Cell(183, 15, 'Dedan Kimathi University of Technology', 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(133, 15, 'Main Campus', 0, 0, 'C'); // Line break
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(1);
        $this->Line(15, 40, 195, 40);

        $this->Ln(20);
    }

    // Colored table
    public function body($row)
    {
        $this->Cell(90);
        $this->Cell(18, 15, 'Student Information', 0, 0, 'C');
        $this->Ln(30);


        $fill = false;

        // Output student information
        $this->Cell(9, 9, 'Student Number: ' . $row['STUD_NO'], 0, 1, 'L', $fill);
        $this->Cell(9, 9, 'Student Name: ' . $row['STUD_NAME'], 0, 1, 'L', $fill);
        $this->Cell(9, 9, 'Counselor Name: ' . $row['COUNSELOR_FNAME'] . ' ' . $row['COUNSELOR_LNAME'], 0, 1, 'L', $fill);
        $this->Cell(9, 9, 'Counseling Type: ' . $row['COUNSELING_TYPE'], 0, 1, 'L', $fill);
        $this->Cell(9, 9, 'Nature of The Case: ' . $row['CASE_NATURE'], 0, 1, 'L', $fill);
        $this->Ln(10);
        $this->Write(9, 'Counseling Background: ' . $row['COUNSELING_BG'], false);
        $this->Ln(20);
        $this->Write(9, 'Goals: ' . $row['GOALS'], false);
        $this->Ln(20);
        $this->Write(9, 'Comments: ' . $row['COUNS_COMMENT'], false);
        $this->Ln(20);
        $this->Write(9, 'Recommendations: ' . $row['RECOMMENDATION'], false);
    }
}

if (isset($_REQUEST['view'])) {
    $id = $_REQUEST['view'];
    
    // Echo the SQL statement
    $sql = "
    SELECT
      `c`.`couns_code` AS `COUNSELING_CODE`,
      DATE_FORMAT(`c`.`couns_date`, '%W %M %d %Y') AS `COUNSELING_DATE`,
      `c`.`counseling_type` AS `COUNSELING_TYPE`,
      `c`.`nature_of_case` AS `CASE_NATURE`,
      `c`.`couns_appmnType` AS `APPOINTMENT_TYPE`,
      `s`.`stud_regNo` AS `STUD_NO`,
      `s`.`stud_fullName` AS `STUD_NAME`,
      CONCAT(
        `s`.`stud_course`,
        ' ',
        `s`.`stud_yrlevel`
      ) AS `COURSE`,
      (
        SELECT
          GROUP_CONCAT(`a`.`couns_appr` SEPARATOR ', ')
        FROM
          `couns_approach` `a`
        WHERE
          (
            `a`.`appr_id` = `c`.`apprcode`
          )
      ) AS `COUNSELING_APPROACH`,
      `c`.`couns_background` AS `COUNSELING_BG`,
      `c`.`couns_goals` AS `GOALS`,
      `c`.`couns_comment` AS `COUNS_COMMENT`,
      `c`.`couns_recommendation` AS `RECOMMENDATION`,
      `u`.`user_fname` AS `COUNSELOR_FNAME`,
      `u`.`user_lname` AS `COUNSELOR_LNAME`
    FROM
      `counseling` `c`
      JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `c`.`stud_regNo`
      JOIN `users` `u` ON `u`.`userId` = `c`.`counselor_id`
    WHERE
      `c`.`couns_code` = '$id'
  ";

  
    // Echo the SQL statement
   // echo "SQL Statement: <br>";
    //echo $sql;
    
    $sql_query = mysqli_query($db, $sql);
    if ($row = mysqli_fetch_array($sql_query)) {
        $pdf = new PDF();
        // Column headings
        // Data loading
        $pdf->SetFont('Arial', '', 14);
        $pdf->AddPage();
        $pdf->body($row);
        $pdf->Output('I', $row['STUD_NAME']);
    }
}
?>


