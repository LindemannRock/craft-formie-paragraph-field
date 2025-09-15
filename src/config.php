<?php
/**
 * Formie Paragraph Field Plugin Configuration
 *
 * Copy this file to your craft/config/ directory as 'formie-paragraph-field.php'
 * to override plugin settings.
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2025 LindemannRock
 */

return [
    /**
     * Plugin name (optional)
     * Override the plugin name shown in the Control Panel.
     * Usually set via Settings → Plugins → Formie Paragraph Field instead.
     */
    // 'pluginName' => 'Custom Paragraph Field Name',
    
    /**
     * Default text size for new paragraph fields
     * Must be one of the available text size values
     */
    'defaultTextSize' => 'textBase',
    
    /**
     * Custom text size options
     * 
     * Add your own text size options that will appear in the Formie field settings.
     * Each option should have a 'label' (shown in dropdown) and 'classes' (CSS classes applied).
     * 
     * You can use any CSS classes - Tailwind, custom CSS, Bootstrap, etc.
     */
    'customTextSizes' => [
        // Example: Large heading style
        'textDisplay' => [
            'label' => 'Display Heading',
            'classes' => 'text-3xl md:text-5xl font-bold leading-tight'
        ],
        
        // Example: Small disclaimer text
        'textDisclaimer' => [
            'label' => 'Disclaimer',
            'classes' => 'text-xs text-gray-600 italic'
        ],
        
        // Example: Custom brand styling
        'textBrand' => [
            'label' => 'Brand Text',
            'classes' => 'text-lg font-brand text-brand-primary'
        ],
        
        // Example: Bootstrap classes (if using Bootstrap)
        'textLead' => [
            'label' => 'Lead Paragraph',
            'classes' => 'lead fw-normal'
        ],
        
        // Example: Completely custom CSS
        'textSpecial' => [
            'label' => 'Special Text',
            'classes' => 'my-special-paragraph-style custom-font'
        ]
    ]
];