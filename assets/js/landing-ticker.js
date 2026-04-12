(function () {
  "use strict";

  var targetSelectors = [
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

  var firstNames = ["Liam", "Noah", "Emma", "Olivia", "Mason", "Sophia", "Ethan", "Ava", "Lucas", "Mia"];
  var lastNames = ["Johnson", "Smith", "Brown", "Taylor", "Anderson", "Thomas", "Walker", "White", "Martin", "Clark"];
  var investorNames = [];
  var intervalOptions = [7000, 12000, 20000];
  var spotClasses = ["spot-bottom-right", "spot-bottom-left", "spot-top-right"];
  var investments = ["$500", "$1,000", "$1,500", "$2,000", "$2,500", "$3,000", "$4,000", "$6,000", "$10,000"];
  var ticker;
  var hideTimer;
  var nextTimer;

  firstNames.forEach(function (first) {
    lastNames.forEach(function (last) {
      investorNames.push(first + " " + last);
    });
  });

  function randomFrom(list) {
    return list[Math.floor(Math.random() * list.length)];
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/\"/g, "&quot;")
      .replace(/'/g, "&#039;");
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

  function availableTargets() {
    return targetSelectors
      .map(function (selector) {
        return document.querySelector(selector);
      })
      .filter(function (node) {
        return !!node;
      });
  }

  function currentViewportTarget() {
    var sections = availableTargets();
    if (sections.length === 0) {
      return null;
    }

    var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
    var bestTarget = sections[0];
    var bestVisiblePixels = -1;

    sections.forEach(function (section) {
      var rect = section.getBoundingClientRect();
      var visiblePixels = Math.max(0, Math.min(rect.bottom, viewportHeight) - Math.max(rect.top, 0));
      if (visiblePixels > bestVisiblePixels) {
        bestVisiblePixels = visiblePixels;
        bestTarget = section;
      }
    });

    return bestTarget;
  }

  function ensureStyle() {
    if (document.getElementById("etfx-live-ticker-style")) {
      return;
    }

    var style = document.createElement("style");
    style.id = "etfx-live-ticker-style";
    style.textContent =
      ".etfx-live-ticker{" +
      "position:fixed;z-index:9999;background:#fff;" +
      "border:1px solid #d8e8de;border-radius:12px;padding:10px 14px;" +
      "box-shadow:0 16px 30px rgba(15,122,74,.15);max-width:360px;" +
      "font-size:14px;line-height:1.45;font-weight:700;display:none;opacity:0}" +
      ".etfx-live-ticker.show{display:flex;align-items:center;gap:10px;opacity:1;animation:etfxFadeIn .25s ease}" +
      ".etfx-live-ticker.spot-bottom-right{right:18px;bottom:16px}" +
      ".etfx-live-ticker.spot-bottom-left{left:18px;bottom:16px}" +
      ".etfx-live-ticker.spot-top-right{right:18px;top:86px}" +
      ".etfx-live-ticker .ticker-flag{width:24px;height:18px;object-fit:cover;border-radius:3px;border:1px solid #d8e8de;flex:0 0 auto}" +
      ".etfx-live-ticker .ticker-flag-fallback{display:none;font-size:18px;line-height:1}" +
      ".etfx-live-ticker .ticker-content{color:#163120}" +
      ".etfx-live-ticker .ticker-name,.etfx-live-ticker .ticker-country{color:#0f7a4a;font-weight:800}" +
      ".etfx-live-ticker .ticker-amount{color:#c9a24d;font-weight:800}" +
      "@keyframes etfxFadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}" +
      "@media (max-width: 575.98px){" +
      ".etfx-live-ticker,.etfx-live-ticker.spot-bottom-right,.etfx-live-ticker.spot-bottom-left,.etfx-live-ticker.spot-top-right{" +
      "left:12px;right:12px;bottom:12px;top:auto;max-width:none}" +
      "}";
    document.head.appendChild(style);
  }

  function ensureTicker() {
    if (ticker) {
      return ticker;
    }

    ticker = document.createElement("div");
    ticker.className = "etfx-live-ticker spot-bottom-right";
    ticker.innerHTML = "<div class=\"ticker-content\"></div>";
    document.body.appendChild(ticker);
    return ticker;
  }

  function applyViewportSpot() {
    var tickerNode = ensureTicker();
    var sections = availableTargets();
    var activeSection = currentViewportTarget();
    var index = sections.indexOf(activeSection);
    var nextSpot = index >= 0 ? spotClasses[index % spotClasses.length] : randomFrom(spotClasses);

    spotClasses.forEach(function (spotClass) {
      tickerNode.classList.remove(spotClass);
    });
    tickerNode.classList.add(nextSpot);
  }

  function renderMessage() {
    var name = randomFrom(investorNames);
    var location = randomFrom(locations);
    var amount = randomFrom(investments);
    var flagCode = location.code.toLowerCase();
    var tickerNode = ensureTicker();

    tickerNode.querySelector(".ticker-content").innerHTML =
      '<img class="ticker-flag" src="https://flagcdn.com/24x18/' +
      flagCode +
      '.png" srcset="https://flagcdn.com/48x36/' +
      flagCode +
      '.png 2x" alt="' +
      escapeHtml(location.name) +
      ' flag">' +
      '<span class="ticker-flag-fallback">' +
      flagEmoji(location.code) +
      "</span>" +
      '<span class="ticker-message"><span class="ticker-name">' +
      escapeHtml(name) +
      '</span> from <span class="ticker-country">' +
      escapeHtml(location.name) +
      '</span> just invested <span class="ticker-amount">' +
      amount +
      "</span>.</span>";

    var flagImg = tickerNode.querySelector(".ticker-flag");
    var fallback = tickerNode.querySelector(".ticker-flag-fallback");
    if (flagImg && fallback) {
      flagImg.addEventListener("error", function () {
        flagImg.style.display = "none";
        fallback.style.display = "inline-block";
      });
    }
  }

  function showTicker() {
    var tickerNode = ensureTicker();
    applyViewportSpot();
    renderMessage();
    tickerNode.classList.add("show");

    if (hideTimer) {
      window.clearTimeout(hideTimer);
    }
    hideTimer = window.setTimeout(function () {
      tickerNode.classList.remove("show");
    }, 5000);
  }

  function scheduleNext() {
    if (nextTimer) {
      window.clearTimeout(nextTimer);
    }
    nextTimer = window.setTimeout(function () {
      showTicker();
      scheduleNext();
    }, randomFrom(intervalOptions));
  }

  function bindRealtimePositioning() {
    var onScroll = function () {
      if (ticker && ticker.classList.contains("show")) {
        applyViewportSpot();
      }
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll);
  }

  function run() {
    ensureStyle();
    ensureTicker();
    bindRealtimePositioning();
    showTicker();
    scheduleNext();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", run);
  } else {
    run();
  }
})();
