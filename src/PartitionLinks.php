<?php

namespace SaintSystems\Nova\LinkableMetrics;

class PartitionLinks
{
    /**
     * The links array to use for the chart.
     *
     * @var array<string|int, string>
     */
    public $links;

    /**
     * The pointer to the current link in the chart array.
     *
     * @var int
     */
    private $pointer = 0;

    /**
     * Create a new instance.
     *
     * @param  array<string|int, string>  $links
     * @return void
     */
    public function __construct($links = [])
    {
        $this->links = $links;
    }

    /**
     * Get the link found at the given label key.
     *
     * @param  string|int  $label
     * @return string|null
     */
    public function get($label)
    {
        return $this->links[$label] ?? $this->next();
    }

    /**
     * Return the next link in the link list.
     *
     * @return null|string
     */
    protected function next()
    {
        return blank($this->links) ? null :
            tap($this->links[
                $this->pointer % count($this->links)
            ] ?? null, function () {
                $this->pointer++;
            });
    }
}