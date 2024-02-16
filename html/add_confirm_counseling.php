
<?php
session_start(); 
include("config.php");

// Check if the counselor's ID is available in the session
if(isset($_SESSION['ID'])) {
    $_id = isset($_POST['_id']) ? $_POST['_id'] : '';
    $C_stud_name = $_POST['_name'];
    $C_stud_no = $_POST['_no'];
    $C_stud_course = $_POST['_course'];
    $C_stud_yr = $_POST['_yr'];
    $C_stud_email = $_POST['_email'];
    $C_stud_add = $_POST['_add'];
    $C_stud_cno = $_POST['_cno'];
    $C_couns_bg = $_POST['_bg'];
    $C_goals = $_POST['_goals'];
    $C_comments = $_POST['_comments'];
    $C_recomm = $_POST['_recomm'];
    $C_app = $_POST['_app'];
    $C_case = $_POST['_case'];
    $C_appmnType = $_POST['_appmnt'];
    var_dump($_POST); // Use this line to check the content of $_POST array

    $checkQueryAppr = "SELECT COUNT(*) AS count FROM couns_approach WHERE appr_id = '$C_app'";
    $resultAppr = mysqli_query($db, $checkQueryAppr);

    if (!$resultAppr) {
        die('SQL Error: ' . mysqli_error($db));
    }

    $rowAppr = mysqli_fetch_assoc($resultAppr);

    // Output the result
    echo "Count for appr_id: " . $rowAppr['count'];

    // Check if the _case value exists in the nature_of_case table

    $checkQueryCase = "SELECT COUNT(*) AS count FROM nature_of_case WHERE case_id = '$C_case'";
    $resultCase = mysqli_query($db, $checkQueryCase);

    if (!$resultCase) {
        die('SQL Error: ' . mysqli_error($db));
    }

    $rowCase = mysqli_fetch_assoc($resultCase);

    // Output the result
    echo "Count for _case: " . $rowCase['count'];

    if ($rowAppr['count'] > 0 && $rowCase['count'] > 0) {
        // Generate the couns_code
        $counsCode = generateCounsCode($db);

        // Retrieve counselor's ID from the session
        $counselor_id = $_SESSION['ID'];

        // Proceed with the INSERT operation including counselor's ID
        $sql = "INSERT INTO `counseling` (`couns_code`, `counselor_id`, `stud_regNo`, `apprcode`, `couns_background`,`couns_acadYr`,`couns_sem`,`counseling_type`,`nature_of_case`, `couns_goals`,  
                                          `couns_comment`, `couns_recommendation`, `couns_appmnType`, `couns_date`) 
                VALUES ('$counsCode', '$counselor_id', '$C_stud_no', '$C_app', '$C_couns_bg','2023-2024','Semester Two','Individual Counseling','$C_case', '$C_goals', '$C_comments', '$C_recomm', '$C_appmnType', CURRENT_TIMESTAMP)";

        $result = mysqli_query($db, $sql);

        if ($result) {
            // Redirect to counseling_page.php after successful insertion
            header('Location: counseling_page.php' . $redirect);
            exit(); // Ensure to stop further execution after redirection
        } else {
            echo "<p>Error occurred during insertion: " . mysqli_error($db) . "</p>";
        }
    } else {
        // Handle the cases where either appr_id or _case value doesn't exist in respective tables
        echo "<p>Invalid appr_id or _case value. Please check the provided values.</p>";
    }
} else {
    // If counselor's ID is not available in the session
    echo "Counselor ID not found in session.";
}

// Function to generate unique couns_code
function generateCounsCode($db) {
    // Retrieve the last couns code
    $lastCodeQuery = "SELECT couns_code FROM counseling ORDER BY couns_id DESC LIMIT 1";
    $lastCodeResult = mysqli_query($db, $lastCodeQuery);
    $lastCodeRow = mysqli_fetch_assoc($lastCodeResult);

    // Extract the numeric part and increment
    if ($lastCodeRow) {
        $numericPart = (int) substr($lastCodeRow['couns_code'], 3, 3) + 1;
    } else {
        // Start the numeric part from 20
        $numericPart = 22;
    }

    // Create a new code
    $newCode = 'CC' . str_pad($numericPart, 3, '0', STR_PAD_LEFT) . '-23/24';

    // Check if the new code already exists
    $codeExistsQuery = "SELECT COUNT(*) AS code_exists FROM counseling WHERE couns_code = '$newCode'";
    $codeExistsResult = mysqli_query($db, $codeExistsQuery);
    $codeExistsRow = mysqli_fetch_assoc($codeExistsResult);

    // Handle duplicate codes
    while ($codeExistsRow['code_exists'] > 0) {
        $numericPart++;
        $newCode = 'CC' . str_pad($numericPart, 3, '0', STR_PAD_LEFT) . '-23/24';
        $codeExistsResult = mysqli_query($db, $codeExistsQuery);
        $codeExistsRow = mysqli_fetch_assoc($codeExistsResult);
    }

    // Return the unique code
    return $newCode;
}

?>
