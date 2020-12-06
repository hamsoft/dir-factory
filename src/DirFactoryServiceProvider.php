<?php

namespace Hamsoft\DirFactory;

use Illuminate\Support\ServiceProvider;

class DirFactoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->mergeConfigFrom(
                $this->getConfigFile(),
                'directories'
            );

            $this->commands([CreateDirectory::class]);

            $this->publishes([
                $this->getConfigFile() => config_path('directories.php'),
            ], 'directories');
        }


    }

    /**
     * @return string
     */
    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'directories.php';
    }
}
