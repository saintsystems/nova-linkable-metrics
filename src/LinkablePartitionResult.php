<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Closure;
use Laravel\Nova\Metrics\PartitionResult;

class LinkablePartitionResult extends PartitionResult
{
    use LinkableResult;

    /**
     * The custom partition links.
     *
     * @var array<string, string>
     */
    public $links = [];

    // public function links($links)
    // {
    //     $this->links = $links;
    // }

    // /**
    //  * The custom label links.
    //  *
    //  * @var \SaintSystems\Nova\LinkableMetrics\PartitionLinks
    //  */
    // public $links;

    // /**
    //  * Set the custom label links.
    //  *
    //  * @param  array<string, string>  $links
    //  * @return $this
    //  */
    // public function links(array $links)
    // {
    //     $this->links = new PartitionLinks($links);

    //     return $this;
    // }

    /**
     * Format the labels for the partition result.
     *
     * @param  \Closure(string):string  $callback
     * @return $this
     */
    public function link(Closure $callback)
    {
        $this->links = collect($this->value)->mapWithKeys(function ($value, $label) use ($callback) {
            return [$label => $callback($label !== '' ? $label : null)];
        })->all();

        return $this;
    }

    /**
     * Prepare the metric result for JSON serialization.
     *
     * @return array<string, array<array-key, array<string, mixed>>>
     */
    public function jsonSerialize(): array
    {
        $values = collect($this->value);
        $total = $values->sum();

        return [
            'value' => $values->map(function ($value, $label) use ($total) {
                $resolvedLabel = $this->labels[$label] ?? $label;
                $resolvedLink = $this->links[$label] ?? null;

                return array_filter([
                    'color' => data_get($this->colors->colors, $label, $this->colors->get($resolvedLabel)),
                    'link' => $resolvedLink,
                    'label' => $resolvedLabel,
                    'value' => $value,
                    'percentage' => $total > 0 ? round(($value / $total) * 100, $this->roundingPrecision, $this->roundingMode) : 0,
                ], function ($value) {
                    return ! is_null($value);
                });
            })->values()->all(),
            'url' => $this->url,
        ];

        // return array_merge(parent::jsonSerialize(), [
        //     'url' => $this->url,
        //     'partitionLinks' => $this->links,
        // ]);
    }
}
