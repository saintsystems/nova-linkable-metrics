<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Laravel\Nova\Metrics\ValueResult;

class LinkableValueResult extends ValueResult
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
