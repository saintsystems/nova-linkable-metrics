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
     * Which url should the metric link to
     */
    public function url($url)
    {
        return $this->withMeta(['url' => $url]);
    }

    /**
     * Create a new value metric result.
     *
     * @param  mixed  $value
     * @return \SaintSystems\Nova\LinkableMetrics\LinkableValueResult
     */
    public function result($value)
    {
        $linkableValueResult = new LinkableValueResult($value);
        if (!empty($this->url)) {
            $linkableValueResult->url($this->url);
        }
        return $linkableValueResult;
    }

}
