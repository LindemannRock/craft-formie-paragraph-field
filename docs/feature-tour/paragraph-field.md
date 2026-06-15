# The Paragraph field

Add a block of static text to any Formie form — an intro, instructions, a notice — and the plugin renders it as a styled, display-only paragraph. It collects no value, so it never shows up in submissions; it's there purely to be read.

## What you'll use it for

- An introduction at the top of a form
- Step-by-step instructions before a group of fields
- A consent, privacy, or disclaimer notice
- Explanatory copy between sections

## Add the field

1. In the Control Panel, open **Formie → Forms** and edit a form.
2. Drag **Paragraph** from the field list onto a page.
3. Fill in the settings (below) and save.

![The Paragraph field settings in the Formie form builder](images/paragraph-field-settings.webp)

## Field options

In the field's **General** tab:

| Option | What it does |
|--------|--------------|
| **Name** | The label shown in the form builder. It is **not** displayed to visitors — only your content is. |
| **Paragraph Content** | The text to display (required). Line breaks become `<br>`; HTML is escaped, so content is safe to enter. |
| **Text Size** | The size for this paragraph — one of the [available sizes](../get-started/configuration.md#text-sizes). New fields start from the plugin's default size. |
| **Include in Email** | Include the paragraph in Formie notification emails. |

The **Advanced** tab adds the usual Formie options — handle, CSS classes, container attributes — and the **Conditions** tab lets you show or hide the paragraph based on other fields, just like any Formie field.

## How it renders

On the live form the field outputs a single paragraph element:

```html
<p class="fui-paragraph text-brand block text-base">Your content here</p>
```

- The size you chose maps to its CSS classes (e.g. `text-base`) — see [Text sizes](../get-started/configuration.md#text-sizes).
- Any **CSS classes** you set in the Advanced tab are appended.
- Content keeps its line breaks and is HTML-escaped.

> The plugin emits class names; your site's stylesheet decides how they look. The built-in sizes assume Tailwind-style utilities, but you can point the size keys at any CSS via [custom text sizes](../get-started/configuration.md#custom-text-sizes).

### In notification emails

With **Include in Email** on, the paragraph's content is rendered into Formie notification emails. Leave it off to keep the text on-page only.

## Next steps

- [Configuration](../get-started/configuration.md) — set the default size and add your own
- [Front-end output](../developers/front-end-output.md) — the markup, classes, and GraphQL details
