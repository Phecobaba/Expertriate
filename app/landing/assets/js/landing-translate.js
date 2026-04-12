(function () {
  "use strict";

  var translateId = "etfx-google-translate";
  var scriptId = "etfx-google-translate-script";

  function topbarTarget() {
    return document.querySelector(".topbar-right");
  }

  function ensureContainer() {
    var target = topbarTarget();
    if (!target) {
      return null;
    }

    var existing = document.getElementById(translateId);
    if (existing) {
      return existing;
    }

    var wrap = document.createElement("div");
    wrap.className = "etfx-translate-wrap";

    var mount = document.createElement("div");
    mount.id = translateId;
    wrap.appendChild(mount);

    target.insertBefore(wrap, target.firstChild);
    return mount;
  }

  function initTranslateElement() {
    var mount = ensureContainer();
    if (!mount) {
      return;
    }

    if (!window.google || !window.google.translate || !window.google.translate.TranslateElement) {
      return;
    }

    if (mount.dataset.initialized === "1") {
      return;
    }

    new window.google.translate.TranslateElement(
      {
        pageLanguage: "en",
        autoDisplay: false
      },
      translateId
    );
    mount.dataset.initialized = "1";
  }

  function loadScript() {
    if (document.getElementById(scriptId)) {
      return;
    }
    var script = document.createElement("script");
    script.id = scriptId;
    script.async = true;
    script.src = "https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    document.head.appendChild(script);
  }

  function run() {
    if (!ensureContainer()) {
      return;
    }

    window.googleTranslateElementInit = initTranslateElement;

    if (window.google && window.google.translate && window.google.translate.TranslateElement) {
      initTranslateElement();
      return;
    }

    loadScript();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", run);
  } else {
    run();
  }
})();
