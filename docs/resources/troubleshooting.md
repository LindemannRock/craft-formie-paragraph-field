# Troubleshooting

Common issues and how to resolve them. If something here doesn't cover your case, [open an issue](https://github.com/LindemannRock/craft-formie-paragraph-field/issues).

## The Paragraph field isn't in Formie's field list

**Quick checks:**

1. Is Formie installed **and enabled** in **Settings → Plugins**?
2. Is Formie Paragraph Field itself enabled?
3. Hard-refresh the form builder page.

**Fix:** The Paragraph field registers into Formie, so Formie must be active first. Install/enable both under **Settings → Plugins**.

**Why:** The field is added via Formie's field-registration event — with Formie disabled, there's nothing to register into.

## The text size has no visible effect

**Quick checks:**

1. Open the rendered page and confirm the `<p>` has the size classes (e.g. `text-base`).
2. Does your site's CSS actually define those classes?

**Fix:** The plugin outputs class names only — your site's stylesheet styles them. The built-in sizes use Tailwind-style utilities (`text-xs`, `text-base`, …); if you don't use Tailwind, define [custom text sizes](../get-started/configuration.md#custom-text-sizes) that map to classes your CSS provides.

**Why:** The field is framework-agnostic by design — it never ships CSS, so it can't assume what `text-lg` looks like on your site.

## Custom text sizes aren't appearing in the dropdown

**Quick checks:**

1. Is `customTextSizes` valid PHP in `config/formie-paragraph-field.php`?
2. Each entry needs both a `label` and `classes`.

**Fix:** Correct the config syntax and reload the form builder. Remember that defining `customTextSizes` **replaces** the built-in sizes entirely — include any built-ins you still want.

**Why:** Custom sizes are config-file only (there's no Control-Panel field), and a non-empty list overrides the defaults.

## Saving settings fails with "Default text size must be one of…"

**Fix:** Set **Default Text Size** to one of the currently available size keys. If you defined `customTextSizes`, the built-in keys (`textBase`, etc.) no longer exist — pick one of your custom keys instead.

**Why:** The default is validated against the available sizes, and custom sizes replace the built-ins.

## HTML in the content shows as plain text

**Fix:** This is intentional — content is HTML-escaped for safety, and line breaks are converted to `<br>`. For richer markup, use the field's CSS classes (Advanced tab) and your stylesheet rather than inline HTML.

**Why:** Escaping prevents content entered in the form builder from injecting markup into the page.

## Paragraph content is missing from notification emails

**Quick checks:**

1. Open the Paragraph field in Formie and confirm **Include in Email** is enabled.
2. Confirm the notification includes **All Form Fields** or **All Visible Fields**. **All Non Empty Fields** intentionally excludes display-only fields.

**Fix:** Update Formie Paragraph Field, then preview the notification again. You do not need to resave the field or notification.

**Why:** Older releases returned a template path that Formie's email renderer could not resolve, so the Paragraph content was silently omitted while the rest of the notification still rendered.

## The paragraph doesn't appear in submissions

**Fix:** Expected — Paragraph is a *cosmetic* field. It displays content but collects no value, so it never appears as submission data. Use a real input field if you need to capture something.
