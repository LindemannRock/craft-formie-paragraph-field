<?php
/**
 * LindemannRock Formie Paragraph Field
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2026 LindemannRock
 */

declare(strict_types=1);

namespace lindemannrock\formieparagraphfield\tests\Integration;

use lindemannrock\formieparagraphfield\fields\Paragraph;
use lindemannrock\formieparagraphfield\FormieParagraphField;
use lindemannrock\formieparagraphfield\tests\TestCase;

/**
 * Protects new-field defaults without overwriting saved values.
 *
 * @since 3.6.0
 */
final class ParagraphDefaultingTest extends TestCase
{
    public function testNewFieldInheritsConfiguredDefault(): void
    {
        $settings = FormieParagraphField::$plugin->getSettings();
        $original = $settings->defaultTextSize;

        try {
            $settings->defaultTextSize = 'textXL';

            self::assertSame('textXL', (new Paragraph())->textSize);
        } finally {
            $settings->defaultTextSize = $original;
        }
    }

    public function testExplicitBaseSizeIsNotOverwrittenByConfiguredDefault(): void
    {
        $settings = FormieParagraphField::$plugin->getSettings();
        $original = $settings->defaultTextSize;

        try {
            $settings->defaultTextSize = 'textXL';

            self::assertSame('textBase', (new Paragraph(['textSize' => 'textBase']))->textSize);
        } finally {
            $settings->defaultTextSize = $original;
        }
    }
}
