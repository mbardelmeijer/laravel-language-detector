<?php

namespace Vluzrmos\LanguageDetector\Testing;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

/**
 * Class LanguageDetectorServiceProviderTest.
 */
class LanguageDetectorServiceProviderTest extends TestCase
{
    /**
     * Registering the service provider.
     */
    public function testShouldRegisterServiceProvider()
    {
        $drivers = ['browser', 'subdomain', 'uri'];

        foreach ($drivers as $shortcut) {
            $this->assertInstanceOf(
                'Vluzrmos\LanguageDetector\Contracts\DetectorDriverInterface',
                $this->app['language.driver.'.$shortcut]
            );
        }

        $this->assertInstanceOf(
            'Vluzrmos\LanguageDetector\Contracts\LanguageDetectorInterface',
            $this->app['language.detector']
        );

        $this->assertInstanceOf(
            'Vluzrmos\LanguageDetector\Contracts\LanguageDetectorInterface',
            $this->app['Vluzrmos\LanguageDetector\Contracts\LanguageDetectorInterface']
        );

        $this->app['translator']->setLocale('fr');

        $this->app['language.detector']->detectAndApply();

        $this->assertEquals('en', $this->app['translator']->getLocale());
    }

    /**
     * @param Application $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        return [
            'Vluzrmos\LanguageDetector\Providers\LanguageDetectorServiceProvider',
        ];
    }
}
