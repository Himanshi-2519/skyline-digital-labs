# Skyline Digital Labs — Website v2

A redesigned, fully working version of the Skyline Digital Labs website, built with
real company data (logo, projects, contact details) pulled from the original site.

## What's real vs. what's new

**Pulled directly from the real company** (from the site, and your screen recording):
- Real logo (images/logo.png)
- Real tagline: "A digital solutions company"
- Real contact details: info@skylinedigitallabs.in, +91 70163 88668, Ahmedabad, Gujarat
- Real LinkedIn and Instagram links
- Real project names, images and category tags: Fire Buns, Aurora Mist, Kennies, Alex Portz Website
- Real FAQ questions and answers (project timeline, services offered, etc.)
- Real nav structure: Home, About, Services, Projects, Contact

**New / unique to this version** (not copied from the original):
- The audience toggle ("I'm a business" / "I'm a student")
- The lighting-up skyline hero animation
- The "From blueprint to skyline" process section
- The Careers section
- All service/project descriptions, taglines and quotes — rewritten in fresh words
- The success popup, animated FAQ accordion, animated hamburger menu

## A few honest notes

- **Project images** are cropped from your screen recording (compressed video),
  since I can't access the live site's actual image files. Quality is good enough
  to use, but if you can get the original hi-res project images from the company,
  swap them into `images/` — same filenames, so nothing else needs to change.
- **Address** — the real site only listed the city ("Ahmedabad"). I added
  ", Gujarat, India" for clarity. If there's a real street address, add it in
  `header.php` (the `$companyAddress` variable near the top).
- **Awards / recognition** — I did not invent fake awards or certifications, since
  I have no way to verify what the company has actually received. If you have real
  ones, tell me and I'll add a proper section for them.
- **WhatsApp link** uses the real phone number (`wa.me/917016388668`) — test it
  once live to confirm it opens correctly.

## Files

```
skyline-v2/
├── index.php              <- homepage (includes header.php + footer.php)
├── header.php               <- nav + all real company info in one place at the top
├── footer.php                <- footer, newsletter box, success toast
├── contact-handler.php        <- validates the form, SAVES it to data/enquiries.json,
│                                 also tries to email it
├── admin.php                   <- simple password-protected page to view submitted
│                                 enquiries (password: skyline2026 — change this!)
├── data/enquiries.json          <- where form submissions get saved (created automatically)
├── preview.html                  <- plain HTML copy, no PHP needed, double-click to view
├── css/style.css                  <- all styling
├── js/script.js                    <- all interactivity
└── images/                          <- logo + real project images
```

## How to run it (PHP needs a server)

`preview.html` opens directly in any browser — good for a quick look, but its form
won't actually save anywhere since that needs PHP.

For the real, fully working version:
1. Install **XAMPP** (free, xampp.org).
2. Put the `skyline-v2` folder inside XAMPP's `htdocs` folder.
3. Start Apache.
4. Visit `http://localhost/skyline-v2/index.php`.
5. Submit the contact form, then visit `http://localhost/skyline-v2/admin.php`
   (password: `skyline2026`) to see it saved — this is how the owner can check
   enquiries even before email sending is configured.

## Before going live

- Change the admin password in `admin.php`.
- Double-check the phone/email/address at the top of `header.php` are still correct.
- Swap in real, high-resolution project images if you get them from the company.
- Fill in the Careers section with real open roles (or remove it if there are none).

## Tools used

HTML5, CSS3, JavaScript, jQuery, PHP (includes, form handling, JSON file storage),
Bootstrap Icons, Google Fonts (Fraunces + Inter).


## Latest visual update

The homepage has been refreshed using the latest supplied reference images:
- Clear futuristic skyline hero image (no artificial blur)
- Web/mobile service image
- AI cybersecurity image
- Digital marketing image
- Social media image
- Placement & training image
- Supplied reference portrait used in client feedback
- Three additional distinct illustrated client avatars for the remaining feedback cards

The feedback cards now show stars only (numeric ratings removed). The awards area has been redesigned as visual cards with milestones, a quote, and service pillars. Two brand/work-related quotes are included across the awards and feedback areas. Responsive spacing, mobile navigation, service imagery, and testimonial presentation have also been polished.
