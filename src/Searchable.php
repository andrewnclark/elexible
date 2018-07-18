<?php

namespace Techquity\Elexible;

trait Searchable
{
    use \Laravel\Scout\Searchable;

    /**
     * Elasticsearch type to be used within Elasticsearch index
     *
     * @return string
     */
    public function SearchableType()
    {
        return '_doc';
    }


    /**
     * Perform a search against the model's indexed data.
     *
     * @param  string  $query
     * @param  \Closure  $callback
     * @return Builder
     */
    public static function search($query = null, $callback = null)
    {
        return new Builder(new static, $query, $callback);
    }
}