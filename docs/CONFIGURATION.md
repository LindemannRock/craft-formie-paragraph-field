# Formie Paragraph Field Configuration

## Configuration File

You can override plugin settings by creating a `formie-paragraph-field.php` file in your `config/` directory.

### Basic Setup

1. Copy `vendor/lindemannrock/formie-paragraph-field/src/config.php` to `config/formie-paragraph-field.php`
2. Modify the settings as needed

### Available Settings

```php
<?php
return [
    // Plugin name shown in Control Panel (optional)
    'pluginName' => 'Custom Paragraph Field Name',
    
    // Default text size for new paragraph fields
    'defaultTextSize' => 'textLG',
    
    // Custom text size options (replaces built-in options when defined)
    'customTextSizes' => [
        'textDisplay' => [
            'label' => 'Display Heading',
            'classes' => 'text-3xl md:text-5xl font-bold leading-tight'
        ],
        'textDisclaimer' => [
            'label' => 'Disclaimer',
            'classes' => 'text-xs text-gray-600 italic'
        ],
    ]
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
    ],
    
    // Development environment
    'dev' => [
        'customTextSizes' => [
            'textDebug' => [
                'label' => 'Debug Text',
                'classes' => 'text-red-500 border border-red-300 p-2'
            ]
        ]
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

### Using Environment Variables

All settings support environment variables:

```php
return [
    'defaultTextSize' => getenv('PARAGRAPH_DEFAULT_SIZE') ?: 'textBase',
    'pluginName' => getenv('PARAGRAPH_PLUGIN_NAME') ?: 'Formie Paragraph Field',
];
```

### Setting Descriptions

#### General Settings

- **pluginName**: The name shown in the Control Panel (usually set via Settings → Plugins)
- **defaultTextSize**: Default text size for new paragraph fields (must match an available size value)

#### Custom Text Sizes

- **customTextSizes**: Array of text size options that **replaces** built-in options when defined
  - **Key**: Unique identifier (e.g., `textHuge`, `textBrand`)
  - **label**: Text shown in Formie field dropdown
  - **classes**: CSS classes applied to the paragraph (any framework: Tailwind, Bootstrap, custom)
  - **Behavior**: If defined, only these options appear (built-in options are hidden)

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

### Built-in Text Sizes

Default text sizes that are always available:

| Value | Label | CSS Classes |
|-------|-------|-------------|
| `textXS` | Extra Small | `text-xs` |
| `textSM` | Small | `text-sm` |
| `textBase` | Base | `text-base` |
| `textLG` | Large | `text-base sm:text-lg md:text-xl` |
| `textXL` | Extra Large | `text-lg sm:text-xl md:text-2xl` |

### Precedence

Settings are loaded in this order (later overrides earlier):

1. Default plugin settings (hardcoded)
2. Database-stored settings (from Control Panel)
3. Config file settings
4. Environment-specific config settings

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