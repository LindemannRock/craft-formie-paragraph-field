<?php
/**
 * Formie Paragraph Field config.php
 *
 * This file exists only as a template for the Formie Paragraph Field settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'formie-paragraph-field.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    // Global settings
    '*' => [
        // ========================================
        // GENERAL SETTINGS
        // ========================================
        // Basic plugin configuration

        /**
         * Plugin name (optional)
         * Override the plugin name shown in the Control Panel.
         * Usually set via Settings → Plugins → Formie Paragraph Field instead.
         */
        // 'pluginName' => 'Custom Paragraph Field Name',


        // ========================================
        // FIELD SETTINGS
        // ========================================
        // Default settings for paragraph fields

        /**
         * Default text size for new paragraph fields
         * Must be one of the available text size values
         * Options: 'textXS', 'textSM', 'textBase', 'textLG', 'textXL'
         */
        'defaultTextSize' => 'textBase',

        /**
         * Custom text size options
         *
         * Add your own text size options that will appear in the Formie field settings.
         * Each option should have a 'label' (shown in dropdown) and 'classes' (CSS classes applied).
         *
         * You can use any CSS classes - Tailwind, custom CSS, Bootstrap, etc.
         *
         * When defined, these options REPLACE the built-in size options entirely.
         */
        'customTextSizes' => [
            // Example: Large heading style
            // 'textDisplay' => [
            //     'label' => 'Display Heading',
            //     'classes' => 'text-3xl md:text-5xl font-bold leading-tight'
            // ],

            // Example: Small disclaimer text
            // 'textDisclaimer' => [
            //     'label' => 'Disclaimer',
            //     'classes' => 'text-xs text-gray-600 italic'
            // ],

            // Example: Custom brand styling
            // 'textBrand' => [
            //     'label' => 'Brand Text',
            //     'classes' => 'text-lg font-brand text-brand-primary'
            // ],

            // Example: Bootstrap classes (if using Bootstrap)
            // 'textLead' => [
            //     'label' => 'Lead Paragraph',
            //     'classes' => 'lead fw-normal'
            // ],

            // Example: Completely custom CSS
            // 'textSpecial' => [
            //     'label' => 'Special Text',
            //     'classes' => 'my-special-paragraph-style custom-font'
            // ]
        ],
    ],

    // Dev environment settings
    'dev' => [
        // Development-specific settings can go here
    ],

    // Staging environment settings
    'staging' => [
        // Staging-specific settings can go here
    ],

    // Production environment settings
    'production' => [
        // Production-specific settings can go here
    ],
];
