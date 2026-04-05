# Runtime Compatibility Notes (PHP 8.x + Laravel 8)

Date: 2026-04-03

## Active compatibility patches
- Custom bootstrap exception handler is wired to avoid startup failures from deprecation-level notices.
  - `app/core_invapp/app/Foundation/Bootstrap/HandleExceptions.php`
  - bound in:
    - `app/core_invapp/app/Http/Kernel.php`
    - `app/core_invapp/app/Console/Kernel.php`
- Carbon vendor compatibility patch exists for `DateTime::getLastErrors()` false return behavior on newer PHP.
  - `app/core_invapp/vendor/nesbot/carbon/src/Carbon/Traits/Creator.php`
- Utility service vendor patch includes a local/testing guard to prevent local login interruptions.
  - `app/core_invapp/vendor/softnio/utility-services/src/UtilityService.php`

## Local-only guardrails in app code
- Remote health/license checks are bypassed in `local/testing` to avoid blocking local requests.
  - `app/core_invapp/app/Services/HealthCheckService.php`
  - `app/core_invapp/app/Services/MaintenanceService.php`
- Default credentials are blocked in non-local environments at login.
  - `app/core_invapp/app/Http/Controllers/AuthController.php`

## Follow-up migration plan (recommended)
1. Move vendor edits into non-vendor extension points (service provider bindings or patch-package strategy).
2. Pin and document minimum supported PHP/Laravel combinations in deployment docs.
3. Add CI smoke checks on target PHP versions to catch future regressions.
