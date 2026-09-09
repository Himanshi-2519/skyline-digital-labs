<?php
/**
 * student-handler.php
 * Receives the "I'm applying" career form via AJAX (POST), checks it on
 * the server, and SAVES it to data/student-applications.json so the owner
 * can see every application, separate from client project enquiries.
 */

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

// ---- Collect and clean input ----
$fullName = trim(strip_tags($_POST["fullName"] ?? ""));
$email    = trim($_POST["email"] ?? "");
$phone    = trim(strip_tags($_POST["phone"] ?? ""));
$role     = trim(strip_tags($_POST["role"] ?? ""));
$message  = trim(strip_tags($_POST["message"] ?? ""));

// ---- Server-side validation ----
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
    $errors[] = "Please tell us a little more about yourself.";
}

if (!empty($errors)) {
    echo json_encode(["success" => false, "message" => implode(" ", $errors)]);
    exit;
}

// ---- Save the application to its own file, separate from client leads ----
$application = [
    "id"        => uniqid(),
    "name"      => $fullName,
    "email"     => $email,
    "phone"     => $phone,
    "role"      => $role,
    "message"   => $message,
    "submitted" => date("Y-m-d H:i:s"),
];

$dataFile = __DIR__ . "/data/student-applications.json";
$existing = [];

if (file_exists($dataFile)) {
    $existingRaw = file_get_contents($dataFile);
    $existing = json_decode($existingRaw, true);
    if (!is_array($existing)) {
        $existing = [];
    }
}

$existing[] = $application;
$saved = @file_put_contents($dataFile, json_encode($existing, JSON_PRETTY_PRINT));

// ---- Also try to email the team (works once on real hosting) ----
$to      = "info@skylinedigitallabs.in";
$subject = "New career application from " . $fullName;

$body  = "New application received through the website careers form:\n\n";
$body .= "Name:    " . $fullName . "\n";
$body .= "Email:   " . $email . "\n";
$body .= "Phone:   " . ($phone !== "" ? $phone : "Not provided") . "\n";
$body .= "Role:    " . ($role !== "" ? $role : "Not specified") . "\n\n";
$body .= "Message:\n" . $message . "\n";

$headers = "From: no-reply@skylinedigitallabs.in\r\n";
$headers .= "Reply-To: " . $email . "\r\n";

@mail($to, $subject, $body, $headers);

if ($saved !== false) {
    echo json_encode(["success" => true, "message" => "Application submitted."]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "We couldn't save that right now. Please email us directly at info@skylinedigitallabs.in."
    ]);
}
