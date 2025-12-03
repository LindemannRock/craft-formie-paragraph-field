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

        // Set the alias for this plugin
        Craft::setAlias('@lindemannrock/formieparagraphfield', __DIR__);
        Craft::setAlias('@formie-paragraph-templates', __DIR__ . '/templates');
        
        // Create class alias for backward compatibility with existing forms
        class_alias(
            \lindemannrock\formieparagraphfield\fields\Paragraph::class,
            'lindemannrock\modules\formieparagraphfield\fields\Paragraph'
        );
        
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
                
                Craft::info(
                    'Registered Paragraph field for Formie',
                    __METHOD__
                );
            }
        );
        
        // Set the plugin name from settings
        $settings = $this->getSettings();
        if (!empty($settings->pluginName)) {
            $this->name = $settings->pluginName;
        }

        Craft::info(
            'Formie Paragraph Field plugin loaded',
            __METHOD__
        );
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
