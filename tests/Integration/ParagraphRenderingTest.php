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
use lindemannrock\formieparagraphfield\tests\TestCase;
use verbb\formie\elements\Form;
use verbb\formie\elements\Submission;
use verbb\formie\models\FieldLayout;
use verbb\formie\models\Notification;

/**
 * Protects the shared public, CP, and email-safe rendering boundary.
 *
 * @since 3.6.0
 */
final class ParagraphRenderingTest extends TestCase
{
    public function testContentIsEscapedBeforeLineBreakConversion(): void
    {
        $field = new Paragraph([
            'paragraphContent' => "  <script>alert(1)</script>\nSecond & final  ",
        ]);

        $content = $field->getRenderedParagraphContent();

        self::assertSame('&lt;script&gt;alert(1)&lt;/script&gt;<br />' . "\n" . 'Second &amp; final', $content);
        self::assertStringNotContainsString('<script>', $content);
    }

    public function testFrontEndClassAttributeEncodesAdminAuthoredClasses(): void
    {
        $field = new Paragraph([
            'paragraphContent' => 'Safe paragraph',
            'cssClasses' => 'notice" onmouseover="alert(1)<tag>',
        ]);

        $html = (string)$field->getFrontEndInputHtml(new Form(), null);

        self::assertStringContainsString(
            'notice&quot; onmouseover=&quot;alert(1)&lt;tag&gt;',
            $html,
        );
        self::assertStringNotContainsString('onmouseover="alert(1)', $html);
        self::assertStringContainsString('>Safe paragraph</p>', $html);
    }

    public function testIsolatedBuilderConsumerUsesTheParagraphBinding(): void
    {
        [$form, $field] = $this->isolatedFormAndField();

        $preview = $field->getPreviewInputHtml();

        self::assertSame($field, $form->getFieldByHandle('ownedParagraph'));
        self::assertStringContainsString('field.settings.paragraphContent', $preview);
        self::assertStringContainsString('field.settings.textSize', $preview);
        self::assertStringNotContainsString('<script>alert(1)</script>', $preview);
    }

    public function testIsolatedFrontendConsumerUsesEncodedContent(): void
    {
        [$form, $field] = $this->isolatedFormAndField();

        $html = (string)$field->getFrontEndInputHtml($form, null);

        $this->assertEncodedParagraph($html);
        self::assertStringContainsString('class="fui-paragraph text-brand block text-base"', $html);
    }

    public function testIsolatedCpSubmissionConsumerUsesEncodedContent(): void
    {
        [$form, $field] = $this->isolatedFormAndField();
        $submission = new Submission();
        $submission->setForm($form);

        $html = (string)$field->getCpInputHtml(null, $submission);

        $this->assertEncodedParagraph($html);
        self::assertStringContainsString('fui-paragraph-display', $html);
    }

    public function testIsolatedEmailConsumerRendersTheOwnedTemplateWithEncodedContent(): void
    {
        [$form, $field] = $this->isolatedFormAndField();
        $submission = new Submission();
        $submission->setForm($form);

        $html = $field->getEmailHtml($submission, new Notification(), null);

        self::assertIsString($html);
        $this->assertEncodedParagraph($html);
        self::assertStringContainsString('<tr>', $html);
    }

    public function testEmptyContentRendersAsEmptyString(): void
    {
        self::assertSame('', (new Paragraph(['paragraphContent' => " \n "]))->getRenderedParagraphContent());
    }

    /** @return array{Form, Paragraph} */
    private function isolatedFormAndField(): array
    {
        $layout = new FieldLayout();
        $layout->setPages([[
            'label' => 'Page 1',
            'rows' => [[
                'fields' => [[
                    'type' => Paragraph::class,
                    'handle' => 'ownedParagraph',
                    'label' => 'Owned paragraph',
                    'paragraphContent' => "<script>alert(1)</script>\nSecond & final",
                    'textSize' => 'textBase',
                    'includeInEmail' => true,
                ]],
            ]],
        ]]);
        $form = new Form();
        $form->setFormLayout($layout);
        $field = $form->getFieldByHandle('ownedParagraph');
        self::assertInstanceOf(Paragraph::class, $field);

        return [$form, $field];
    }

    private function assertEncodedParagraph(string $html): void
    {
        self::assertStringContainsString(
            '&lt;script&gt;alert(1)&lt;/script&gt;<br />' . "\n" . 'Second &amp; final',
            $html,
        );
        self::assertStringNotContainsString('<script>alert(1)</script>', $html);
    }
}
