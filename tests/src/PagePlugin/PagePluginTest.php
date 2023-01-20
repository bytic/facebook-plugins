<?php

declare(strict_types=1);

namespace ByTIC\FacebookPlugins\Tests\PagePlugin;

use ByTIC\FacebookPlugins\PagePlugin\PagePlugin;
use PHPUnit\Framework\TestCase;

class PagePluginTest extends TestCase
{
    public function test_simple_iframe()
    {
        $plugin = PagePlugin::forPage('https://www.facebook.com/ByTIC');
        $plugin->setAppId('191111854321857');

        $iframe = $plugin->getIframeCode();
        self::assertSame(
            file_get_contents(TEST_FIXTURE_PATH . '/PagePlugin/basic.html'),
            $iframe
        );
    }
}
