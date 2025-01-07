<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableValue
{
    use Linkable;

    /**
     * Create a new value metric result.
     *
     * @param  mixed  $value
     */
    public function result($value): LinkableValueResult
    {
        $linkableValueResult = new LinkableValueResult($value);
        if (!empty($this->url)) {
            $linkableValueResult->url($this->url);
        }
        return $linkableValueResult;
    }
}

