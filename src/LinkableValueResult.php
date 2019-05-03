<?php

namespace SaintSystems\Nova\LinkableMetrics;

use Laravel\Nova\Metrics\ValueResult;

class LinkableValueResult extends ValueResult
{
    use LinkableResult;
}
