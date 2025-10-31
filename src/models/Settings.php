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

/**
 * Formie Paragraph Field Settings Model
 *
 * @author    LindemannRock
 * @package   FormieParagraphField
 * @since     1.0.0
 */
class Settings extends Model
{
    /**
     * @var string|null The public-facing name of the plugin
     */
    public ?string $pluginName = 'Formie Paragraph Field';

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
    public function defineRules(): array
    {
        return [
            [['pluginName', 'defaultTextSize'], 'string'],
            [['customTextSizes'], 'safe'],
            [['defaultTextSize'], 'validateDefaultTextSize'],
        ];
    }

    /**
     * Validate default text size against available options
     */
    public function validateDefaultTextSize($attribute, $params)
    {
        $availableOptions = $this->getAvailableTextSizes();
        $availableValues = array_keys($availableOptions);

        if (!in_array($this->$attribute, $availableValues)) {
            $this->addError($attribute, 'Default text size must be one of: ' . implode(', ', $availableValues));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'pluginName' => Craft::t('formie-paragraph-field', 'Plugin Name'),
            'defaultTextSize' => Craft::t('formie-paragraph-field', 'Default Text Size'),
            'customTextSizes' => Craft::t('formie-paragraph-field', 'Custom Text Sizes'),
        ];
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
                'label' => 'Extra Small',
                'classes' => 'text-xs'
            ],
            'textSM' => [
                'label' => 'Small',
                'classes' => 'text-sm'
            ],
            'textBase' => [
                'label' => 'Base',
                'classes' => 'text-base'
            ],
            'textLG' => [
                'label' => 'Large',
                'classes' => 'text-base sm:text-lg md:text-xl'
            ],
            'textXL' => [
                'label' => 'Extra Large',
                'classes' => 'text-lg sm:text-xl md:text-2xl'
            ],
        ];
    }

    /**
     * Get text size classes for a given size value
     * @param string $size
     * @return string
     */
    public function getTextSizeClasses(string $size): string
    {
        $availableSizes = $this->getAvailableTextSizes();
        return $availableSizes[$size]['classes'] ?? 'text-base';
    }

    /**
     * Check if a setting is overridden in config file
     *
     * @param string $setting
     * @return bool
     */
    public function isOverriddenByConfig(string $setting): bool
    {
        $configFileSettings = Craft::$app->getConfig()->getConfigFromFile('formie-paragraph-field');
        return isset($configFileSettings[$setting]);
    }
}
