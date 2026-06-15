# Features overview

Drop a block of explanatory text straight into a Formie form — an intro, instructions, a consent notice, a disclaimer — without an HTML field or a template override. Formie Paragraph Field adds a **Paragraph** field type that renders static, display-only content between your real inputs.

> [!TIP]
> New to the plugin? Start with [Installation](../get-started/installation.md) and the [Quickstart](../get-started/quickstart.md), then come back here.

## What it does

The Paragraph field is a *cosmetic* field: it shows content but collects no value, so it never appears in submissions as data. You type the text in the form builder, pick a size, and it renders as a styled `<p>` on the live form. Line breaks are kept, HTML is escaped (so content is safe), and the text runs through Formie's translation layer.

## What you'll use it for

- An intro paragraph at the top of a form
- Instructions before a tricky group of fields
- A short consent or privacy notice
- A disclaimer or legal footnote
- Section dividers with explanatory copy

## Core capabilities

- **[The Paragraph field](paragraph-field.md)** — Add display-only text to any form, choose a text size, and optionally include it in notification emails.
- **Text sizes** — Pick from five built-in sizes, or define your own in [Configuration](../get-started/configuration.md) that map to whatever CSS classes your site uses (Tailwind, Bootstrap, custom).

## Where things live

| You configure… | In… |
|----------------|-----|
| The paragraph text, size, email inclusion | The **Paragraph** field on each Formie form |
| The default text size + your own custom sizes | Settings → Plugins → Formie Paragraph Field, and `config/formie-paragraph-field.php` |

![A Paragraph field in the Formie form builder](images/overview-form-builder.webp)

## Next steps

1. [Install the plugin](../get-started/installation.md)
2. [Add your first paragraph](../get-started/quickstart.md)
3. [Tour the field options](paragraph-field.md)
