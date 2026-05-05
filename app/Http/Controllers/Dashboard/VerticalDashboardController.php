<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\VerticalManager;
use Illuminate\View\View;

/**
 * VerticalDashboardController
 *
 * Shows the dashboard for the currently active vertical (from session).
 * Each vertical will eventually have its own stats/KPIs here.
 */
class VerticalDashboardController extends Controller
{
    public function __construct(
        private readonly VerticalManager $verticals,
    ) {}

    public function __invoke(): View
    {
        $slug = session('active_vertical');

        if (! $slug) {
            // No vertical selected — redirect to global dashboard
            return redirect()->route('dashboard.global');
        }

        $config = $this->verticals->get($slug);
        $client = $this->verticals->apiClient($slug);

        // Fetch recent leads for the dashboard summary
        $recentLeads = [];
        $leadStats   = ['total' => null, 'today' => null];

        try {
            $response = $client->get('/leads', ['limit' => 5]);

            if ($response['ok']) {
                $recentLeads           = $response['data'] ?? [];
                $leadStats['total']    = $response['meta']['total'] ?? null;
            }
        } catch (\Throwable) {
            // Degrade gracefully
        }

        return view('pages.dashboard.vertical', [
            'title'       => $config['name'] . ' — Dashboard',
            'vertical'    => $config,
            'recentLeads' => $recentLeads,
            'leadStats'   => $leadStats,
        ]);
    }
}
