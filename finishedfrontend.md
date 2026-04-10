# Finished Frontend Tasks

- Copied the mirrored site into `app/landing` for isolated cleanup workflow.
- Replaced legacy brand/domain strings with `Expert Traders` and `experttradersfx.com` across core landing pages.
- Removed HTTrack mirror comment artifacts from core landing documents.
- Removed Google Translate embedded mirror snippets and dead local translation includes from page headers.
- Updated auth links to app-level routes (`/login`, `/register`) across landing pages.
- Replaced stale nav/footer links (`index-3`, hosting placeholders) with valid landing destinations.
- Converted dark-section classes to light variants in core landing pages.
- Switched market widget theme declaration from dark to light where present.
- Added `app/landing/assets/css/custom.css` light-theme override aligned with dashboard palette.
- Removed dark theme switcher UI from testimonials page.
- Completed text cleanup for key mirrored copy remnants (including legacy Novas Group sentence).
- Created tracking docs: `frontendtask.md` and `finishedfrontend.md`.
- Updated `app/server.php` routing logic to serve project-root static landing files before Laravel fallback.
- Published cleaned landing bundle to Trader root so `http://127.0.0.1:8000/` loads the landing page directly.
- Verified local functionality: `/`, `/assets/css/main.css`, `/about.html`, and `/login` all return `200`.
