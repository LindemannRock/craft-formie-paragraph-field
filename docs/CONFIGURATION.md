# Formie Paragraph Field Configuration

## Configuration File

You can override plugin settings by creating a `formie-paragraph-field.php` file in your `config/` directory.

### Basic Setup

1. Copy `vendor/lindemannrock/craft-formie-paragraph-field/src/config.php` to `config/formie-paragraph-field.php`
2. Modify the settings as needed

### Available Settings

```php
<?php
return [
    // General Settings
    'pluginName' => 'Formie Paragraph Field',
    'defaultTextSize' => 'textBase',
    'customTextSizes' => [],
];
```

### Multi-Environment Configuration

You can have different settings per environment:

```php
<?php
return [
    // Global settings
    '*' => [
        'defaultTextSize' => 'textBase',
        'customTextSizes' => [],
    ],

    // Development environment
    'dev' => [
        // Development-specific settings can go here
    ],

    // Staging environment
    'staging' => [
        // Staging-specific settings can go here
    ],

    // Production environment
    'production' => [
        'defaultTextSize' => 'textLG',
        'customTextSizes' => [
            'textBrand' => [
                'label' => 'Brand Text',
                'classes' => 'font-brand text-brand-primary text-lg'
            ]
        ]
    ],
];
```

### Setting Descriptions

#### General Settings

##### pluginName
Display name for the plugin in Craft CP navigation.
- **Type:** `string`
- **Default:** `'Formie Paragraph Field'`

##### defaultTextSize
Default text size for new paragraph fields.
- **Type:** `string`
- **Options:** `'textXS'`, `'textSM'`, `'textBase'`, `'textLG'`, `'textXL'` (or custom size keys when customTextSizes is defined)
- **Default:** `'textBase'`

##### customTextSizes
Custom text size options that replace built-in options when defined.
- **Type:** `array`
- **Default:** `[]` (empty = use built-in options)
- **Format:** Array of size options with `label` and `classes` keys
- **Behavior:** When defined, these options **completely replace** the built-in size options

### Built-in Text Sizes

Default text sizes available when `customTextSizes` is empty:

| Value | Label | CSS Classes |
|-------|-------|-------------|
| `textXS` | Extra Small | `text-xs` |
| `textSM` | Small | `text-sm` |
| `textBase` | Base | `text-base` |
| `textLG` | Large | `text-base sm:text-lg md:text-xl` |
| `textXL` | Extra Large | `text-lg sm:text-xl md:text-2xl` |

### Custom Text Size Examples

#### Tailwind CSS Examples

```php
'customTextSizes' => [
    'textHero' => [
        'label' => 'Hero Text',
        'classes' => 'text-4xl md:text-6xl font-bold text-center'
    ],
    'textSubtle' => [
        'label' => 'Subtle Text',
        'classes' => 'text-sm text-gray-500 font-light'
    ],
    'textHighlight' => [
        'label' => 'Highlighted',
        'classes' => 'text-lg bg-yellow-100 p-2 rounded'
    ]
]
```

#### Bootstrap Examples

```php
'customTextSizes' => [
    'textLead' => [
        'label' => 'Lead Paragraph',
        'classes' => 'lead fw-normal'
    ],
    'textMuted' => [
        'label' => 'Muted Text',
        'classes' => 'text-muted small'
    ]
]
```

#### Custom CSS Examples

```php
'customTextSizes' => [
    'textBranded' => [
        'label' => 'Branded Text',
        'classes' => 'company-paragraph brand-font primary-color'
    ],
    'textCallout' => [
        'label' => 'Callout',
        'classes' => 'callout-box special-formatting'
    ]
]
```

### Precedence

Settings are loaded in this order (later overrides earlier):

1. Default plugin settings
2. Database-stored settings (from CP)
3. Config file settings
4. Environment-specific config settings

**Note:** Config file settings always override database settings, making them ideal for production environments where you want to enforce specific values.

### Using Environment Variables

All settings support environment variables:

```php
use craft\helpers\App;

return [
    'defaultTextSize' => App::env('PARAGRAPH_DEFAULT_SIZE') ?: 'textBase',
    'pluginName' => App::env('PARAGRAPH_PLUGIN_NAME') ?: 'Formie Paragraph Field',
];
```

### Best Practices

#### Naming Convention

Use descriptive names for custom text sizes:
- `textHero` (better than `textBig`)
- `textDisclaimer` (better than `textSmall2`)
- `textCallout` (better than `textSpecial`)

#### CSS Classes

- Use semantic class names when possible
- Include responsive classes for better mobile experience
- Test classes work with your site's CSS framework
- Consider accessibility (contrast, font sizes)

#### Environment Configuration

- Use minimal config in development
- Add production-specific sizes for marketing content
- Keep staging similar to production for testing

### Troubleshooting

#### Custom Sizes Not Showing
1. Verify config file syntax is valid PHP
2. Clear compiled classes: `php craft clear-caches/compiled-classes`
3. Check plugin settings validation in Control Panel

#### Classes Not Applied
1. Ensure CSS classes exist in your stylesheet
2. Check for CSS specificity conflicts
3. Verify responsive classes work at different breakpoints

#### Default Size Not Applied
1. Confirm `defaultTextSize` value matches an available option
2. Check if setting is overridden in Control Panel
3. Clear caches after config changes
