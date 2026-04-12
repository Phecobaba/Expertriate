(function () {
  "use strict";

  var targets = [
    ".hero-area",
    "#plans",
    ".migrate-hosting",
    ".consult-area",
    ".dm-faq-section",
    ".hm-contact-area",
    ".dm-feedback",
    ".breadcrumb-area",
    ".footer"
  ];

  var locations = [
    { name: "United States", code: "US" },
    { name: "United Kingdom", code: "GB" },
    { name: "Germany", code: "DE" },
    { name: "France", code: "FR" },
    { name: "Italy", code: "IT" },
    { name: "South Africa", code: "ZA" },
    { name: "Australia", code: "AU" },
    { name: "Canada", code: "CA" },
    { name: "Argentina", code: "AR" },
    { name: "Saudi Arabia", code: "SA" },
    { name: "Mexico", code: "MX" },
    { name: "Sweden", code: "SE" },
    { name: "Spain", code: "ES" },
    { name: "Greece", code: "GR" },
    { name: "Portugal", code: "PT" },
    { name: "Austria", code: "AT" },
    { name: "Netherlands", code: "NL" },
    { name: "Switzerland", code: "CH" },
    { name: "Belgium", code: "BE" },
    { name: "Cyprus", code: "CY" }
  ];

  var investments = ["$500", "$1,000", "$1,500", "$2,000", "$2,500", "$3,000", "$4,000", "$6,000", "$10,000"];
  var ticker;

  function randomFrom(list) {
    return list[Math.floor(Math.random() * list.length)];
  }

  function flagEmoji(code) {
    return code
      .toUpperCase()
      .split("")
      .map(function (letter) {
        return String.fromCodePoint(letter.charCodeAt(0) + 127397);
      })
      .join("");
  }

  function ensureStyle() {
    if (document.getElementById("etfx-live-ticker-style")) {
      return;
    }
    var style = document.createElement("style");
    style.id = "etfx-live-ticker-style";
    style.textContent =
      ".etfx-live-ticker{" +
      "position:absolute;right:18px;bottom:16px;z-index:12;background:#fff;" +
      "border:1px solid #d8e8de;border-radius:12px;padding:10px 14px;" +
      "box-shadow:0 16px 30px rgba(15,122,74,.15);max-width:300px;" +
      "font-size:14px;line-height:1.4;display:none}" +
      ".etfx-live-ticker .ticker-flag{font-size:18px;margin-right:8px}" +
      ".etfx-live-ticker strong{color:#0f7a4a}" +
      ".etfx-live-ticker .ticker-amount{color:#c9a24d;font-weight:700}" +
      ".etfx-live-ticker.show{display:block;animation:etfxFadeIn .25s ease}" +
      "@keyframes etfxFadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}" +
      "@media (max-width: 575.98px){.etfx-live-ticker{left:12px;right:12px;max-width:none;bottom:12px}}";
    document.head.appendChild(style);
  }

  function ensureTicker() {
    if (ticker) {
      return ticker;
    }
    ticker = document.createElement("div");
    ticker.className = "etfx-live-ticker";
    ticker.innerHTML = "<div class=\"ticker-content\"></div>";
    return ticker;
  }

  function availableTargets() {
    return targets
      .map(function (selector) {
        return document.querySelector(selector);
      })
      .filter(function (node) {
        return !!node;
      });
  }

  function placeTicker(target) {
    if (!target) {
      return;
    }
    var computed = window.getComputedStyle(target);
    if (computed.position === "static") {
      target.style.position = "relative";
    }
    target.appendChild(ensureTicker());
  }

  function renderMessage() {
    var location = randomFrom(locations);
    var amount = randomFrom(investments);
    ensureTicker().querySelector(".ticker-content").innerHTML =
      "<span class=\"ticker-flag\">" +
      flagEmoji(location.code) +
      "</span>" +
      "Someone from <strong>" +
      location.name +
      "</strong> just invested <span class=\"ticker-amount\">" +
      amount +
      "</span>.";
  }

  function showTicker() {
    var allTargets = availableTargets();
    if (allTargets.length === 0) {
      return;
    }

    var target = randomFrom(allTargets);
    placeTicker(target);
    renderMessage();
    ensureTicker().classList.add("show");

    window.setTimeout(function () {
      ensureTicker().classList.remove("show");
    }, 4800);
  }

  function run() {
    ensureStyle();
    showTicker();
    window.setInterval(showTicker, Math.floor(Math.random() * (38000 - 10000 + 1)) + 10000);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", run);
  } else {
    run();
  }
})();

