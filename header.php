<?php

$companyPhone = "+91 70163 88668";
$companyPhoneLink = "917016388668"; 
$companyEmail = "info@skylinedigitallabs.in";
$companyAddress = "Ahmedabad, Gujarat, India";
$companyLinkedin = "https://www.linkedin.com/company/skyline-digital-labs/";
$companyInstagram = "https://www.instagram.com/skylinedigitallabs";
$businessMessage = "Hello%20Skyline%20Digital%20Labs%2C%20I%20visited%20your%20website%20and%20would%20like%20to%20discuss%20a%20business%20project.%20Please%20share%20a%20convenient%20time%20to%20connect.%20Thank%20you.";
$jobMessage = "Hello%20Skyline%20Digital%20Labs%2C%20I%20am%20interested%20in%20a%20job%20opportunity%20with%20your%20team.%20I%20would%20like%20to%20share%20my%20profile%20and%20learn%20about%20current%20openings.%20Thank%20you.";
$companyWhatsapp = "https://wa.me/" . $companyPhoneLink . "?text=" . $businessMessage;
$jobsWhatsapp = "https://wa.me/" . $companyPhoneLink . "?text=" . $jobMessage;
$companyMaps = "https://www.google.com/maps/search/?api=1&query=Skyline+Digital+Labs+Ahmedabad";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Skyline Digital Labs | A Digital Solutions Company</title>
<meta name="description" content="Skyline Digital Labs is a digital solutions company in Ahmedabad building web and mobile products, AI-driven cybersecurity, digital marketing and placement training.">
<link rel="icon" type="image/png" sizes="64x64" href="images/favicon.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="sky-nav" id="skyNav">
  <div class="container sky-nav-inner">
    <a href="index.php" class="sky-logo">
      <img src="images/logo.png" alt="Skyline Digital Labs logo" class="sky-logo-mark">
      Skyline <span>Digital Labs</span>
    </a>

    <button class="sky-menu-btn" id="menuBtn" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <ul class="sky-links" id="skyLinks">
      <li><a href="index.php">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#work">Projects</a></li>
      <li><a href="#careers">Careers</a></li>
      <li><a href="#contact" class="sky-nav-cta">Contact us</a></li>
    </ul>
  </div>
</nav>
