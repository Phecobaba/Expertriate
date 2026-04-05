# Next Tasks (Priority Order)

## Completed in Current Run (2026-04-03)
- Market widget hardening delivered:
  - provider-based data path (`CoinGecko`, `CoinMarketCap`, `CryptoCompare`)
  - safe fallback mode when provider data is unavailable
  - no-data UI states for market cards/chart/top movers/trending assets
- Super Admin API settings extended:
  - provider/key/base-url fields
  - runtime provider status visibility
- QA regression pass executed:
  - login/logout flow checks
  - dashboard/deposit/withdraw/transactions route checks
  - Blade compile validation
- Technical cleanup documentation added:
  - runtime compatibility notes
  - deployment readiness checklist
- Security readiness hardening added:
  - non-local default-credential login block

## Remaining Tasks (Deployment Stage)
- Verify `.env` production values before deployment (HTTPS, APP_URL, mail, cache/session drivers).
- Run final staging validation before promoting changes.
- Replace vendor-level compatibility edits with non-vendor override strategy in a follow-up refactor.
