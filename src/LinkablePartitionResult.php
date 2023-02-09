<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Laravel\Nova\Metrics\PartitionResult;

class LinkablePartitionResult extends PartitionResult
{
    use LinkableResult;

    /**
     * The partition links.
     *
     * @var array<string, string>
     */
    public $links = [];

    public function links($links)
    {
        $this->links = $links;
    }

    /**
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize() : array
    {
        return array_merge(parent::jsonSerialize(), [
            'url' => $this->url,
            'partitionLinks' => $this->links,
        ]);
    }
}
