# Front-end output

What the Paragraph field renders on a live form, and the hooks available if you template or query it yourself.

## Rendered markup

The field outputs a single paragraph element:

```html
<p class="fui-paragraph text-brand block text-base">Your content here</p>
```

The class list is, in order:

- `fui-paragraph`, `text-brand`, `block` — always present
- the **text-size classes** for the chosen size (e.g. `text-base`, or `text-base sm:text-lg md:text-xl` for Large)
- any **CSS classes** entered in the field's Advanced tab

The content itself is `nl2br(escaped + translated)` — line breaks become `<br>`, HTML is escaped, and the string passes through Formie's translation layer (`Craft::t('formie', …)`).

> The plugin only emits class names. The built-in sizes assume Tailwind-style utilities (`text-xs` … `text-lg sm:text-xl md:text-2xl`); your site's CSS supplies the actual styling. Map the size keys to any framework or custom CSS via [custom text sizes](../get-started/configuration.md#custom-text-sizes).

## HTML tag customization

The field defines a Formie HTML tag under the key `fieldParagraph`, rendered as a `<p>` carrying the resolved text-size class. You can override it through Formie's standard [HTML tag / theming](https://verbb.io/craft-plugins/formie/docs) hooks like any other field.

## Email output

When **Include in Email** is enabled, the rendered content is output into Formie notification emails (the field's email template). With it off, the paragraph is on-page only.

## GraphQL

The Paragraph field is cosmetic, so it has no submission *value* to query. Its two settings are exposed as GraphQL field-setting types (both `String`):

| Setting | Type |
|---------|------|
| `paragraphContent` | `String` |
| `textSize` | `String` |

There are no custom queries or mutations — these are the field's setting types within Formie's schema.

## Next steps

- [The Paragraph field](../feature-tour/paragraph-field.md)
- [Configuration](../get-started/configuration.md#text-sizes) — text-size keys and classes
