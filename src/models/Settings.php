<?php
/**
 * Formie Paragraph Field plugin for Craft CMS 5.x
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2025 LindemannRock
 */

namespace lindemannrock\formieparagraphfield\models;

use Craft;
use craft\base\Model;
use lindemannrock\base\helpers\SettingsPostHelper;
use lindemannrock\base\traits\PluginNameSettingsTrait;
use lindemannrock\base\traits\SettingsConfigTrait;
use lindemannrock\base\traits\SettingsDisplayNameTrait;

/**
 * Formie Paragraph Field Settings Model
 *
 * @author    LindemannRock
 * @package   FormieParagraphField
 * @since     1.0.0
 */
class Settings extends Model
{
    use PluginNameSettingsTrait;
    use SettingsConfigTrait;
    use SettingsDisplayNameTrait;

    /**
     * @var array<string, array<int, string>>
     */
    private array $settingsPostErrors = [];
    /**
     * @var string The name of the plugin as it appears in the Control Panel menu
     */
    public string $pluginName = 'Formie Paragraph Field';

    /**
     * @var string Default text size (textXS, textSM, textBase, textLG, textXL)
     */
    public string $defaultTextSize = 'textBase';

    /**
     * @var array Custom text size options
     * Format: ['value' => 'label', 'classes' => 'tailwind classes']
     */
    public array $customTextSizes = [];

    /**
     * @inheritdoc
     */
    public function setAttributes($values, $safeOnly = true): void
    {
        if (!is_array($values)) {
            parent::setAttributes($values, $safeOnly);
            return;
        }

        $this->settingsPostErrors = [];

        $result = SettingsPostHelper::apply(
            model: $this,
            postedValues: $values,
            allowedAttributes: $this->settingsPostAttributes(),
            isOverridden: fn(string $attribute): bool => $this->isOverriddenByConfig($attribute),
        );

        if ($result->hasErrors) {
            $this->settingsPostErrors = $this->getErrors();
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate(): bool
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->settingsPostErrors !== []) {
            foreach ($this->settingsPostErrors as $attribute => $errors) {
                foreach ($errors as $error) {
                    $this->addError($attribute, $error);
                }
            }

            $this->settingsPostErrors = [];
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function defineRules(): array
    {
        return array_merge([
            [['defaultTextSize'], 'string'],
            [['customTextSizes'], 'safe'],
            [['defaultTextSize'], 'validateDefaultTextSize'],
        ], $this->pluginNameSettingsRules());
    }

    /**
     * Validate default text size against available options
     */
    public function validateDefaultTextSize($attribute, $params)
    {
        $availableOptions = $this->getAvailableTextSizes();
        $availableValues = array_keys($availableOptions);

        if (!in_array($this->$attribute, $availableValues)) {
            $this->addError($attribute, Craft::t('formie-paragraph-field', 'Default text size must be one of: {values}', [
                'values' => implode(', ', $availableValues),
            ]));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return array_merge([
            'defaultTextSize' => Craft::t('formie-paragraph-field', 'Default Text Size'),
            'customTextSizes' => Craft::t('formie-paragraph-field', 'Custom Text Sizes'),
        ], $this->pluginNameSettingsLabel());
    }

    /**
     * Get all available text sizes (custom if defined, otherwise default)
     * @return array
     */
    public function getAvailableTextSizes(): array
    {
        // If custom sizes are defined, use only those
        if (!empty($this->customTextSizes)) {
            return $this->customTextSizes;
        }

        // Otherwise use default sizes
        return [
            'textXS' => [
                'label' => Craft::t('formie-paragraph-field', 'Extra Small'),
                'classes' => 'text-xs',
            ],
            'textSM' => [
                'label' => Craft::t('formie-paragraph-field', 'Small'),
                'classes' => 'text-sm',
            ],
            'textBase' => [
                'label' => Craft::t('formie-paragraph-field', 'Base'),
                'classes' => 'text-base',
            ],
            'textLG' => [
                'label' => Craft::t('formie-paragraph-field', 'Large'),
                'classes' => 'text-base sm:text-lg md:text-xl',
            ],
            'textXL' => [
                'label' => Craft::t('formie-paragraph-field', 'Extra Large'),
                'classes' => 'text-lg sm:text-xl md:text-2xl',
            ],
        ];
    }

    /**
     * Get text size classes for a given size value
     * @param string|null $size
     * @return string
     */
    public function getTextSizeClasses(?string $size): string
    {
        if ($size === null) {
            return 'text-base';
        }
        $availableSizes = $this->getAvailableTextSizes();
        return $availableSizes[$size]['classes'] ?? 'text-base';
    }

    /**
     * Plugin handle for config file resolution
     */
    protected static function pluginHandle(): string
    {
        return 'formie-paragraph-field';
    }

    /**
     * @return array<int, string>
     */
    private function settingsPostAttributes(): array
    {
        return [
            'pluginName',
            'defaultTextSize',
            'customTextSizes',
        ];
    }
}
