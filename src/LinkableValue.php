<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableValue
{
    use Linkable;

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

