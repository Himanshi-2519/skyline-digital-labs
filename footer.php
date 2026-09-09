<?php
?>
<footer class="sky-footer">
  <div class="container">
    <div class="sky-footer-top">
      <div class="sky-footer-brand">
        <a href="index.php" class="sky-logo">
          <img src="images/logo.png" alt="Skyline Digital Labs logo" class="sky-logo-mark">
          Skyline <span>Digital Labs</span>
        </a>
        <p>A digital solutions company in Ahmedabad, building clean products, guarding them with AI-driven security, and training the people who'll build the next ones.</p>
        <div class="sky-social">
          <a href="<?php echo $companyLinkedin; ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="<?php echo $companyInstagram; ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <div class="sky-whatsapp-wrap">
            <button type="button" class="sky-whatsapp-btn" id="whatsappMenuBtn" aria-expanded="false" aria-controls="whatsappMenu" aria-label="WhatsApp options"><i class="bi bi-whatsapp"></i></button>
            <div class="sky-whatsapp-menu" id="whatsappMenu">
              <a href="<?php echo $companyWhatsapp; ?>" target="_blank" rel="noopener">Business enquiry</a>
              <a href="<?php echo $jobsWhatsapp; ?>" target="_blank" rel="noopener">Job application</a>
            </div>
          </div>
          <a href="<?php echo $companyMaps; ?>" target="_blank" rel="noopener" aria-label="Find Skyline Digital Labs on Google Maps" title="Skyline Digital Labs on Maps"><i class="bi bi-geo-alt-fill"></i></a>
        </div>
      </div>

      <div class="sky-footer-col">
        <h4>Company</h4>
        <a href="#about">About</a>
        <a href="#work">Projects</a>
        <a href="#careers">Careers</a>
        <a href="#faq">FAQ</a>
      </div>

      <div class="sky-footer-col">
        <h4>Services</h4>
        <a href="#services">Web &amp; mobile development</a>
        <a href="#services">AI cybersecurity</a>
        <a href="#services">Digital marketing</a>
        <a href="#services">Placement training</a>
      </div>

      <div class="sky-footer-col">
        <h4>Get in touch</h4>
        <a href="mailto:<?php echo $companyEmail; ?>"><?php echo $companyEmail; ?></a>
        <a href="tel:+<?php echo $companyPhoneLink; ?>"><?php echo $companyPhone; ?></a>
        <span><i class="bi bi-geo-alt"></i> <?php echo $companyAddress; ?></span>
      </div>
    </div>

    <div class="sky-footer-newsletter">
      <div>
        <h4>Stay in the loop</h4>
        <p>Occasional notes on new work and openings. No spam.</p>
      </div>
      <form id="newsletterForm" class="sky-newsletter-form">
        <input type="email" id="newsletterEmail" placeholder="Enter your email" required>
        <button type="submit" aria-label="Subscribe"><i class="bi bi-arrow-right"></i></button>
      </form>
    </div>

    <div class="sky-footer-bottom">
      <span>&copy; <?php echo date("Y"); ?> Skyline Digital Labs. All rights reserved.</span>
      <span><a href="#" class="sky-footer-legal">Privacy Policy</a></span>
    </div>
  </div>
</footer>

<div class="sky-toast" id="skyToast" role="status" aria-live="polite">
  <i class="bi bi-check-circle-fill"></i>
  <span id="skyToastText">Done.</span>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
