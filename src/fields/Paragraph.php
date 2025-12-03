<?php
/**
 * Formie Paragraph Field plugin for Craft CMS 5.x
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2025 LindemannRock
 */

namespace lindemannrock\formieparagraphfield\fields;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\Template;
use GraphQL\Type\Definition\Type;

use lindemannrock\formieparagraphfield\FormieParagraphField;
use Twig\Markup;
use verbb\formie\base\CosmeticField;
use verbb\formie\elements\Form;
use verbb\formie\helpers\SchemaHelper;

use verbb\formie\models\HtmlTag;

class Paragraph extends CosmeticField
{
    // Static Methods
    // =========================================================================

    public static function displayName(): string
    {
        return Craft::t('formie', 'Paragraph');
    }

    public static function getSvgIcon(): string
    {
        return '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5 8H23M5 14H23M5 20H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
    }

    public static function getSvgIconPath(): string
    {
        return '';
    }


    // Properties
    // =========================================================================

    /**
     * @var string|null Paragraph content (supports Twig)
     */
    public ?string $paragraphContent = null;

    /**
     * @var string Text size key (e.g., textBase, textLG, custom)
     */
    public string $textSize = 'textBase';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        
        // Get plugin settings and apply defaults if properties are not set or are default
        $plugin = FormieParagraphField::$plugin;
        if ($plugin !== null && $this->textSize === 'textBase') {
            $settings = $plugin->getSettings();
            if ($settings->defaultTextSize) {
                $this->textSize = $settings->defaultTextSize;
            }
        }
    }
    
    /**
     * Get text size options for the field settings
     * @return array
     */
    private function getTextSizeOptions(): array
    {
        $plugin = FormieParagraphField::$plugin;

        if ($plugin !== null) {
            $settings = $plugin->getSettings();
            $availableSizes = $settings->getAvailableTextSizes();
            $options = [];
            foreach ($availableSizes as $value => $config) {
                $options[] = [
                    'label' => Craft::t('formie', $config['label']),
                    'value' => $value,
                ];
            }
            return $options;
        }

        // Fallback to default options if plugin not available
        return [
            ['label' => Craft::t('formie', 'Extra Large'), 'value' => 'textXL'],
            ['label' => Craft::t('formie', 'Large'), 'value' => 'textLG'],
            ['label' => Craft::t('formie', 'Base'), 'value' => 'textBase'],
            ['label' => Craft::t('formie', 'Small'), 'value' => 'textSM'],
            ['label' => Craft::t('formie', 'Extra Small'), 'value' => 'textXS'],
        ];
    }

    public function getPreviewInputHtml(): string
    {
        // Get the size label from the options (supports custom sizes)
        $sizeOptions = $this->getTextSizeOptions();
        $sizeMap = [];

        foreach ($sizeOptions as $option) {
            $sizeMap[$option['value']] = $option['label'];
        }

        // Create JavaScript cases for each size
        $jsCases = [];
        foreach ($sizeMap as $value => $label) {
            $jsCases[] = "field.settings.textSize === '" . addslashes($value) . "' ? '" . addslashes($label) . "'";
        }

        // Use first available option as fallback instead of hardcoded 'Base'
        $firstOption = !empty($sizeOptions) ? $sizeOptions[0]['label'] : 'Base';
        $jsCondition = implode(' : ', $jsCases) . " : '" . addslashes($firstOption) . "'";

        return '<div class="fui-field-input fui-field-paragraph">
            <div style="font-size: 10px; color: #999; margin-bottom: 4px;">
                Size: ${ ' . $jsCondition . ' }
            </div>
            <p v-if="field.settings.paragraphContent" style="color: #666; font-size: 14px; margin: 0; white-space: pre-wrap;">${ field.settings.paragraphContent }</p>
            <p v-else style="color: #999; font-size: 14px; margin: 0;">Paragraph content will appear here</p>
        </div>';
    }

    public function getFrontEndInputHtml(Form $form, mixed $value, array $renderOptions = []): Markup
    {
        // Get the paragraph content and render it through Twig to support translations
        $content = $this->getRenderedParagraphContent();

        // Get text size classes from plugin settings (supports custom sizes)
        $plugin = FormieParagraphField::$plugin;
        $textSizeClass = 'text-base'; // fallback

        if ($plugin !== null) {
            $settings = $plugin->getSettings();
            $textSizeClass = $settings->getTextSizeClasses($this->textSize);
        }
        
        // Fallback to hardcoded classes if plugin not available
        if ($textSizeClass === 'text-base' && $this->textSize !== 'textBase') {
            $defaultClasses = [
                'textXL' => 'text-lg sm:text-xl md:text-2xl',
                'textLG' => 'text-base sm:text-lg md:text-xl',
                'textBase' => 'text-base',
                'textSM' => 'text-sm',
                'textXS' => 'text-xs',
            ];
            $textSizeClass = $defaultClasses[$this->textSize] ?? 'text-base';
        }

        // Build classes array
        $classes = [
            'fui-paragraph',
            'text-brand',
            'block',
            $textSizeClass,
        ];

        // Add custom CSS classes if set
        if ($this->cssClasses) {
            $classes[] = $this->cssClasses;
        }

        // Return the paragraph with proper classes
        $html = '<p class="' . implode(' ', $classes) . '">' . $content . '</p>';

        return Template::raw($html);
    }

    public function getRenderedParagraphContent(): string
    {
        $content = trim($this->paragraphContent ?? '');

        if ($content) {
            // Check if content contains Twig syntax
            if (strpos($content, '{{') !== false || strpos($content, '{%') !== false) {
                // Content has Twig, render it as-is
                $variables = $this->getRenderOptions();
                $content = Craft::$app->getView()->renderString($content, $variables);
            } else {
                // Plain text content - automatically translate it
                $content = Craft::t('formie', $content);
            }

            // Convert line breaks to <br> tags after rendering
            $content = nl2br($content);
        }

        return $content;
    }
    
    /**
     * @inheritdoc
     */
    public function getSettingGqlTypes(): array
    {
        return array_merge(parent::getSettingGqlTypes(), [
            'paragraphContent' => [
                'name' => 'paragraphContent',
                'type' => Type::string(),
            ],
            'textSize' => [
                'name' => 'textSize',
                'type' => Type::string(),
            ],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public static function getEmailTemplatePath(): string
    {
        return '@formie-paragraph-templates/fields/paragraph/email';
    }


    public function defineGeneralSchema(): array
    {
        return [
            SchemaHelper::labelField([
                'label' => Craft::t('formie', 'Name'),
                'help' => Craft::t('formie', 'The name for this field displayed in the form builder.'),
            ]),
            SchemaHelper::textareaField([
                'label' => Craft::t('formie', 'Paragraph Content'),
                'help' => Craft::t('formie', 'The content to be displayed. Line breaks will be converted to <br> tags.'),
                'name' => 'paragraphContent',
                'validation' => 'required',
                'required' => true,
                'rows' => 4,
            ]),
            SchemaHelper::selectField([
                'label' => Craft::t('formie', 'Text Size'),
                'help' => Craft::t('formie', 'Choose the size for the paragraph text.'),
                'name' => 'textSize',
                'options' => $this->getTextSizeOptions(),
            ]),
            SchemaHelper::includeInEmailField(),
        ];
    }

    public function defineAdvancedSchema(): array
    {
        return [
            SchemaHelper::handleField(),
            SchemaHelper::cssClasses(),
            SchemaHelper::containerAttributesField(),
        ];
    }

    public function defineConditionsSchema(): array
    {
        return [
            SchemaHelper::enableConditionsField(),
            SchemaHelper::conditionsField(),
        ];
    }

    public function defineHtmlTag(string $key, array $context = []): ?HtmlTag
    {
        if ($key === 'fieldParagraph') {
            // Get text size classes from plugin settings (supports custom sizes)
            $plugin = FormieParagraphField::$plugin;
            $textSizeClass = 'text-base'; // fallback
            
            if ($plugin !== null) {
                $settings = $plugin->getSettings();
                $textSizeClass = $settings->getTextSizeClasses($this->textSize);
            }
            
            // Fallback to hardcoded classes if plugin not available
            if ($textSizeClass === 'text-base' && $this->textSize !== 'textBase') {
                $defaultClasses = [
                    'textXL' => 'text-lg sm:text-xl md:text-2xl',
                    'textLG' => 'text-base sm:text-lg md:text-xl',
                    'textBase' => 'text-base',
                    'textSM' => 'text-sm',
                    'textXS' => 'text-xs',
                ];
                $textSizeClass = $defaultClasses[$this->textSize] ?? 'text-base';
            }

            // Just add the size class, let Formie's theme config handle the rest
            return new HtmlTag('p', [
                'class' => $textSizeClass,
            ]);
        }

        return parent::defineHtmlTag($key, $context);
    }


    // Protected Methods
    // =========================================================================

    protected function cpInputHtml(mixed $value, ?ElementInterface $element, bool $inline): string
    {
        // Paragraph is a cosmetic field - just show the content in the submission view
        $content = $this->getRenderedParagraphContent();
        
        return '<div class="fui-paragraph-display" style="padding: 10px; background: #f7f7f7; border-radius: 4px; color: #666;">' .
               '<small style="display: block; color: #999; margin-bottom: 5px;">Paragraph Field</small>' .
               $content .
               '</div>';
    }
}
