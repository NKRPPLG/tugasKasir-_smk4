(function () {
  "use strict";

  var slides = Array.prototype.slice.call(document.querySelectorAll(".slide"));
  var stage = document.getElementById("stage");
  var toolbar = document.getElementById("toolbar");
  var nav = document.querySelector(".presentation-nav");
  var counter = document.getElementById("slideCounter");
  var progressBar = document.getElementById("progressBar");
  var outlinePanel = document.getElementById("outlinePanel");
  var outlineBackdrop = document.getElementById("outlineBackdrop");
  var outlineList = document.getElementById("outlineList");
  var outlineButton = document.getElementById("outlineButton");
  var outlineClose = document.getElementById("outlineClose");
  var fullscreenButton = document.getElementById("fullscreenButton");
  var currentSlide = 0;
  var touchStartX = null;

  if (slides.length === 0 || !stage) {
    return;
  }

  function slideFromHash() {
    var match = window.location.hash.match(/^#slide-(\d+)$/);

    if (!match) {
      return 0;
    }

    return Math.max(0, Math.min(slides.length - 1, parseInt(match[1], 10) - 1));
  }

  function setHash(index) {
    if (window.history && window.history.replaceState) {
      window.history.replaceState(null, "", "#slide-" + (index + 1));
    }
  }

  function updateOutline(index) {
    if (!outlineList) {
      return;
    }

    Array.prototype.forEach.call(outlineList.querySelectorAll("button"), function (button, buttonIndex) {
      button.classList.toggle("is-active", buttonIndex === index);
      button.setAttribute("aria-current", buttonIndex === index ? "true" : "false");
    });
  }

  function showSlide(index, options) {
    var settings = options || {};
    var nextIndex = Math.max(0, Math.min(slides.length - 1, index));

    slides.forEach(function (slide, slideIndex) {
      var active = slideIndex === nextIndex;

      slide.classList.toggle("is-active", active);
      slide.setAttribute("aria-hidden", active ? "false" : "true");
    });

    currentSlide = nextIndex;

    if (counter) {
      counter.textContent = (nextIndex + 1) + " / " + slides.length;
    }

    if (progressBar) {
      progressBar.style.width = (((nextIndex + 1) / slides.length) * 100) + "%";
    }

    Array.prototype.forEach.call(document.querySelectorAll('[data-action="prev"]'), function (button) {
      button.disabled = nextIndex === 0;
    });

    Array.prototype.forEach.call(document.querySelectorAll('[data-action="next"]'), function (button) {
      button.disabled = nextIndex === slides.length - 1;
    });

    slides[nextIndex].scrollTop = 0;
    updateOutline(nextIndex);

    if (settings.updateHash !== false) {
      setHash(nextIndex);
    }
  }

  function nextSlide() {
    showSlide(currentSlide + 1);
  }

  function prevSlide() {
    showSlide(currentSlide - 1);
  }

  function buildOutline() {
    if (!outlineList) {
      return;
    }

    slides.forEach(function (slide, index) {
      var item = document.createElement("li");
      var button = document.createElement("button");

      button.type = "button";
      button.textContent = slide.getAttribute("data-title") || "Slide " + (index + 1);
      button.addEventListener("click", function () {
        showSlide(index);
        closeOutline();
      });

      item.appendChild(button);
      outlineList.appendChild(item);
    });
  }

  function openOutline() {
    if (!outlinePanel || !outlineBackdrop) {
      return;
    }

    outlinePanel.classList.add("is-open");
    outlinePanel.setAttribute("aria-hidden", "false");
    outlineBackdrop.hidden = false;
    document.body.classList.add("outline-open");

    if (outlineButton) {
      outlineButton.setAttribute("aria-expanded", "true");
    }

    if (outlineClose) {
      outlineClose.focus();
    }
  }

  function closeOutline() {
    if (!outlinePanel || !outlineBackdrop) {
      return;
    }

    outlinePanel.classList.remove("is-open");
    outlinePanel.setAttribute("aria-hidden", "true");
    outlineBackdrop.hidden = true;
    document.body.classList.remove("outline-open");

    if (outlineButton) {
      outlineButton.setAttribute("aria-expanded", "false");
    }
  }

  function toggleOutline() {
    if (outlinePanel && outlinePanel.classList.contains("is-open")) {
      closeOutline();
    } else {
      openOutline();
    }
  }

  function updateFullscreenButton() {
    if (!fullscreenButton) {
      return;
    }

    fullscreenButton.textContent = document.fullscreenElement ? "Keluar Fullscreen" : "Fullscreen";
  }

  function toggleFullscreen() {
    if (!document.documentElement.requestFullscreen) {
      return;
    }

    if (document.fullscreenElement) {
      document.exitFullscreen();
      return;
    }

    document.documentElement.requestFullscreen().catch(function () {
      // Browser bisa menolak fullscreen; presentasi tetap berjalan normal.
    });
  }

  function fitStage() {
    if (!stage) {
      return;
    }

    var toolbarHeight = toolbar ? toolbar.offsetHeight : 64;
    var navHeight = nav ? nav.offsetHeight : 60;
    var availableWidth = Math.max(280, window.innerWidth - 40);
    var availableHeight = Math.max(320, window.innerHeight - toolbarHeight - navHeight - 32);

    if (window.innerWidth < 900) {
      stage.style.width = availableWidth + "px";
      stage.style.height = availableHeight + "px";
      return;
    }

    var width = Math.min(1400, availableWidth, (availableHeight * 16) / 9);

    stage.style.width = width + "px";
    stage.style.height = ((width * 9) / 16) + "px";
  }

  function isTypingTarget(target) {
    var tagName = (target.tagName || "").toLowerCase();

    return tagName === "input" || tagName === "textarea" || tagName === "select" || target.isContentEditable;
  }

  document.addEventListener("click", function (event) {
    var actionButton = event.target.closest("[data-action]");

    if (!actionButton) {
      return;
    }

    if (actionButton.getAttribute("data-action") === "next") {
      nextSlide();
    }

    if (actionButton.getAttribute("data-action") === "prev") {
      prevSlide();
    }
  });

  if (outlineButton) {
    outlineButton.addEventListener("click", toggleOutline);
  }

  if (outlineClose) {
    outlineClose.addEventListener("click", closeOutline);
  }

  if (outlineBackdrop) {
    outlineBackdrop.addEventListener("click", closeOutline);
  }

  if (fullscreenButton) {
    fullscreenButton.addEventListener("click", toggleFullscreen);
  }

  document.addEventListener("fullscreenchange", updateFullscreenButton);

  document.addEventListener("keydown", function (event) {
    if (isTypingTarget(event.target)) {
      return;
    }

    var key = event.key;

    if (key === "ArrowRight" || key === "ArrowDown" || key === " " || key === "PageDown") {
      event.preventDefault();
      nextSlide();
      return;
    }

    if (key === "ArrowLeft" || key === "ArrowUp" || key === "PageUp") {
      event.preventDefault();
      prevSlide();
      return;
    }

    if (key === "Home") {
      event.preventDefault();
      showSlide(0);
      return;
    }

    if (key === "End") {
      event.preventDefault();
      showSlide(slides.length - 1);
      return;
    }

    if (key === "f" || key === "F") {
      event.preventDefault();
      toggleFullscreen();
      return;
    }

    if (key === "o" || key === "O") {
      event.preventDefault();
      toggleOutline();
      return;
    }

    if (key === "Escape") {
      if (outlinePanel && outlinePanel.classList.contains("is-open")) {
        closeOutline();
      }
    }
  });

  window.addEventListener("hashchange", function () {
    showSlide(slideFromHash(), { updateHash: false });
  });

  window.addEventListener("resize", fitStage);
  window.addEventListener("load", fitStage);

  if (stage) {
    stage.addEventListener("touchstart", function (event) {
      if (event.touches.length === 1) {
        touchStartX = event.touches[0].clientX;
      }
    }, { passive: true });

    stage.addEventListener("touchend", function (event) {
      if (touchStartX === null) {
        return;
      }

      var distance = event.changedTouches[0].clientX - touchStartX;

      if (Math.abs(distance) > 50) {
        if (distance < 0) {
          nextSlide();
        } else {
          prevSlide();
        }
      }

      touchStartX = null;
    }, { passive: true });
  }

  buildOutline();
  updateFullscreenButton();
  fitStage();
  showSlide(slideFromHash(), { updateHash: false });
})();
