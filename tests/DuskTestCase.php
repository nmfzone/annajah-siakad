<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Assert as PHPUnit;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }

        (new Filesystem)->put(
            __DIR__ . '/../storage/framework/testing/duskdb.sqlite',
            ''
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('public');

        $this->registerBrowserMacro();
    }

    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY_W3C, $options->toArray()
            )
        );
    }

    public static function registerBrowserMacro()
    {
        /**
         * Find element by text.
         *
         * @param  string  $selector
         * @param  string  $text
         * @return \Facebook\WebDriver\Remote\RemoteWebElement|null
         */
        Browser::macro('findElementByText', function (string $selector, string $text) {
            foreach ($this->resolver->all($selector) as $element) {
                if (Str::contains($element->getText(), $text)) {
                    return $element;
                }
            }

            return null;
        });

        /**
         * Take element screenshot.
         *
         * @param  \Facebook\WebDriver\Remote\RemoteWebElement  $element
         * @param  string  $name
         * @return \Laravel\Dusk\Browser
         */
        Browser::macro('takeElementScreenshot', function (RemoteWebElement $element, string $name) {
            $element->takeElementScreenshot(sprintf(
                '%s/elements/%s.png',
                rtrim(Browser::$storeScreenshotsAt, '/'),
                $name
            ));

            return $this;
        });

        /**
         * Disable browser validation.
         *
         * @return \Laravel\Dusk\Browser
         */
        Browser::macro('disableBrowserValidation', function () {
            $this->script(
                'for(var f=document.forms,i=f.length;i--;)f[i].setAttribute("novalidate",i)'
            );

            return $this;
        });

        /**
         * Assert invalid feedback message.
         *
         * @param  string  $selector
         * @param  string  $feedback
         * @return \Laravel\Dusk\Browser
         */
        Browser::macro(
            'assertInvalidFeedback',
            function (string $selector, string $feedback, bool $secondParent = false) {
                $targetEl = $this->resolver->findOrFail($selector);

                $parentEl = $targetEl->findElement(
                    WebDriverBy::xpath('./..' . ($secondParent ? '/..' : ''))
                );
                $element = $parentEl->findElement(
                    WebDriverBy::cssSelector('.invalid-feedback')
                );

                PHPUnit::assertTrue(
                    $element->getText() == $feedback,
                    "Did not see invalid feedback [{$feedback}] for [{$selector}]."
                );

                return $this;
            }
        );

        /**
         * Remove element from page.
         *
         * @param  string  $selector
         * @return \Laravel\Dusk\Browser
         */
        Browser::macro('removeElement', function (string $selector, int $parents = 0) {
            $this->ensurejQueryIsAvailable();

            $findParent = '';
            if ($parents > 0) {
                foreach (range(1, $parents) as $item) {
                    $findParent .= '.parent()';
                }
            }

            $this->script("jQuery(\"{$selector}\"){$findParent}.remove()");

            return $this;
        });
    }
}
