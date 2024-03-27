
<?php
require('fpdf.php');
session_start();
if (!$_SESSION['Logged_In']) {
    header('Location:login.php');
    exit;
}
$acadOpt = '';
$semOpt = '';
$monthOpt = '';
$dayOpt = '';
$courseOpt = '';
$result = '';
class PDF extends FPDF
{

// Colored table
private $acadOpt;
    private $semOpt;
    private $monthOpt;
    private $dayOpt;
    private $courseOpt;

    // Constructor to set options
    public function __construct($acadOpt, $semOpt, $monthOpt, $dayOpt, $courseOpt)
    {
        parent::__construct();
        $this->acadOpt = $acadOpt;
        $this->semOpt = $semOpt;
        $this->monthOpt = $monthOpt;
        $this->dayOpt = $dayOpt;
        $this->courseOpt = $courseOpt;
    }

    // Header with dynamic content based on options
    public function Header()
    {
        $this->SetFont('Times', '', 11);
        $this->Image('images/dkut_logo.jpg', 15, 5, 30, 30);
        $this->Ln(3);
        $this->Cell(130, 10, 'Republic of Kenya', 0, 0, 'C');
        $this->SetFont('Times', 'B', 11);
        $this->Ln(2);
        $this->Cell(183, 15, 'DEDAN KIMATHI UNIVERSITY OF TECHNOLOGY', 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(133, 15, 'MAIN CAMPUS', 0, 0, 'C');
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(1);
        $this->Line(15, 40, 195, 40);
        $this->Ln(20);

        // Header based on selected options
        $headerText = 'All Records'; // Default header text

        if (!empty($this->acadOpt) && $this->acadOpt != 'All') {
            $headerText = "Academic Year: {$this->acadOpt}";
        }

        if (!empty($this->semOpt) && $this->semOpt != 'All') {
            $headerText .= " - Semester: {$this->semOpt}";
        }

        if (!empty($this->monthOpt) && $this->monthOpt != 'All') {
            $headerText .= " - Month: {$this->monthOpt}";
        }

        if (!empty($this->dayOpt) && $this->dayOpt != 'All') {
            $headerText .= " - Day: {$this->dayOpt}";
        }

        if (!empty($this->courseOpt) && $this->courseOpt != 'All') {
            $headerText .= " - Course: {$this->courseOpt}";
        }

        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 15, $headerText, 0, 0, 'C');
        $this->Ln(20);
    }
    // Colored table
    public function FancyTable($body)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(50, 50, 50, 40);
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
        
        include ('config.php');

        // Check connection
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        if (isset($_REQUEST['view'])) {
            $acadOpt = $_REQUEST['acadOpt'];
            $semOpt = $_REQUEST['semOpt'];
            $monthOpt = $_REQUEST['monthOpt'];
            $dayOpt = $_REQUEST['dayOpt'];
            $courseOpt = $_REQUEST['courseOpt'];

            $actualQuery = " SELECT
  `s`.`stud_regNo` AS `STUD_NO`,
  `s`.`stud_fullname` AS `STUD_NAME`,
  `c`.`counseling_type` AS `COUNSELING_TYPE`,
  DATE_FORMAT(`c`.`couns_date`, '%M %d %Y') AS `COUNSELING_DATE`,
  (
    SELECT
      GROUP_CONCAT(`a`.`couns_appr` SEPARATOR ', ')
    FROM
      `couns_approach` `a`
    WHERE
      (
        `a`.`couns_apprcode` = `c`.`apprcode`
      )
  ) AS `COUNSELING_APPROACH`,
  `c`.`couns_background` AS `COUNSELING_BG`,
  `c`.`couns_goals` AS `GOALS`,
  `c`.`couns_comment` AS `COUNS_COMMENT`,
  `c`.`couns_recommendation` AS `RECOMMENDATION`
FROM
  `counseling` `c`
  /*JOIN `couns_details` `cd` ON `c`.`couns_Id` = `cd`.`counsId_ref`*/
  JOIN `stud_profile` `s` ON `s`.`stud_regNo` = `c`.`stud_regNo`
  JOIN `courses` `cr` ON `s`.`stud_course` = `cr`.`course_code` ";
    
    $options = array();
    
    if (!empty($acadOpt) && $acadOpt != 'All') {
        $options[] = "cr.course_curyr = '$acadOpt'";
    }

    if (!empty($semOpt) && $semOpt != 'All') {
        $options[] = "c.couns_sem =  '$semOpt'";
    } 

    if (!empty($monthOpt) && $monthOpt != 'All') {
        $options[] = "MONTH(c.couns_date) = '$monthOpt'";
    }

    if (!empty($dayOpt) && $dayOpt != 'All') {
        $options[] = "DAY(c.couns_date) = '$dayOpt'";
    }

    if (!empty($courseOpt) && $courseOpt != 'All') {
        $options[] = "s.stud_course = '$courseOpt'";
    }

    $query = $actualQuery;
    if (count($options)>0) {
        $query .= " WHERE ". implode(' AND ', $options);
    }

    $result = mysqli_query($db, $query);
    } else {
        $result =  mysqli_query($db, " SELECT
`s`.`stud_regNo` AS `STUD_NO`,
  `s`.`stud_fullname` AS `STUD_NAME`,
  `c`.`counseling_type` AS `COUNSELING_TYPE`,
  DATE_FORMAT(`c`.`couns_date`, '%M %d %Y') AS `COUNSELING_DATE`,
  
 
  
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
      JOIN `couns_details` `cd` ON
          (
              (
                  `c`.`couns_Id` = `cd`.`counsId_ref`
              )
          )
      )
  JOIN `stud_profile` `s` ON
      ((`s`.`stud_regNo` = `cd`.`stud_No`))
  )  ");
    }

        
        while ($row = mysqli_fetch_array($result)) {
            {
        $this->Cell($w[0], 7, $row[0], 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 7, $row[1], 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 7, $row[2], 'LR', 0, 'L', $fill);
        $counsDate = date('M d, Y', strtotime($row['COUNSELING_DATE']));
        $this->Cell($w[3], 7, $counsDate, 'LR', 0, 'L', $fill);

        $this->Ln();
        $fill = !$fill;
    }
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Retrieve filter options from the request
$acadOpt = $_REQUEST['acadOpt'] ?? '';
$semOpt = $_REQUEST['semOpt'] ?? '';
$monthOpt = $_REQUEST['monthOpt'] ?? '';
$dayOpt = $_REQUEST['dayOpt'] ?? '';
$courseOpt = $_REQUEST['courseOpt'] ?? '';

// Create PDF object with filter options
$pdf = new PDF($acadOpt, $semOpt, $monthOpt, $dayOpt, $courseOpt);

// Column headings
$body = array('Student Number', 'Student name', 'Type', 'Date');

// Data loading
$pdf->SetFont('Arial', '', 14);
$pdf->AddPage();
$pdf->FancyTable($body);
$pdf->Output('I', 'Counseling Report');

