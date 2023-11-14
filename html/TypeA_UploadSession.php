<?php
    include 'config.php';
    if (isset($_POST['save'])) {
    $target_dir = "Files/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
     
    if($FileType != "docx" || $FileType != "pdf" || $FileType != "doc" || $FileType != "xls" || $FileType != "xlsx") {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $files = basename($_FILES["file"]["name"]);
    }else{
    echo "Error Uploading File";
    exit;
    }
    }else{
    echo "File Not Supported";
    exit;
    }
    $filename = $_POST['upload_filename'];
    $location = "Files/" . $files;
    $sqli = "INSERT INTO upload (upload,upload_category,upload_date,upload_filepath,UPLOAD_FILETYPE) 
    VALUES ('{$filename}','".$_POST['upload_category']."',CURRENT_TIMESTAMP(),'{$location}','".$_POST['upload_filetype']."')";
    $result = mysqli_query($db,$sqli);
    if ($result) {
        header('Location: TypeA_FilesAndDocuments.php' . $redirect);
    };
}
?>