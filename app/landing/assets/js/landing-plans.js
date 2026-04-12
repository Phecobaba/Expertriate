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

    return (
      '<div class="col-lg-4 col-md-6">' +
      '<div class="' + cardClass + '">' +
      "<h3 class=\"h5\">" + escapeHtml(plan.name) + "</h3>" +
      '<span class="pricing-badge position-absolute rounded"><span class="gradient-txt">' + escapeHtml(badgeText) + "</span></span>" +
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
    return fetch(endpoint, {
      method: "GET",
      headers: { Accept: "application/json" }
    }).then(function (response) {
      if (!response.ok) {
        throw new Error("Unable to load plans");
      }
      return response.json();
    });
  }

  function fetchPlans() {
    requestEndpoint("/app/landing/plans")
      .catch(function () {
        return requestEndpoint("/landing/plans");
      })
      .then(function (data) {
        renderPlans(data && Array.isArray(data.plans) ? data.plans : fallbackPlans);
      })
      .catch(function () {
        renderPlans(fallbackPlans);
      });
  }

  fetchPlans();
})();
