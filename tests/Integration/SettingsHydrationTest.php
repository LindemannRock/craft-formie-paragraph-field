<?php
/**
 * LindemannRock Formie Paragraph Field
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2026 LindemannRock
 */

declare(strict_types=1);

namespace lindemannrock\formieparagraphfield\tests\Integration;

use lindemannrock\formieparagraphfield\models\Settings;
use lindemannrock\formieparagraphfield\tests\TestCase;

/**
 * Protects typed native settings and merged config hydration.
 *
 * @since 3.6.0
 */
final class SettingsHydrationTest extends TestCase
{
    public function testMergedConfigValuesReachTypedSettings(): void
    {
        $settings = new Settings();
        $settings->setAttributes([
            'pluginName' => 'Configured Paragraphs',
            'defaultTextSize' => 'textLG',
            'customTextSizes' => [
                'textLead' => [
                    'label' => 'Lead',
                    'classes' => 'lead',
                ],
            ],
        ], false);

        self::assertSame('Configured Paragraphs', $settings->pluginName);
        self::assertSame('textLG', $settings->defaultTextSize);
        self::assertSame([
            'textLead' => [
                'label' => 'Lead',
                'classes' => 'lead',
            ],
        ], $settings->customTextSizes);
    }

    public function testHostileScalarCannotReplaceTypedCustomSizes(): void
    {
        $settings = new Settings();
        $original = [
            'textOwned' => [
                'label' => 'Owned',
                'classes' => 'owned',
            ],
        ];
        $settings->customTextSizes = $original;

        $settings->setAttributes(['customTextSizes' => 'not-an-array'], false);

        self::assertSame($original, $settings->customTextSizes);
        self::assertFalse($settings->validate());
        self::assertSame(['Value must be an array.'], $settings->getErrors('customTextSizes'));
    }

    public function testExplicitBaseSizeSurvivesHydration(): void
    {
        $settings = new Settings();
        $settings->defaultTextSize = 'textXL';

        $settings->setAttributes(['defaultTextSize' => 'textBase'], false);

        self::assertSame('textBase', $settings->defaultTextSize);
        self::assertTrue($settings->validate());
    }
}
