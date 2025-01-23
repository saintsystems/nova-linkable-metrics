<?php

namespace Workbench\App\Nova\Metrics;

use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;
use SaintSystems\Nova\LinkableMetrics\LinkablePartition;
use Workbench\App\Models\User;

class VerifiedUsers extends Partition
{
    use LinkablePartition;

    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count(
            $request, User::class, groupBy: 'email_verified_at',
        )->label(fn ($value) => match ($value) {
            null => 'Unverified',
            default => 'Verified',
        });
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): DateTimeInterface|null
    {
        // return now()->addMinutes(5);

        return null;
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'verified-users';
    }
}
