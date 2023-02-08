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
     * Set a link to a named route
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        return $this->url(route($name, $parameters, $absolute));
    }

    /**
     * Which url should the metric link to
     */
    public function url($url)
    {
        return $this->withMeta(['url' => $url]);
    }

}
