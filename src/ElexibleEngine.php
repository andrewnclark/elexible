<?php

namespace Techquity\Elexible;

use Elasticsearch\Client;
use Laravel\Scout\Builder;
use ONGR\ElasticsearchDSL\Search;
use Laravel\Scout\Engines\Engine;

class ElexibleEngine extends Engine
{
    protected $elastic;

    /**
     * ElasticEngine constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->elastic = $client;
    }
    /**
     * Update the given model in the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     * @return void
     */
    public function update($models)
    {
        $body = $models->map(function($model) {
            return $model->toSearchableArray();
        });

        $body->prepend(['index' => $models->first()->getIndexParams()]);

        $response = $this->elastic->bulk([
           'refresh' => true,
           'body' => $body->all()
        ]);

        /**
         * @todo some form of error
         */
    }

    /**
     * Remove the given model from the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     * @return void
     */
    public function delete($models)
    {
        $deletes = $models->map(function($model) {
            return ['delete' => $model->getIndexParams()];
        });

        $response = $this->elastic->bulk([
            'refresh' => true,
            'body' => $deletes->all()
        ]);

        /**
         * @todo some form of error
         */
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        $search = new Search();
        $search->addQuery($builder);
        $dsl = new MatchAllQuery();
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder $builder
     * @param  int                    $perPage
     * @param  int                    $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        // TODO: Implement paginate() method.
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
        // TODO: Implement mapIds() method.
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  mixed                               $results
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function map($results, $model)
    {
        // TODO: Implement map() method.
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed $results
     * @return int
     */
    public function getTotalCount($results)
    {
        // TODO: Implement getTotalCount() method.
    }
}