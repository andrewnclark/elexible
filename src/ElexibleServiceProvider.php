<?php

namespace Techquity\Elexible;

use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;

class ElexibleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/elastic.php', 'scout.elastic'
        );
        config(['scout.driver' => 'elastic']);
        resolve(EngineManager::class)->extend('elastic', function () {
            $client = ClientBuilder::create()->setHosts(config('scout.elastic.hosts', ['localhost:9200']))->build();
            return new ElexibleEngine($client);
        });
        $this->app->bind(\Laravel\Scout\Builder::class, function ($model, $query, $callback = null) {
            return new Builder($model, $query, $callback);
        });
    }
}