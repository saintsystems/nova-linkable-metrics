<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Illuminate\Database\Eloquent\Builder;

trait Linkable
{
    public $url = '';

    public function component()
    {
        return 'linkable-'.$this->component;
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
     * Which url should the metric link to
     */
    public function url($url)
    {
        return $this->withMeta(['url' => $url]);
    }

}
