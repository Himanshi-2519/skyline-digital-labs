$(function () {

  /*  1. Hero word swap (unique small touch, no external library)  */
  var heroWords = ["skyline", "product", "brand", "future"];
  var heroWordIndex = 0;
  setInterval(function () {
    heroWordIndex = (heroWordIndex + 1) % heroWords.length;
    $("#heroWord").fadeOut(200, function () {
      $(this).text(heroWords[heroWordIndex]).fadeIn(200);
    });
  }, 2600);

  /*  3. Audience toggle  */
  $("#toggleBusiness").on("click", function () {
    $(this).addClass("is-active").attr("aria-selected", "true");
    $("#toggleStudent").removeClass("is-active").attr("aria-selected", "false");
    $(".sky-toggle").removeClass("is-student");
    $("#panelStudent").addClass("is-hidden");
    $("#panelBusiness").removeClass("is-hidden");
  });
  $("#toggleStudent").on("click", function () {
    $(this).addClass("is-active").attr("aria-selected", "true");
    $("#toggleBusiness").removeClass("is-active").attr("aria-selected", "false");
    $(".sky-toggle").addClass("is-student");
    $("#panelBusiness").addClass("is-hidden");
    $("#panelStudent").removeClass("is-hidden");
  });

  /*  4. Animated hamburger + mobile menu  */
  $("#menuBtn").on("click", function () {
    $(this).toggleClass("is-open");
    var isOpen = $("#skyLinks").toggleClass("is-open").hasClass("is-open");
    $(this).attr("aria-expanded", isOpen);
  });
  $("#skyLinks a").on("click", function () {
    $("#skyLinks").removeClass("is-open");
    $("#menuBtn").removeClass("is-open").attr("aria-expanded", "false");
  });

  /*  5. Custom FAQ accordion with animation  */
  // Prepare FAQ answers once, then reveal each word at a comfortable reading speed.
  $(".sky-faq-answer p").each(function () {
    var $p = $(this);
    var words = $p.text().trim().split(/\s+/);
    $p.empty();
    $.each(words, function (i, word) {
      var $word = $("<span>").addClass("sky-faq-word").text(word).css("transition-delay", (i * 68) + "ms");
      $p.append($word);
      if (i < words.length - 1) $p.append(document.createTextNode(" "));
    });
  });

  $(".sky-faq-question").on("click", function () {
    var $item = $(this).closest(".sky-faq-item");
    var wasOpen = $item.hasClass("is-open");
    $(".sky-faq-item").removeClass("is-open");
    if (!wasOpen) {
      // Restart the word reveal every time the answer is opened.
      $item.find(".sky-faq-word").css("transition", "none");
      $item[0].offsetHeight;
      $item.find(".sky-faq-word").css("transition", "");
      $item.addClass("is-open");
    }
  });

  /*  6. Scroll reveal + stat counters  */
  var revealEls = document.querySelectorAll(".reveal");
  var statEls = document.querySelectorAll(".sky-stat-num");
  var statsCounted = false;

  function animateStats() {
    if (statsCounted) return;
    statsCounted = true;
    statEls.forEach(function (el) {
      var target = parseInt(el.getAttribute("data-count"), 10);
      var current = 0;
      var step = Math.max(1, Math.round(target / 40));
      var timer = setInterval(function () {
        current += step;
        if (current >= target) { current = target; clearInterval(timer); }
        el.textContent = current;
      }, 25);
    });
  }

  if ("IntersectionObserver" in window) {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    revealEls.forEach(function (el) { revealObserver.observe(el); });

    var statsObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { animateStats(); statsObserver.disconnect(); }
      });
    }, { threshold: 0.4 });
    var statsSection = document.querySelector(".sky-stats");
    if (statsSection) statsObserver.observe(statsSection);
  } else {
    revealEls.forEach(function (el) { el.classList.add("is-visible"); });
    animateStats();
  }

  /*  7. Phone fields: numbers only, 10 digits max (both forms)  */
  $(".sky-phone-input").on("input", function () {
    var digitsOnly = $(this).val().replace(/[^0-9]/g, "").slice(0, 10);
    $(this).val(digitsOnly);
  });

  /*  8. Client vs Student form tab switch  */
  $("#tabClient").on("click", function () {
    $(this).addClass("is-active").attr("aria-selected", "true");
    $("#tabStudent").removeClass("is-active").attr("aria-selected", "false");
    $(".sky-form-toggle").removeClass("is-student");
    $("#studentForm").addClass("is-hidden");
    $("#clientForm").removeClass("is-hidden");
  });
  $("#tabStudent").on("click", function () {
    $(this).addClass("is-active").attr("aria-selected", "true");
    $("#tabClient").removeClass("is-active").attr("aria-selected", "false");
    $(".sky-form-toggle").addClass("is-student");
    $("#clientForm").addClass("is-hidden");
    $("#studentForm").removeClass("is-hidden");
  });

  /*  9. Shared form submit handler (works for both client + student forms)  */
  function handleFormSubmit($form) {
    var formId = $form.attr("id");
    var handlerUrl = $form.data("handler");
    var isValid = true;

    $form.find(".sky-error").text("");

    var name = $form.find("input[name=fullName]").val().trim();
    var email = $form.find("input[name=email]").val().trim();
    var phone = $form.find("input[name=phone]").val().trim();
    var message = $form.find("textarea[name=message]").val().trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (name === "") {
      $form.find(".sky-error").eq(0).text("Enter your name.");
      isValid = false;
    }
    if (email === "" || !emailPattern.test(email)) {
      $form.find(".sky-error").eq(1).text("Enter a valid email.");
      isValid = false;
    }
    if (phone !== "" && phone.length !== 10) {
      $form.find(".sky-error").eq(2).text("Phone number must be 10 digits.");
      isValid = false;
    }
    if (message === "") {
      $form.find(".sky-error").eq(3).text("Please fill this in.");
      isValid = false;
    }
    if (!isValid) return;

    var $status = $form.find(".sky-form-status");
    var $btn = $form.find("button[type=submit]");
    $btn.addClass("is-loading").prop("disabled", true);
    $status.removeClass("is-error").text("");

    $.ajax({
      url: handlerUrl,
      method: "POST",
      data: $form.serialize(),
      dataType: "json"
    }).done(function (res) {
      if (res && res.success) {
        $form[0].reset();
        showSuccessPopup(formId === "studentForm" ? "student" : "client");
      } else {
        $status.addClass("is-error").text((res && res.message) || "Something went wrong. Try again.");
      }
    }).fail(function () {
      $status.addClass("is-error").text("Couldn't reach the server. Check your connection and try again.");
    }).always(function () {
      $btn.removeClass("is-loading").prop("disabled", false);
    });
  }

  $("#clientForm, #studentForm").on("submit", function (e) {
    e.preventDefault();
    handleFormSubmit($(this));
  });

  function showSuccessPopup(kind) {
    var title = kind === "student" ? "Application submitted successfully!" : "Message sent successfully!";
    var body = kind === "student"
      ? "Thanks for applying. We'll review it and reach out if there's a fit."
      : "Thanks for reaching out. Our team will get back to you within one business day.";
    $("#successTitle").text(title);
    $("#successBackdrop p").text(body);
    $("#successBackdrop").addClass("is-visible");
  }
  $("#closeSuccess, #successBackdrop").on("click", function (e) {
    if (e.target === this) { $("#successBackdrop").removeClass("is-visible"); }
  });

  /*  10. Newsletter signup - actually saved to the server  */
  $("#newsletterForm").on("submit", function (e) {
    e.preventDefault();
    var $form = $(this);
    var email = $("#newsletterEmail").val().trim();
    if (email === "") return;

    $.ajax({
      url: "newsletter-handler.php",
      method: "POST",
      data: { email: email },
      dataType: "json"
    }).done(function (res) {
      if (res && res.success) {
        showToast("Subscribed! Thanks for staying in the loop.");
        $form[0].reset();
      } else {
        showToast((res && res.message) || "Something went wrong. Try again.");
      }
    }).fail(function () {
      showToast("Couldn't reach the server. Try again.");
    });
  });

  function showToast(text) {
    $("#skyToastText").text(text);
    $("#skyToast").addClass("is-visible");
    setTimeout(function () { $("#skyToast").removeClass("is-visible"); }, 3200);
  }

  /*  11. Testimonial carousel (horizontal, center slide focused)  */
  var $testiCarousel = $(".sky-testi-carousel");
  var $testiTrack = $("#testiTrack");
  var $testiSlides = $(".sky-testi-slide");
  var $testiDots = $(".sky-testi-dot");
  var testiIndex = 0;
  var testiTimer;

  function moveTestiTrack() {
    var $activeSlide = $testiSlides.eq(testiIndex);
    var slideWidth = $activeSlide.outerWidth(true);
    var carouselWidth = $testiCarousel.width();
    var slideLeft = $activeSlide.position().left;
    var offset = (carouselWidth / 2) - (slideLeft + slideWidth / 2);
    $testiTrack.css("transform", "translateX(" + offset + "px)");
  }

  function showTesti(index) {
    testiIndex = (index + $testiSlides.length) % $testiSlides.length;
    $testiSlides.removeClass("is-active").eq(testiIndex).addClass("is-active");
    $testiDots.removeClass("is-active").eq(testiIndex).addClass("is-active");
    moveTestiTrack();
  }

  function nextTesti() {
    showTesti(testiIndex + 1);
  }

  function startTestiAutoplay() {
    testiTimer = setInterval(nextTesti, 6200);
  }
  function stopTestiAutoplay() {
    clearInterval(testiTimer);
  }

  $("#testiNext").on("click", function () {
    stopTestiAutoplay();
    nextTesti();
    startTestiAutoplay();
  });
  $("#testiPrev").on("click", function () {
    stopTestiAutoplay();
    showTesti(testiIndex - 1);
    startTestiAutoplay();
  });
  $testiDots.on("click", function () {
    stopTestiAutoplay();
    showTesti($(this).data("slide"));
    startTestiAutoplay();
  });
  $testiSlides.on("click", function () {
    stopTestiAutoplay();
    showTesti($testiSlides.index(this));
    startTestiAutoplay();
  });
  $testiSlides.on("keydown", function (e) {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      $(this).trigger("click");
    }
  });
  $(window).on("resize", moveTestiTrack);

  if ($testiSlides.length > 0) {
    showTesti(0);
    startTestiAutoplay();
  }

});

