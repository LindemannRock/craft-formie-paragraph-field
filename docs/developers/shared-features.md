# Shared features

Formie Paragraph Field uses LindemannRock Plugin Base 5.26 or newer for the small pieces of shared behavior that should stay consistent across plugins. You normally do not call these APIs yourself, but knowing their role helps when diagnosing settings or template behavior.

## Plugin bootstrap and Twig names

`PluginHelper::bootstrap()` initializes the shared plugin helpers and registers the `formieParagraphFieldHelper` Twig global. See [Twig globals](twig-globals.md) for the values it exposes.

## Settings behavior

The settings model uses these shared contracts:

| Shared API | What it does here |
|---|---|
| `PluginNameSettingsTrait` | Validates the configurable Control-Panel plugin name and rejects HTML or control characters. |
| `SettingsConfigTrait` | Detects values supplied by `config/formie-paragraph-field.php`, allowing the settings page to show and lock config-controlled fields. |
| `SettingsDisplayNameTrait` | Derives the display-name forms used by the Twig helper. |
| `SettingsPostHelper` | Normalizes native settings POST values before assigning them to typed properties, so malformed array input becomes a validation error instead of a PHP type failure. |

These APIs are why the package requires Plugin Base 5.26+: that is the first Base release containing the complete settings contract used by this plugin.

## Next steps

- [Configuration](../get-started/configuration.md) explains the Control-Panel and config-file precedence.
- [Twig globals](twig-globals.md) lists the shared display-name values available to templates.
