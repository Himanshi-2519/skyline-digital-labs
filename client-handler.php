<?php

// file location
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

//  get client data  clean input 
$fullName = trim(strip_tags($_POST["fullName"] ?? ""));
$email    = trim($_POST["email"] ?? "");
$phone    = trim(strip_tags($_POST["phone"] ?? ""));
$budget   = trim(strip_tags($_POST["budget"] ?? ""));
$message  = trim(strip_tags($_POST["message"] ?? ""));

// validations - server side 
$errors = [];

if ($fullName === "" || strlen($fullName) < 2) {
    $errors[] = "Please enter your full name.";
}
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}
if ($phone !== "" && !preg_match('/^[0-9]{10}$/', $phone)) {
    $errors[] = "Phone number should be exactly 10 digits.";
}
if ($message === "" || strlen($message) < 10) {
    $errors[] = "Please tell us a little more about the project.";
}

if (!empty($errors)) {
    echo json_encode(["success" => false, "message" => implode(" ", $errors)]);
    exit;
}


// save the data in json format
$enquiry = [
    "id"        => uniqid(),
    "name"      => $fullName,
    "email"     => $email,
    "phone"     => $phone,
    "budget"    => $budget,
    "message"   => $message,
    "submitted" => date("Y-m-d H:i:s"),
];

// save data file direcctory location 
$dataFile = __DIR__ . "/data/client-enquiries.json";
$existing = [];

if (file_exists($dataFile)) {
    $existingRaw = file_get_contents($dataFile);
    $existing = json_decode($existingRaw, true);
    if (!is_array($existing)) {
        $existing = [];
    }
}

$existing[] = $enquiry;
$saved = @file_put_contents($dataFile, json_encode($existing, JSON_PRETTY_PRINT));


// for send mail
// $to      = "info@skylinedigitallabs.in";

$to      = "hvm.rcti22@gmail.com";
$subject = "New project enquiry from " . $fullName;

$body  = "New enquiry received through the website contact form:\n\n";
$body .= "Name:    " . $fullName . "\n";
$body .= "Email:   " . $email . "\n";
$body .= "Phone:   " . ($phone !== "" ? $phone : "Not provided") . "\n";
$body .= "Budget:  " . ($budget !== "" ? $budget : "Not provided") . "\n\n";
$body .= "Message:\n" . $message . "\n";

// $headers = "From: no-reply@skylinedigitallabs.in\r\n";
$headers = "From: hvm.rcti22@gmail.com\r\n";
$headers .= "Reply-To: " . $email . "\r\n";


// save above files when no error 
@mail($to, $subject, $body, $headers); 

// succes and error message show 
if ($saved !== false) {
    echo json_encode(["success" => true, "message" => "Message sent."]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "We couldn't save that right now. Please email us directly at info@skylinedigitallabs.in."
    ]);
}
