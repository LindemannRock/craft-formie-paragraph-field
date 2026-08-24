# Installation & Setup

> [!NOTE]
> Formie Paragraph Field is in active development and not yet available on the Craft Plugin Store. Install via Composer for now.

> [!IMPORTANT]
> Formie Paragraph Field needs [Formie](https://verbb.io/craft-plugins/formie) installed and enabled. Composer pulls it in automatically; install it in the Control Panel under **Settings → Plugins**. The Paragraph field type only appears in Formie's field list once Formie is enabled.

## Composer

Add the package to your project using Composer and the command line.

1. Open your terminal and go to your Craft project:

```bash
cd /path/to/project
```

2. Then tell Composer to require the plugin, and Craft to install it:

```bash title="Composer"
composer require lindemannrock/craft-formie-paragraph-field && php craft plugin/install formie-paragraph-field
```

```bash title="DDEV"
ddev composer require lindemannrock/craft-formie-paragraph-field && ddev craft plugin/install formie-paragraph-field
```

## Post-Install Setup

Formie Paragraph Field works as soon as it and Formie are installed and enabled — there is no salt to generate or template to copy.

### Review configuration

Use **Open Formie Paragraph Field** on the install welcome screen, or go to **Settings → Plugins → Formie Paragraph Field**. Choose the default text size for new Paragraph fields and, if needed, change the plugin name shown in the Control Panel.

See [Configuration](configuration.md) for config-file overrides and custom text sizes.

## Quick Start

See [Quickstart](quickstart.md) for the fastest path from install to your first paragraph on a form.
