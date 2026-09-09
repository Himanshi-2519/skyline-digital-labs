<?php


// news leeter 
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$email = trim($_POST["email"] ?? "");

if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Please enter a valid email address."]);
    exit;
}


// save email to json file data 
$dataFile = __DIR__ . "/data/newsletter.json";
$existing = [];

if (file_exists($dataFile)) {
    $existingRaw = file_get_contents($dataFile);
    $existing = json_decode($existingRaw, true);
    if (!is_array($existing)) {
        $existing = [];
    }
}

// Don't save the same email twice in data -- show the message 
foreach ($existing as $entry) {
    if (strtolower($entry["email"]) === strtolower($email)) {
        echo json_encode(["success" => true, "message" => "Already subscribed."]);
        exit;
    }
}

$existing[] = [
    "email"       => $email,
    "subscribed"  => date("Y-m-d H:i:s"),
];

$saved = @file_put_contents($dataFile, json_encode($existing, JSON_PRETTY_PRINT));

if ($saved !== false) {
    echo json_encode(["success" => true, "message" => "Subscribed."]);
} else {
    echo json_encode(["success" => false, "message" => "Something went wrong. Please try again."]);
}
