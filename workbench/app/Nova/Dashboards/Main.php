<?php

namespace Workbench\App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use Workbench\App\Nova\Metrics\NewUsers;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            (new NewUsers)->width('1/3')->route('nova.pages.index', ['resource' => 'users']),
        ];
    }
}
