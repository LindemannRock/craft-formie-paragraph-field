<?php
/**
 * LindemannRock Formie Paragraph Field
 *
 * @link      https://lindemannrock.com
 * @copyright Copyright (c) 2026 LindemannRock
 */

declare(strict_types=1);

namespace lindemannrock\formieparagraphfield\tests;

use lindemannrock\base\testing\IntegrationTestCase;

/**
 * Base case for package-owned Formie Paragraph Field behavior.
 *
 * The suite writes no plugin DB rows, queues, caches, Redis keys, or durable
 * files. Tests that temporarily mutate the singleton settings restore the
 * exact prior attributes in `finally`; inherited temp paths self-clean.
 *
 * @since 3.6.0
 */
abstract class TestCase extends IntegrationTestCase
{
}
