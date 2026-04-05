# Deployment Readiness Checklist

Date: 2026-04-03

## Credentials and auth
- [ ] Replace known default credentials before non-local deployment.
- [ ] Verify admin and user accounts use unique strong passwords.
- [ ] Confirm 2FA policy for admin users.

## Environment variables
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` set to production domain
- [ ] `FORCE_HTTPS=true` (or equivalent TLS enforcement)
- [ ] Production mailer credentials validated
- [ ] Cache/session/queue drivers configured for production usage

## Market feed settings
- [ ] Configure `market_data_provider`
- [ ] Configure `market_data_api_key` when using premium providers
- [ ] Optionally configure `market_data_base_url`
- [ ] Confirm dashboard shows `Live` status and no provider error

## Validation before release
- [ ] Run route + login smoke tests (admin/user)
- [ ] Verify deposit/withdraw/transactions pages
- [ ] Inspect Laravel logs for runtime warnings/errors
- [ ] Clear and rebuild caches (`view`, `config`, `route`)
