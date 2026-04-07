# UI Architecture Whiteboard Spec

Date: 2026-04-07

## 1) Objective
- Support `2 themes` and `2 skins` in a composable way.
- Current state: `Theme 1 + Skin 1` exists.
- Immediate goal: add `Skin 2` for `Theme 1`.
- Later goal: add `Theme 2` that can use either skin.

## 2) Core Model
- `Theme` = structural system
  - layout shell behavior
  - navigation behavior
  - density/spacing rhythm
  - page-level composition rules
- `Skin` = visual system
  - color tokens
  - surfaces, borders, shadows
  - typography accents
  - component tone (buttons, inputs, cards, tables, badges)

## 3) Settings Contract (Admin-Controlled)
- Persist two independent settings:
  - `ui_theme` (e.g. `theme_1`, `theme_2`)
  - `ui_skin` (e.g. `skin_1`, `skin_2`)
- Resolution rule at render time:
  - load active theme resources
  - then apply active skin resources
- Fallback rule:
  - invalid/missing theme -> `theme_1`
  - invalid/missing skin -> `skin_1`

## 4) Compatibility Matrix
- Allowed combinations:
  - Theme 1 + Skin 1
  - Theme 1 + Skin 2
  - Theme 2 + Skin 1 (future)
  - Theme 2 + Skin 2 (future)
- No hard binding between a theme and a skin.

## 5) File/Asset Architecture
- `theme layer` files: structure/layout behavior classes.
- `skin layer` files: token and component style overrides.
- Refactor current styles into:
  - base shared primitives (common utilities)
  - theme-specific layout styles
  - skin-specific visual tokens/overrides
- Load order:
  1. Base
  2. Theme
  3. Skin
  4. Page-scoped styles (if needed)

## 6) Admin UX Behavior
- Admin page should expose two selectors:
  - Theme selector
  - Skin selector
- Save independently.
- Live status indicator should show current active pair.
- One-click rollback to default pair (`Theme 1 + Skin 1`).

## 7) Skin 2 Design Boundaries
- Must reuse existing markup/component class contract.
- Must not require duplicating Blade views.
- Should cover all critical UI surfaces:
  - header/sidebar/footer
  - dashboard cards/charts/pills
  - forms/tables/modals/alerts
  - auth + user pages + mobile bottom nav

## 8) QA/Acceptance Criteria
- Functional:
  - switching skin does not break routes/layout/interaction
- Visual:
  - no unreadable text states or contrast failures
  - no component regressions across key pages
- Responsiveness:
  - mobile/tablet/desktop parity maintained
- Stability:
  - invalid setting values safely fall back

## 9) Delivery Plan (No Code Yet)
1. Audit and tag existing CSS into theme-vs-skin responsibilities.
2. Define Skin 2 token map (palette, surfaces, states).
3. Map component-level style deltas for Skin 2.
4. Define admin setting keys and fallback behavior.
5. Implement in small slices with route-based visual QA after each slice.

