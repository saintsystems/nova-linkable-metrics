<?php

namespace SaintSystems\Nova\LinkableMetrics;

trait LinkablePartition
{
    use Linkable;

    /**
     * Create a new value metric result.
     *
     * @param  mixed  $value
     * @return \SaintSystems\Nova\LinkableMetrics\LinkablePartitionResult
     */
    public function result(array $value)
    {
        $linkablePartitionResult = new LinkablePartitionResult(collect($value)->map(function ($number) {
            return round($number, $this->roundingPrecision, $this->roundingMode);
        })->toArray());
        if (!empty($this->url)) {
            $linkablePartitionResult->url($this->url);
        }
        return $linkablePartitionResult;
    }
}
