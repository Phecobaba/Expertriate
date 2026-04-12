(function () {
  "use strict";

  var planRoot = document.getElementById("etfx-plan-list");
  if (!planRoot) {
    return;
  }

  var fallbackPlans = [
    {
      name: "STARTER PLAN",
      return_rate: "10%",
      return_duration: "after 24hours",
      min_amount: 100,
      max_amount: 1999,
      badge_text: "24/7 support",
      features: ["Active Support", "Income Booster", "Fast Payouts", "Advanced mining algorithm", "5% referral commission", "Easy and convenient", "Instant withdrawal"],
      cta_text: "Purchase Plan",
      cta_url: "/app/register",
      is_recommended: false
    },
    {
      name: "AMATEUR PLAN",
      return_rate: "30%",
      return_duration: "after 48hours",
      min_amount: 2000,
      max_amount: 4999,
      badge_text: "24/7 support",
      features: ["Active Support", "Income Booster", "Fast Payouts", "Advanced mining algorithm", "5% referral commission", "Easy and convenient", "Instant withdrawal"],
      cta_text: "Purchase Plan",
      cta_url: "/app/register",
      is_recommended: true
    },
    {
      name: "PROFESSIONAL PLAN",
      return_rate: "50%",
      return_duration: "after 96hours",
      min_amount: 5000,
      max_amount: 9999,
      badge_text: "24/7 support",
      features: ["Active Support", "Income Booster", "Fast Payouts", "Advanced mining algorithm", "5% referral commission", "Easy and convenient", "Instant withdrawal"],
      cta_text: "Purchase Plan",
      cta_url: "/app/register",
      is_recommended: false
    },
    {
      name: "EXPERT PLAN",
      return_rate: "70%",
      return_duration: "after 168hours",
      min_amount: 10000,
      max_amount: null,
      badge_text: "24/7 support",
      features: ["Active Support", "Income Booster", "Fast Payouts", "Advanced mining algorithm", "5% referral commission", "Easy and convenient", "Instant withdrawal"],
      cta_text: "Purchase Plan",
      cta_url: "/app/register",
      is_recommended: false
    },
    {
      name: "LONG-TERM PLAN",
      return_rate: "350%",
      return_duration: "after 336hours",
      min_amount: 2000,
      max_amount: null,
      badge_text: "24/7 support",
      features: ["Active Support", "Income Booster", "Fast Payouts", "Advanced mining algorithm", "5% referral commission", "Easy and convenient", "Instant withdrawal"],
      cta_text: "Purchase Plan",
      cta_url: "/app/register",
      is_recommended: false
    }
  ];

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/\"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function formatAmount(value) {
    if (value === null || value === undefined || value === "") {
      return "Unlimited";
    }
    var parsed = Number(value);
    if (isNaN(parsed)) {
      return escapeHtml(value);
    }
    return "$" + parsed.toLocaleString();
  }

  function featureListHtml(features) {
    if (!Array.isArray(features) || features.length === 0) {
      return "";
    }
    return features
      .map(function (feature) {
        return (
          '<li><span class="me-2"><i class="fa-solid fa-check"></i></span>' +
          escapeHtml(feature) +
          "</li>"
        );
      })
      .join("");
  }

  function planCardHtml(plan) {
    var cardClass = plan.is_recommended ? "pricing-column overflow-hidden position-relative bg-white rounded-10 deep-shadow plan-recommended" : "pricing-column overflow-hidden position-relative bg-white rounded-10 deep-shadow";
    var ctaUrl = plan.cta_url || "/app/register";
    var ctaText = plan.cta_text || "Purchase Plan";
    var badgeText = plan.badge_text || "24/7 support";
    var recommendedLabel = plan.is_recommended ? '<span class="pricing-pill-recommended rounded">Recommended</span>' : "";

    return (
      '<div class="col-4 col-md-6 col-lg-4 etfx-plan-col">' +
      '<div class="' + cardClass + '">' +
      '<div class="pricing-label-row">' +
      '<span class="pricing-badge rounded"><span class="gradient-txt">' + escapeHtml(badgeText) + "</span></span>" +
      recommendedLabel +
      "</div>" +
      "<h3 class=\"h5\">" + escapeHtml(plan.name) + "</h3>" +
      '<h4 class="h2 mt-2 monthly-price">' + escapeHtml(plan.return_rate) + " <span>" + escapeHtml(plan.return_duration) + "</span></h4>" +
      '<p class="mt-4">Min: ' + formatAmount(plan.min_amount) + " - Max: " + formatAmount(plan.max_amount) + "</p>" +
      '<ul class="feature-list mt-4">' + featureListHtml(plan.features) + "</ul>" +
      '<a href="' + escapeHtml(ctaUrl) + '" class="template-btn secondary-btn w-100 text-center mt-40">' + escapeHtml(ctaText) + "</a>" +
      "</div></div>"
    );
  }

  function renderPlans(plans) {
    if (!Array.isArray(plans) || plans.length === 0) {
      plans = fallbackPlans;
    }
    planRoot.innerHTML = plans.map(planCardHtml).join("");
  }

  function requestEndpoint(endpoint) {
    var cacheBuster = endpoint.indexOf("?") === -1 ? "?" : "&";
    var requestUrl = endpoint + cacheBuster + "_lp_ts=" + Date.now();

    return fetch(requestUrl, {
      method: "GET",
      headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "Cache-Control": "no-cache"
      },
      cache: "no-store"
    }).then(function (response) {
      if (!response.ok) {
        throw new Error("Unable to load plans");
      }
      return response.text().then(function (text) {
        try {
          return JSON.parse(text);
        } catch (error) {
          throw new Error("Invalid plans response");
        }
      });
    });
  }

  function uniqueEndpoints(items) {
    var seen = {};
    return items.filter(function (item) {
      if (!item || seen[item]) {
        return false;
      }
      seen[item] = true;
      return true;
    });
  }

  function fetchPlans() {
    var path = window.location.pathname || "";
    var endpoints = uniqueEndpoints([
      path.indexOf("/app/") === 0 ? "/app/api/landing/plans" : "",
      "/api/landing/plans",
      path.indexOf("/app/") === 0 ? "/app/landing/plans" : "",
      "/landing/plans",
      "/app/api/landing/plans",
      "/app/landing/plans",
      "./plans",
      "../api/landing/plans",
      "../landing/plans"
    ]);

    function attempt(index) {
      if (index >= endpoints.length) {
        renderPlans(fallbackPlans);
        return;
      }

      requestEndpoint(endpoints[index])
        .then(function (data) {
          var plans = data && Array.isArray(data.plans) ? data.plans : [];
          if (plans.length > 0) {
            renderPlans(plans);
            return;
          }
          attempt(index + 1);
        })
        .catch(function () {
          attempt(index + 1);
        });
    }

    attempt(0);
  }

  fetchPlans();
})();
