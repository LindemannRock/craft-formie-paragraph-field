# Translations

Run Formie Paragraph Field's Control Panel UI in any of 12 included languages, and override its wording from your project when needed.

## Supported languages

| Language | Code |
|----------|------|
| English | `en` |
| German | `de` |
| French | `fr` |
| Dutch | `nl` |
| Spanish | `es` |
| Arabic | `ar` |
| Italian | `it` |
| Portuguese | `pt` |
| Japanese | `ja` |
| Swedish | `sv` |
| Danish | `da` |
| Norwegian | `no` |

Translations are applied automatically based on the user's preferred language in Craft's Control Panel settings.

> [!NOTE]
> A paragraph field's **content** uses Formie's `formie` translation category. Add matching content strings to your project's `translations/{locale}/formie.php` file when the paragraph itself needs translation.

## Overriding translations

Override any string by creating a static translation file in your project under the `formie-paragraph-field` category:

```
translations/
└── de/
    └── formie-paragraph-field.php
```

```php
<?php

return [
    'Text Size' => 'Textgröße',  // your override
];
```

Only the keys you include are replaced — every other string uses the plugin's built-in translation.

See [Craft's Static Translation Strings](https://craftcms.com/docs/5.x/system/sites.html#static-message-translations) for details.

## Contributing translations

Found a translation error or want to improve one? [Open an issue](https://github.com/LindemannRock/craft-formie-paragraph-field/issues) with:

- The language affected
- The current (incorrect) string
- Your suggested correction
