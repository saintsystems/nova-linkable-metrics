<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Illuminate\Database\Eloquent\Builder;

trait LinkableResult
{
    /**
     * The metric value url.
     *
     * @var string
     */
    public $url;

    /**
     * Set the metric value url.
     *
     * @param  string  $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set a link to a route
     */
    public function route($routeName, array $params = [], array $query = [])
    {
        $route = [
            'name' => $routeName,
            'params' => $params,
            'query' => $query
        ];
        return $this->url(json_encode($route));
    }

    /**
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'url' => $this->url,
        ]);
    }

}
