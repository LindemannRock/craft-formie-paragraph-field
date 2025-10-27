# Formie Paragraph Field Plugin

[![Latest Version](https://img.shields.io/packagist/v/lindemannrock/craft-formie-paragraph-field.svg)](https://packagist.org/packages/lindemannrock/craft-formie-paragraph-field)
[![Craft CMS](https://img.shields.io/badge/Craft%20CMS-5.0+-orange.svg)](https://craftcms.com/)
[![Formie](https://img.shields.io/badge/Formie-3.0+-purple.svg)](https://verbb.io/craft-plugins/formie)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net/)
[![License](https://img.shields.io/packagist/l/lindemannrock/craft-formie-paragraph-field.svg)](LICENSE)

A Craft CMS plugin that provides a paragraph field type for Verbb's Formie form builder, allowing styled paragraph content with configurable text sizes and Twig template support.

## Requirements

- Craft CMS 5.0 or greater
- PHP 8.2 or greater
- Formie 3.0 or greater

## Features

### Flexible Text Sizing
- **5 Built-in Sizes**: From Extra Small to Extra Large with responsive design
- **Configurable Options**: Add custom text sizes via config file
- **Plugin Settings**: Set default text size for new paragraph fields

### Rich Content Support
- **Twig Rendering**: Content supports translations, variables, and filters
- **Multi-line Content**: Rich paragraph content with proper formatting
- **Translation Ready**: Works seamlessly with Craft's translation system

### Seamless Integration
- Native Formie field type
- Inherits site's paragraph styling
- Responsive design out of the box
- Backward compatible with existing forms

## Installation

### Via Composer

```bash
cd /path/to/project
composer require lindemannrock/craft-formie-paragraph-field
./craft plugin/install formie-paragraph-field
```

### Using DDEV

```bash
cd /path/to/project
ddev composer require lindemannrock/craft-formie-paragraph-field
ddev craft plugin/install formie-paragraph-field
```

### Via Control Panel

In the Control Panel, go to Settings → Plugins and click "Install" for Formie Paragraph Field.

## Configuration

### Plugin Settings

Navigate to **Settings → Plugins → Formie Paragraph Field** to configure:
- **Default Text Size**: Set the default size for new paragraph fields

### Config File

Create a `config/formie-paragraph-field.php` file to override default settings:

```bash
cp vendor/lindemannrock/craft-formie-paragraph-field/src/config.php config/formie-paragraph-field.php
```

Example configuration:

```php
// config/formie-paragraph-field.php
return [
    // Plugin name (optional - usually set via Control Panel)
    'pluginName' => 'Custom Paragraph Field',

    // Default text size for new fields
    'defaultTextSize' => 'textLG',

    // Custom text size options (replaces built-in options when defined)
    'customTextSizes' => [
        'textHuge' => [
            'label' => 'Huge',
            'classes' => 'text-2xl md:text-4xl lg:text-6xl'
        ],
        'textBrand' => [
            'label' => 'Brand Text',
            'classes' => 'font-brand text-brand-primary custom-spacing'
        ]
    ]
];
```

See [Configuration Documentation](docs/CONFIGURATION.md) for all available options.

**Note**:
- You can use any CSS classes - Tailwind, Bootstrap, or your own custom styles
- When `customTextSizes` is defined, it **replaces** the built-in options entirely
- Without a config file, you get 5 built-in text sizes (XS to XL)

## Built-in Text Size Classes

| Size Value | Label | Tailwind Classes |
|------------|-------|------------------|
| `textXS` | Extra Small | `text-xs` |
| `textSM` | Small | `text-sm` |
| `textBase` | Base | `text-base` |
| `textLG` | Large | `text-base sm:text-lg md:text-xl` |
| `textXL` | Extra Large | `text-lg sm:text-xl md:text-2xl` |

## Usage

### Adding a Paragraph Field

1. Open your form in Formie's form builder
2. Click "Add Field" and select "Paragraph"
3. Configure the field:
   - **Content**: Enter paragraph text (supports Twig syntax)
   - **Text Size**: Choose from available size options
4. The content renders with proper styling and responsive sizing

### Twig Content Examples

```twig
{# Simple text #}
Welcome to our website!

{# With translations #}
{{ 'Welcome to our website!'|t }}

{# With variables #}
Hello {{ currentUser.name }}!

{# With filters #}
{{ 'important message'|upper }}

{# Multi-line content #}
This is the first paragraph.

This is the second paragraph with {{ 'translation'|t }}.
```

### Templating

Paragraph fields are rendered automatically by Formie:

```twig
{# Render the entire form #}
{{ craft.formie.renderForm('contactForm') }}

{# Or render specific field #}
{% set form = craft.formie.forms.handle('contactForm').one() %}
{{ craft.formie.renderField(form, 'paragraphField') }}
```

## Support

- **Documentation**: [https://github.com/LindemannRock/craft-formie-paragraph-field](https://github.com/LindemannRock/craft-formie-paragraph-field)
- **Issues**: [https://github.com/LindemannRock/craft-formie-paragraph-field/issues](https://github.com/LindemannRock/craft-formie-paragraph-field/issues)
- **Email**: [support@lindemannrock.com](mailto:support@lindemannrock.com)

## License

This plugin is licensed under the MIT License. See [LICENSE](LICENSE) for details.

---

Developed by [LindemannRock](https://lindemannrock.com)

Built for use with [Formie](https://verbb.io/craft-plugins/formie) by Verbb
