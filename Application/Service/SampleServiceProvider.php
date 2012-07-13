<?php
namespace Sandbox\Application\Service;

use Alchemy\Application;
use Alchemy\ServiceProviderInterface;

class SampleServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Sample class on the Application ServiceProvider
     *
     * @param Application $app phpalchemy Application
     */
    public function register(Application $app)
    {
        $app['sp_sample'] = $app->share(function () use ($app) {
            return new Utils($app);
        });
    }

    public function init(Application $app)
    {
    }
}