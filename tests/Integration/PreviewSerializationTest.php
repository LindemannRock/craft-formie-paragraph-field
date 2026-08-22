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
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Protects JavaScript literals across Formie's preview delimiter rewrite.
 *
 * @since 3.6.0
 */
final class PreviewSerializationTest extends TestCase
{
    #[DataProvider('customOptionProvider')]
    public function testCustomOptionSurvivesFormieDelimiterRewrite(string $key, string $label): void
    {
        $settings = FormieParagraphField::$plugin->getSettings();
        $original = $settings->customTextSizes;

        try {
            $settings->customTextSizes = [
                $key => [
                    'label' => $label,
                    'classes' => 'test-size',
                ],
            ];

            $preview = (new Paragraph(['textSize' => $key]))->getPreviewInputHtml();
            $rewritten = str_replace(['${', '}'], ['{{', '}}'], $preview);
            $encodedKey = self::delimiterNeutralJson($key);
            $encodedLabel = self::delimiterNeutralJson($label);

            self::assertStringContainsString("field.settings.textSize === {$encodedKey}", $preview);
            self::assertStringContainsString("? {$encodedLabel} : {$encodedLabel}", $preview);
            self::assertStringContainsString("field.settings.textSize === {$encodedKey}", $rewritten);
            self::assertStringContainsString("? {$encodedLabel} : {$encodedLabel}", $rewritten);
            self::assertSame($key, json_decode($encodedKey, true, flags: JSON_THROW_ON_ERROR));
            self::assertSame($label, json_decode($encodedLabel, true, flags: JSON_THROW_ON_ERROR));
        } finally {
            $settings->customTextSizes = $original;
        }
    }

    public static function customOptionProvider(): array
    {
        return [
            'closing brace' => ['size}', 'Break } label'],
            'template opener' => ['price${tier}', 'Price ${value}'],
            'quotes and slash' => ['quote"slash\\', 'Quote " and reverse \\'],
            'unicode and html-like text' => ['size-日本語', '日本語 </div><img src=x onerror=alert(1)>'],
        ];
    }

    private static function delimiterNeutralJson(string $value): string
    {
        return str_replace(
            ['$', '{', '}'],
            ['\\u0024', '\\u007B', '\\u007D'],
            json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
        );
    }
}
