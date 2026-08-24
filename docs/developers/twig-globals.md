# Twig globals

Use `formieParagraphFieldHelper` when a Twig template needs the plugin's configured display name instead of a hard-coded label.

## `formieParagraphFieldHelper`

*Provided by `lindemannrock/base`*

| Property | Description |
|----------|-------------|
| `formieParagraphFieldHelper.displayName` | Display name (singular, without "Manager") |
| `formieParagraphFieldHelper.pluralDisplayName` | Plural display name (without "Manager") |
| `formieParagraphFieldHelper.fullName` | Full plugin name (as configured) |
| `formieParagraphFieldHelper.lowerDisplayName` | Lowercase display name (singular) |
| `formieParagraphFieldHelper.pluralLowerDisplayName` | Lowercase plural display name |

### Examples

```twig
{{ formieParagraphFieldHelper.displayName }}
{{ formieParagraphFieldHelper.pluralDisplayName }}
{{ formieParagraphFieldHelper.fullName }}
{{ formieParagraphFieldHelper.lowerDisplayName }}
{{ formieParagraphFieldHelper.pluralLowerDisplayName }}
```
