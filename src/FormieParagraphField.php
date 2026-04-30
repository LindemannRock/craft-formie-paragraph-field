<?php
/**
 * Formie Paragraph Field plugin for Craft CMS 5.x
 *
 * Paragraph field for Formie - Provides a multi-line paragraph field type
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2025 LindemannRock
 */

namespace lindemannrock\formieparagraphfield;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use lindemannrock\base\helpers\PluginHelper;
use lindemannrock\formieparagraphfield\fields\Paragraph;
use lindemannrock\formieparagraphfield\models\Settings;
use verbb\formie\events\RegisterFieldsEvent;
use verbb\formie\services\Fields;
use yii\base\Event;

/**
 * Formie Paragraph Field Plugin
 *
 * @author    LindemannRock
 * @package   FormieParagraphField
 * @since     1.0.0
 *
 * @property-read Settings $settings
 * @method Settings getSettings()
 */
class FormieParagraphField extends Plugin
{
    /**
     * @var FormieParagraphField|null Singleton plugin instance
     */
    public static ?FormieParagraphField $plugin = null;

    /**
     * @var string Plugin schema version for migrations
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool Whether the plugin exposes a control panel settings page
     */
    public bool $hasCpSettings = true;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        // Bootstrap the base plugin helper
        PluginHelper::bootstrap($this, 'formieParagraphFieldHelper', [], [], [
            'installExperience' => [
                'headline' => Craft::t('formie-paragraph-field', 'Formie Paragraph Field'),
                'body' => Craft::t('formie-paragraph-field', 'Configure paragraph fields and manage default text settings from the plugin settings area.'),
                'ctaLabel' => Craft::t('formie-paragraph-field', 'Open Formie Paragraph Field'),
                'ctaUrl' => 'settings/plugins/formie-paragraph-field',
                'redirectUri' => 'settings/plugins/formie-paragraph-field',
                'confettiPreset' => 'surprise',
            ],
        ]);

        // Set the alias for this plugin
        Craft::setAlias('@lindemannrock/formieparagraphfield', __DIR__);
        Craft::setAlias('@formie-paragraph-templates', __DIR__ . '/templates');

        // Register view paths for Formie
        if (Craft::$app->request->getIsSiteRequest()) {
            Event::on(
                View::class,
                View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
                function(RegisterTemplateRootsEvent $event) {
                    $event->roots['formie-paragraph-field'] = __DIR__ . '/templates';
                }
            );
        }
        
        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['formie-paragraph-field'] = __DIR__ . '/templates';
            }
        );

        // Register our field
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELDS,
            function(RegisterFieldsEvent $event) {
                $event->fields[] = Paragraph::class;
            }
        );

        // Set the plugin name from settings
        $settings = $this->getSettings();
        if (!empty($settings->pluginName)) {
            $this->name = $settings->pluginName;
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }
    
    /**
     * @inheritdoc
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate(
            'formie-paragraph-field/settings',
            [
                'settings' => $this->getSettings(),
                'plugin' => $this,
            ]
        );
    }
}
