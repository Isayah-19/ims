
<?php
require('fpdf.php');
session_start();
if (!$_SESSION['Logged_In']) {
    header('Location:login.php');
    exit;
}
$visitOpt = '';
$acadOpt = '';
$semOpt = '';
$monthOpt = '';
$dayOpt = '';
$courseOpt = '';
$result = '';
class PDF extends FPDF
{

// Colored table
    public function Header()
    {
    

        $this->SetFont('Times', '', 11);
        // Move to the right
    
        // Framed title
    
        $this->Image('images/dkut_logo.jpg', 15, 5, 30, 30);
        $this->Ln(3);
        $this->Cell(130, 10, 'Republic of Kenya', 0, 0, 'C');
        $this->SetFont('Times', 'B', 11);
        $this->Ln(2);
        $this->Cell(183, 15, 'DEDAN KIMATHI UNIVERSITY OF TECHNOLOGY', 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(133, 15, 'Main Campus', 0, 0, 'C');// Line break
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(1); 
        $this->Line(15,40,195,40);
        $this->Ln(20);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 15, 'Visit Reports', 0, 0, 'C');
        $this->Ln(20);
    }
    // Colored table
    public function FancyTable($body)
    {
        // Colors, line width and bold font
        $this->SetFillColor(48, 84, 150);
        $this->SetTextColor(255);
        //$this->SetDrawColor(100, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(45, 42, 40, 27, 34);
        for ($i=0;$i<count($body);$i++) {
            $this->Cell($w[$i], 7, $body[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
    
        $fill = false;
        // $conn = mysqli_connect("localhost", "root", "", "pupqcdb");
        include ('config.php');

        // Check connection
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        if (isset($_REQUEST['view'])) {
            $visitOpt = $_REQUEST['visitOpt'];
            $acadOpt = $_REQUEST['acadOpt'];
            $semOpt = $_REQUEST['semOpt'];
            $monthOpt = $_REQUEST['monthOpt'];
            $dayOpt = $_REQUEST['dayOpt'];
            $courseOpt = $_REQUEST['courseOpt'];

            $actualQuery = " SELECT
             `v`.`visit_purpose` AS `visit_purpose`,
             `s`.`Stud_NO` AS `Stud_NO`,
             `s`.`Stud_fullname` AS `STUDENT`,
            CONCAT(
              `s`.`stud_course`,
              ' ',
              `s`.`stud_yrlevel`,
              ' - ',
              `s`.`stud_yrlevel`
            ) AS `COURSE`,
            DATE_FORMAT(`v`.`visit_date`, '%M %e, %Y') AS `visit_date`
          FROM
          `visit` `v`
              JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `v`.`Stud_NO`
              JOIN `semester` `sem` ON `v`.`Visit_SEMESTER` = `sem`.`Semestral_NAME`
              JOIN `batch_details` `btch` ON `v`.`Visit_ACADEMIC_YEAR` = `btch`.`Batch_YEAR` ";
    
    $options = array();
    
    if (!empty($visitOpt) && $visitOpt != 'All') {
        $options[] = "v.visit_purpose = '$visitOpt'";
    }
    if (!empty($acadOpt) && $acadOpt != 'All') {
        $options[] = "btch.Batch_YEAR = '$acadOpt'";
    }

    if (!empty($semOpt) && $semOpt != 'All') {
        $options[] = "sem.Semestral_NAME =  '$semOpt'";
    } 

    if (!empty($monthOpt) && $monthOpt != 'All') {
        $options[] = "MONTH(v.visit_date) = '$monthOpt'";
    }

    if (!empty($dayOpt) && $dayOpt != 'All') {
        $options[] = "DAY(v.visit_date) = '$dayOpt'";
    }

    if (!empty($courseOpt) && $courseOpt != 'All') {
        $options[] = "s.stud_course = '$courseOpt'";
    }

    $query = $actualQuery;
    if (count($options)>0) {
        $query .= " WHERE ". implode(' AND ', $options) ." ORDER BY `v`.`visit_date` DESC" ;
    }

    $result = mysqli_query($db, $query);
    } else {
        $result =  mysqli_query($db, " SELECT
        `v`.`visit_purpose` AS `visit_purpose`,
             `s`.`stud_regNo` AS `stud_No`,
             `s`.`stud_fullname` AS `STUDENT`,
            CONCAT(
              `s`.`stud_course`,
              ' ',
              `s`.`stud_yrlevel`,
              ' - ',
              `s`.`stud_yrlevel`
            ) AS `COURSE`,
            DATE_FORMAT(`v`.`visit_date`, '%M %e, %Y') AS `visit_date`
      FROM
      `visit` `v`
          JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `v`.`stud_No`
          JOIN `semester` `sem` ON `v`.`Visit_SEMESTER` = `sem`.`Semestral_NAME`
          JOIN `batch_details` `btch` ON `v`.`Visit_ACADEMIC_YEAR` = `btch`.`Batch_YEAR`");
    }

        
        while ($row = mysqli_fetch_array($result)) {
            {
        $this->Cell($w[0], 7, $row[0], 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 7, $row[1], 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 7, $row[2], 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 7, $row[3], 'LR', 0, 'L', $fill);
        $this->Cell($w[4], 7, $row[4], 'LR', 0, 'L', $fill);
        $this->Ln();
        $fill = !$fill;
    }
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF();
// Column headings
$body = array('Visit Purpose','Student Number', 'Student name', 'Course', 'Date');
// Data loading
$pdf->SetFont('Arial', '', 12);
$pdf->AddPage();
$pdf->FancyTable($body);
$pdf->Output('I', 'Visit Report'); ?>
