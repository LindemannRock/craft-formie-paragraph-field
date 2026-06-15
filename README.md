![Formie Paragraph Field](docs/images/hero.webp)

# Formie Paragraph Field for Craft CMS

[![Latest Version](https://img.shields.io/packagist/v/lindemannrock/craft-formie-paragraph-field.svg)](https://packagist.org/packages/lindemannrock/craft-formie-paragraph-field)
[![Craft CMS](https://img.shields.io/badge/Craft%20CMS-5.0+-orange.svg)](https://craftcms.com/)
[![Formie](https://img.shields.io/badge/Formie-3.0+-purple.svg)](https://verbb.io/craft-plugins/formie)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net/)
[![License](https://img.shields.io/packagist/l/lindemannrock/craft-formie-paragraph-field.svg)](LICENSE)

A Craft CMS plugin that adds a display-only **Paragraph** field type to Verbb's Formie — static text content (intros, instructions, notices) with configurable text sizes.

## License

This is a commercial plugin licensed under the [Craft License](https://craftcms.github.io/license/). It will be available on the [Craft Plugin Store](https://plugins.craftcms.com) soon. See [LICENSE.md](LICENSE.md) for details.

## ⚠️ Pre-Release

This plugin is in active development and not yet available on the Craft Plugin Store. Features and APIs may change before the initial public release.

## Features

- **Display-only paragraph field** — add static text to a form; it's cosmetic, so it collects no submission value
- **Configurable text sizes** — 5 built-in sizes, or define your own that map to any CSS classes (Tailwind, Bootstrap, custom)
- **Default text size** — set the starting size for new fields in plugin settings or config
- **Safe content** — line breaks become `<br>`, HTML is escaped, and the text passes through Craft's translation layer
- **Email inclusion** — optionally render the paragraph in Formie notification emails
- **Conditions** — show or hide the paragraph based on other fields (Formie native)
- **12 languages** — translated out of the box

## Requirements

- Craft CMS 5.0 or greater
- PHP 8.2 or greater
- Formie 3.0 or greater

## Installation

### Via Composer

```bash
composer require lindemannrock/craft-formie-paragraph-field
```

```bash
php craft plugin/install formie-paragraph-field
```

### Using DDEV

```bash
ddev composer require lindemannrock/craft-formie-paragraph-field
```

```bash
ddev craft plugin/install formie-paragraph-field
```

## Documentation

Full documentation is available in the [docs](docs/) folder.

## Support

- **Issues**: [GitHub Issues](https://github.com/LindemannRock/craft-formie-paragraph-field/issues)
- **Email**: [support@lindemannrock.com](mailto:support@lindemannrock.com)

## License

This plugin is licensed under the [Craft License](https://craftcms.github.io/license/). See [LICENSE.md](LICENSE.md) for details.

---

Developed by [LindemannRock](https://lindemannrock.com)

Built for use with [Formie](https://verbb.io/craft-plugins/formie) by Verbb
