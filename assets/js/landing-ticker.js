(function () {
  "use strict";

  var currentPath = (window.location.pathname || "").toLowerCase();
  if (/\/(login|register|signup)(\.html)?$/.test(currentPath)) {
    return;
  }

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

  var investmentLocations = [
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

  var investmentNamesByCountry = {
    US: ["Michael", "Ashley", "Jason", "Brittany", "Kayla"],
    GB: ["Oliver", "Harry", "Amelia", "George", "Sophie"],
    DE: ["Lukas", "Felix", "Hannah", "Leonie", "Jonas"],
    FR: ["Lucas", "Nicolas", "Camille", "Chloe", "Mathis"],
    IT: ["Lorenzo", "Matteo", "Giulia", "Francesca", "Alessio"],
    ZA: ["Sipho", "Thabo", "Lerato", "Nandi", "Sibusiso"],
    AU: ["Jack", "Charlotte", "Cooper", "Matilda", "Lachlan"],
    CA: ["Ethan", "Liam", "Noah", "Emma", "Chloe"],
    AR: ["Thiago", "Santiago", "Mateo", "Valentina", "Lucia"],
    SA: ["Faisal", "Khalid", "Noura", "Maha", "Abdullah"],
    MX: ["Jose", "Carlos", "Diego", "Fernanda", "Ximena"],
    SE: ["Liam", "William", "Maja", "Elsa", "Oscar"],
    ES: ["Alejandro", "Javier", "Lucia", "Carmen", "Sergio"],
    GR: ["Nikos", "Yannis", "Eleni", "Dimitris", "Sofia"],
    PT: ["Joao", "Tiago", "Ines", "Beatriz", "Rui"],
    AT: ["Lukas", "Florian", "Anna", "Katharina", "Tobias"],
    NL: ["Daan", "Sem", "Sanne", "Noa", "Bram"],
    CH: ["Luca", "Noah", "Lea", "Nina", "Jan"],
    BE: ["Louis", "Arthur", "Emma", "Nora", "Jules"],
    CY: ["Andreas", "Christos", "Maria", "Eleni", "Kyriakos"]
  };

  var withdrawalNamesByCountry = {
    NG: ["Chinedu", "Amina", "Tunde", "Ngozi", "Emeka"],
    GH: ["Kwame", "Akosua", "Kofi", "Ama", "Kojo"],
    KE: ["Wanjiku", "Otieno", "Achieng", "Kamau", "Njeri"],
    ZA: ["Themba", "Naledi", "Lethabo", "Kagiso", "Bongani"],
    EG: ["Youssef", "Mariam", "Karim", "Salma", "Mostafa"],
    SA: ["Fahad", "Reem", "Saud", "Layan", "Abdulrahman"],
    AE: ["Saeed", "Latifa", "Hamdan", "Noora", "Rashid"],
    IN: ["Aarav", "Priya", "Rohan", "Ananya", "Vivek"],
    PK: ["Hamza", "Ayesha", "Bilal", "Mahnoor", "Usman"],
    BD: ["Tanvir", "Nusrat", "Rakib", "Farzana", "Imran"],
    CN: ["Wei", "Li", "Jun", "Mei", "Hao"],
    JP: ["Haruto", "Yui", "Sota", "Aoi", "Ren"],
    KR: ["Minjun", "Seojun", "Jisoo", "Hyejin", "Jiho"],
    TH: ["Niran", "Anong", "Somchai", "Kanya", "Chaiya"],
    VN: ["Minh", "Lan", "Tuan", "Huong", "Quang"],
    ID: ["Budi", "Siti", "Agus", "Putri", "Dwi"],
    TR: ["Mehmet", "Elif", "Can", "Zeynep", "Emre"],
    BR: ["Rafael", "Camila", "Joao", "Beatriz", "Caio"],
    AR: ["Lautaro", "Julieta", "Bautista", "Martina", "Ignacio"],
    MX: ["Luis", "Valeria", "Mateo", "Daniela", "Andres"]
  };

  var withdrawalCountries = [
    { name: "Nigeria", code: "NG" },
    { name: "Ghana", code: "GH" },
    { name: "Kenya", code: "KE" },
    { name: "South Africa", code: "ZA" },
    { name: "Egypt", code: "EG" },
    { name: "Saudi Arabia", code: "SA" },
    { name: "United Arab Emirates", code: "AE" },
    { name: "India", code: "IN" },
    { name: "Pakistan", code: "PK" },
    { name: "Bangladesh", code: "BD" },
    { name: "China", code: "CN" },
    { name: "Japan", code: "JP" },
    { name: "South Korea", code: "KR" },
    { name: "Thailand", code: "TH" },
    { name: "Vietnam", code: "VN" },
    { name: "Indonesia", code: "ID" },
    { name: "Turkey", code: "TR" },
    { name: "Brazil", code: "BR" },
    { name: "Argentina", code: "AR" },
    { name: "Mexico", code: "MX" }
  ];

  var withdrawalProfiles = [];
  withdrawalCountries.forEach(function (country) {
    var names = withdrawalNamesByCountry[country.code] || [];
    names.forEach(function (name) {
      withdrawalProfiles.push({
        name: name,
        country: country.name,
        code: country.code
      });
    });
  });

  var fallbackNames = ["Alex", "Jordan", "Taylor", "Morgan", "Riley"];
  var investmentIntervalOptions = [7000, 12000, 20000];
  var withdrawalInterval = 15000;
  var positionModes = ["top-left", "top-right", "left-middle", "right-middle", "bottom-left", "bottom-right"];
  var investmentAmounts = ["$500", "$1,000", "$1,500", "$2,000", "$2,500", "$3,000", "$4,000", "$6,000", "$10,000"];
  var withdrawalAmounts = ["$250", "$450", "$700", "$950", "$1,200", "$1,850", "$2,400", "$3,200", "$4,600"];

  var ticker;
  var hideTimer;
  var coordinatorTimer;
  var activeMode = "bottom-right";
  var isShowing = false;
  var dueAt = {
    investment: 0,
    withdrawal: 0
  };

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

  function clamp(value, min, max) {
    return Math.max(min, Math.min(max, value));
  }

  function visibleRect(node) {
    var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
    var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
    if (!node) {
      return {
        left: 12,
        top: 12,
        right: viewportWidth - 12,
        bottom: viewportHeight - 12
      };
    }

    var rect = node.getBoundingClientRect();
    var left = Math.max(12, rect.left + 12);
    var top = Math.max(12, rect.top + 12);
    var right = Math.min(viewportWidth - 12, rect.right - 12);
    var bottom = Math.min(viewportHeight - 12, rect.bottom - 12);

    if (right <= left || bottom <= top) {
      return {
        left: 12,
        top: 12,
        right: viewportWidth - 12,
        bottom: viewportHeight - 12
      };
    }

    return {
      left: left,
      top: top,
      right: right,
      bottom: bottom
    };
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
      "font-size:14px;line-height:1.45;font-weight:700;display:flex;align-items:center;gap:10px;" +
      "visibility:hidden;opacity:0;pointer-events:none}" +
      ".etfx-live-ticker.show{visibility:visible;opacity:1;animation:etfxFadeIn .25s ease}" +
      ".etfx-live-ticker .ticker-flag{width:24px;height:18px;object-fit:cover;border-radius:3px;border:1px solid #d8e8de;flex:0 0 auto}" +
      ".etfx-live-ticker .ticker-flag-fallback{display:none;font-size:18px;line-height:1}" +
      ".etfx-live-ticker .ticker-content{color:#163120}" +
      ".etfx-live-ticker .ticker-name,.etfx-live-ticker .ticker-country{color:#0f7a4a;font-weight:800}" +
      ".etfx-live-ticker .ticker-action{font-weight:800;color:#0f7a4a}" +
      ".etfx-live-ticker .ticker-amount{color:#c9a24d;font-weight:800}" +
      "@keyframes etfxFadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}" +
      "@media (max-width: 575.98px){.etfx-live-ticker{max-width:min(92vw,360px)}}";
    document.head.appendChild(style);
  }

  function ensureTicker() {
    if (ticker) {
      return ticker;
    }

    ticker = document.createElement("div");
    ticker.className = "etfx-live-ticker";
    ticker.innerHTML = "<div class=\"ticker-content\"></div>";
    document.body.appendChild(ticker);
    return ticker;
  }

  function positionTicker(target, mode) {
    var tickerNode = ensureTicker();
    var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
    var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
    var rect = visibleRect(target);
    var tickerWidth = tickerNode.offsetWidth;
    var tickerHeight = tickerNode.offsetHeight;

    var maxLeft = Math.max(12, viewportWidth - tickerWidth - 12);
    var maxTop = Math.max(12, viewportHeight - tickerHeight - 12);

    var xLeft = clamp(rect.left, 12, maxLeft);
    var xRight = clamp(rect.right - tickerWidth, 12, maxLeft);
    var yTop = clamp(rect.top, 12, maxTop);
    var yMiddle = clamp(rect.top + (rect.bottom - rect.top - tickerHeight) / 2, 12, maxTop);
    var yBottom = clamp(rect.bottom - tickerHeight, 12, maxTop);

    var left = xRight;
    var top = yBottom;

    if (mode === "top-left") {
      left = xLeft;
      top = yTop;
    } else if (mode === "top-right") {
      left = xRight;
      top = yTop;
    } else if (mode === "left-middle") {
      left = xLeft;
      top = yMiddle;
    } else if (mode === "right-middle") {
      left = xRight;
      top = yMiddle;
    } else if (mode === "bottom-left") {
      left = xLeft;
      top = yBottom;
    }

    tickerNode.style.left = Math.round(left) + "px";
    tickerNode.style.top = Math.round(top) + "px";
    tickerNode.style.right = "auto";
    tickerNode.style.bottom = "auto";
  }

  function investmentPayload() {
    var location = randomFrom(investmentLocations);
    var names = investmentNamesByCountry[location.code] || fallbackNames;
    return {
      name: randomFrom(names),
      country: location.name,
      code: location.code,
      amount: randomFrom(investmentAmounts),
      actionText: "just invested"
    };
  }

  function withdrawalPayload() {
    var profile = randomFrom(withdrawalProfiles);
    return {
      name: profile.name,
      country: profile.country,
      code: profile.code,
      amount: randomFrom(withdrawalAmounts),
      actionText: "just withdrew"
    };
  }

  function renderMessage(kind) {
    var payload = kind === "withdrawal" ? withdrawalPayload() : investmentPayload();
    var flagCode = payload.code.toLowerCase();
    var tickerNode = ensureTicker();

    tickerNode.querySelector(".ticker-content").innerHTML =
      '<img class="ticker-flag" src="https://flagcdn.com/24x18/' +
      flagCode +
      '.png" srcset="https://flagcdn.com/48x36/' +
      flagCode +
      '.png 2x" alt="' +
      escapeHtml(payload.country) +
      ' flag">' +
      '<span class="ticker-flag-fallback">' +
      flagEmoji(payload.code) +
      "</span>" +
      '<span class="ticker-message"><span class="ticker-name">' +
      escapeHtml(payload.name) +
      '</span> from <span class="ticker-country">' +
      escapeHtml(payload.country) +
      '</span> <span class="ticker-action">' +
      payload.actionText +
      '</span> <span class="ticker-amount">' +
      payload.amount +
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

  function markNextDue(kind) {
    var now = Date.now();
    if (kind === "withdrawal") {
      dueAt.withdrawal = now + withdrawalInterval;
      return;
    }
    dueAt.investment = now + randomFrom(investmentIntervalOptions);
  }

  function nextReadyKind() {
    var now = Date.now();
    var investReady = now >= dueAt.investment;
    var withdrawReady = now >= dueAt.withdrawal;

    if (investReady && withdrawReady) {
      return dueAt.investment <= dueAt.withdrawal ? "investment" : "withdrawal";
    }
    if (investReady) {
      return "investment";
    }
    if (withdrawReady) {
      return "withdrawal";
    }
    return null;
  }

  function showTicker(kind) {
    var tickerNode = ensureTicker();
    isShowing = true;
    renderMessage(kind);
    activeMode = randomFrom(positionModes);
    positionTicker(currentViewportTarget(), activeMode);
    tickerNode.classList.add("show");

    if (hideTimer) {
      window.clearTimeout(hideTimer);
    }
    hideTimer = window.setTimeout(function () {
      tickerNode.classList.remove("show");
      isShowing = false;
    }, 5000);
  }

  function coordinateTick() {
    if (isShowing) {
      return;
    }
    var kind = nextReadyKind();
    if (!kind) {
      return;
    }
    showTicker(kind);
    markNextDue(kind);
  }

  function scheduleCoordinator() {
    if (coordinatorTimer) {
      window.clearInterval(coordinatorTimer);
    }
    coordinatorTimer = window.setInterval(coordinateTick, 800);
  }

  function bindRealtimePositioning() {
    var onScroll = function () {
      if (ticker && ticker.classList.contains("show")) {
        positionTicker(currentViewportTarget(), activeMode);
      }
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll);
  }

  function run() {
    ensureStyle();
    ensureTicker();
    bindRealtimePositioning();
    dueAt.investment = Date.now();
    dueAt.withdrawal = Date.now() + withdrawalInterval;
    coordinateTick();
    scheduleCoordinator();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", run);
  } else {
    run();
  }
})();
