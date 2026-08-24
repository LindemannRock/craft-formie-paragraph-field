# Configuration

Set the starting text size for new Paragraph fields, define size choices that match your site's CSS, or rename the plugin in the Control Panel. The **Default Text Size** and **plugin name** live under **Settings → Plugins → Formie Paragraph Field**. **Custom text sizes are config-file only** — there's no Control-Panel field for them.

For advanced configuration, copy the sample config to your project:

```bash
cp vendor/lindemannrock/craft-formie-paragraph-field/src/config.php config/formie-paragraph-field.php
```

Anything set in `config/formie-paragraph-field.php` overrides the Control Panel value and locks that field in the UI.

## Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `pluginName` | `string` | `'Formie Paragraph Field'` | Name shown in the Control Panel. Usually set in the UI, not config. |
| `defaultTextSize` | `string` | `'textBase'` | Text size applied to new paragraph fields. Must be one of the available size keys. |
| `customTextSizes` | `array` | `[]` | Your own size options. **When non-empty, these completely replace the built-in sizes.** |

## Text sizes

Each "text size" is a key that maps to a label (shown in the field's **Text Size** dropdown) and a set of CSS classes applied to the rendered `<p>`. The built-in sizes use Tailwind-style utility classes:

| Key | Label | CSS classes |
|-----|-------|-------------|
| `textXS` | Extra Small | `text-xs` |
| `textSM` | Small | `text-sm` |
| `textBase` | Base | `text-base` |
| `textLG` | Large | `text-base sm:text-lg md:text-xl` |
| `textXL` | Extra Large | `text-lg sm:text-xl md:text-2xl` |

> [!NOTE]
> The plugin only outputs these class names — your site's CSS supplies what they look like. The built-ins assume Tailwind, but the classes are just strings: use Bootstrap, custom CSS, or anything else (see custom sizes below).

## Custom text sizes

Define `customTextSizes` to offer your own options. Each entry needs a `label` (shown in the dropdown) and `classes` (applied to the `<p>`).

> [!IMPORTANT]
> When `customTextSizes` is non-empty it **replaces** the built-in sizes entirely — the five defaults no longer appear. Include any built-ins you still want.

```php
'customTextSizes' => [
    'textHero' => [
        'label' => 'Hero Text',
        'classes' => 'text-4xl md:text-6xl font-bold',
    ],
    'textLead' => [               // Bootstrap example
        'label' => 'Lead Paragraph',
        'classes' => 'lead fw-normal',
    ],
    'textDisclaimer' => [         // Custom CSS classes
        'label' => 'Disclaimer',
        'classes' => 'my-disclaimer text-muted',
    ],
],
```

Make `defaultTextSize` one of your custom keys when you replace the built-ins — otherwise validation rejects the old default.

## Example: full config file

`config/formie-paragraph-field.php` is multi-environment aware, like Craft's `general.php`:

```php
<?php

return [
    '*' => [
        // Optional Control Panel display name
        // 'pluginName' => 'Formie Paragraph Field',

        'defaultTextSize' => 'textBase',
        'customTextSizes' => [],
    ],

    'production' => [
        'defaultTextSize' => 'textLG',
        'customTextSizes' => [
            'textBrand' => [
                'label' => 'Brand Text',
                'classes' => 'font-brand text-brand-primary text-lg',
            ],
        ],
    ],
];
```

## Environment variables

String values can be driven by an environment variable with Craft's `App::env()`:

```php
use craft\helpers\App;

return [
    '*' => [
        'defaultTextSize' => App::env('PARAGRAPH_DEFAULT_SIZE') ?: 'textBase',
    ],
];
```

## Precedence

Settings resolve in this order (later wins): plugin defaults → Control-Panel value → `config/formie-paragraph-field.php` → environment-specific config group. A value set in config locks the matching Control-Panel field (it shows an "overridden by config" notice).
