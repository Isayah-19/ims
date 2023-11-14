<?php
require('fpdf.php');
session_start();
include ('config.php');
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
        $this->Cell(133, 15, 'Main Campus', 0, 0, 'C');// Line break
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(1);
        $this->Line(15, 40, 195, 40);

        $this->Ln(20);
    }
    // Colored table
    public function body()
    {
        $this->Cell(90);
        $this->Cell(18, 15, 'Student Information', 0, 0, 'C');
        $this->Ln(30);
    
   
        $fill = false;
        // $db = mysqli_connect("localhost", "root", "", "imsdb");
        include ('config.php');

        if (isset($_REQUEST['view'])) {
            $id = $_REQUEST['view'];
            $sql= mysqli_query($db, " SELECT
  `s`.`stud_regNo` AS `STUD_NO`,
  `s`.`stud_fullName` AS `STUD_NAME`,
  `c`.`counseling_type` AS `COUNSELING_TYPE`,
  `c`.`nature_of_case` AS `CASE_NATURE`,
  (
    SELECT
      GROUP_CONCAT(`a`.`couns_appr` SEPARATOR ', ')
    FROM
      `couns_approach` `a`
    WHERE
      (
        `a`.`couns_appr_code` = `c`.`appr_code`
      )
  ) AS `COUNSELING_APPROACH`,
  `c`.`couns_background` AS `COUNSELING_BG`,
  `c`.`couns_goals` AS `GOALS`,
  `c`.`couns_comment` AS `COUNS_COMMENT`,
  `c`.`couns_recommendation` AS `RECOMMENDATION`
FROM
  (
    (
      `counseling` `c`
      JOIN `couns_details` `cd` ON (
        (
          `c`.`couns_Id` = `cd`.`counsId_ref`
        )
      )
    )
    JOIN `stud_profile` `s` ON ((`s`.`stud_regNo` = `cd`.`stud_regNo`))
  )
where
  `c`.`couns_code` = '$id'");

            while ($row = mysqli_fetch_array($sql)) {
                $this->Cell(9, 9, 'Student Number: '.$row[0].'', 0, 1, 'L', $fill);
                $this->Cell(9, 9, 'Student Name: '.$row[1].'', 0, 1, 'L', $fill);
                $this->Cell(9, 9, 'Couseling Type: '.$row[2].'', 0, 1, 'L', $fill);
                $this->Cell(9, 9, 'Nature of The Case: '.$row[3].'', 0, 1, 'L', $fill);
                $this->Ln(10);
                $this->Write(9, 'Couseling Backgroud: '.$row[4].'', false);
                $this->Ln(20);
                $this->Write(9, 'Goals: '.$row[5].'', false);
                $this->Ln(20);
                $this->Write(9, 'Comments: '.$row[6].'', false);
                $this->Ln(20);
                $this->Write(9, 'Recommemdations: '.$row[7].'', false);
            }
        }
    }
}

if (isset($_REQUEST['view'])) {
    // $db = mysqli_connect("localhost", "root", "", "imsdb");
    $id = $_REQUEST['view'];
    $sql= mysqli_query($db, "SELECT
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
        `a`.`counsId_ref` = `c`.`couns_Id`
    )
) AS `COUNSELING_APPROACH`,
`c`.`couns_background` AS `COUNSELING_BG`,
`c`.`couns_goals` AS `GOALS`,
`c`.`couns_comment` AS `COUNS_COMMENT`,
`c`.`couns_recommendation` AS `RECOMMENDATION`
FROM
(
    (
        `counseling` `c`
    JOIN `couns_details` `cd` ON
        (
            (
                `c`.`couns_Id` = `cd`.`counsId_ref`
            )
        )
    )
JOIN `stud_profile` `s` ON
    ((`s`.`stud_regNo` = `cd`.`stud_regNo`))
)  where `c`.`couns_code` ='$id' ");
 
    while ($row = mysqli_fetch_array($sql)) {
        $name = $row['STUD_NAME'];
        $pdf = new PDF();
        // Column headings
        // Data loading
        $pdf->SetFont('Arial', '', 14);
        $pdf->AddPage();
        $pdf->Body();
        $pdf->Output('I', $name);
    }
}