/*  12. Word-by-word work descriptions  */
function prepareWordReveal() {
  document.querySelectorAll('.sky-word-reveal').forEach(function (el) {
    if (el.dataset.wordsReady === '1') return;
    var text = el.textContent.trim().split(/\s+/);
    el.textContent = '';
    text.forEach(function (word, i) {
      var span = document.createElement('span');
      span.className = 'sky-word';
      span.textContent = word;
      span.style.transitionDelay = (i * 82) + 'ms';
      el.appendChild(span);
      if (i < text.length - 1) el.appendChild(document.createTextNode(' '));
    });
    el.dataset.wordsReady = '1';
  });
}
prepareWordReveal();

if ('IntersectionObserver' in window) {
  var wordObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-word-visible');
        wordObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.35 });
  document.querySelectorAll('.sky-word-reveal').forEach(function (el) { wordObserver.observe(el); });
} else {
  document.querySelectorAll('.sky-word-reveal').forEach(function (el) { el.classList.add('is-word-visible'); });
}

/*  13. Real-photo fallback for remote testimonial images  */
$('.sky-testi-avatar img').on('error', function () {
  var fallback = 'images/feedback/client-reference.jpg';
  if (this.src.indexOf(fallback) === -1) this.src = fallback;
});


/*  14. WhatsApp choice: business or job  */
$(document).on('click', '#whatsappMenuBtn', function (e) {
  e.stopPropagation();
  var $menu = $('#whatsappMenu');
  var isOpen = $menu.hasClass('is-open');
  $menu.toggleClass('is-open', !isOpen);
  $(this).attr('aria-expanded', String(!isOpen));
});
$(document).on('click', function () {
  $('#whatsappMenu').removeClass('is-open');
  $('#whatsappMenuBtn').attr('aria-expanded', 'false');
});
$(document).on('click', '#whatsappMenu a', function () {
  $('#whatsappMenu').removeClass('is-open');
  $('#whatsappMenuBtn').attr('aria-expanded', 'false');
});
