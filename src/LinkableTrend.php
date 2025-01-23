<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkableTrend
{
    use Linkable;

    /**
     * Create a new value metric result.
     *
     * @param  mixed  $value
     * @return \SaintSystems\Nova\LinkableMetrics\LinkableTrendResult
     */
    public function result($value = null): LinkableTrendResult
    {
        $linkableTrendResult = new LinkableTrendResult($value);
        if (!empty($this->url)) {
            $linkableTrendResult->url($this->url);
        }
        return $linkableTrendResult;
    }
}

