<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;

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

        $this->setupBrowserMacro();
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

    public function setupBrowserMacro()
    {
        Browser::macro('findElementByText', function ($selector, $text) {
            foreach ($this->resolver->all($selector) as $element) {
                if (Str::contains($element->getText(), $text)) {
                    return $element;
                }
            }

            return null;
        });

        Browser::macro('takeElementScreenshot', function (RemoteWebElement $element, $name) {
            $element->takeElementScreenshot(sprintf(
                '%s/elements/%s.png',
                rtrim(Browser::$storeScreenshotsAt, '/'),
                $name
            ));
        });
    }
}
