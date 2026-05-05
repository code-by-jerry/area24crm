<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\VerticalManager;
use Illuminate\View\View;

/**
 * GlobalDashboardController
 *
 * Vertical-agnostic. Shows a summary across ALL configured verticals.
 * No active vertical required in session.
 */
class GlobalDashboardController extends Controller
{
    public function __construct(
        private readonly VerticalManager $verticals,
    ) {}

    public function __invoke(): View
    {
        // Load all vertical configs — we'll show a card per vertical
        $allVerticals = $this->verticals->all();

        // For each vertical, attempt to fetch a quick lead count.
        // If the API is unreachable we degrade gracefully (null stats).
        $verticalStats = [];

        foreach ($allVerticals as $slug => $config) {
            $stats = ['leads_total' => null, 'leads_today' => null];

            try {
                $client   = $this->verticals->apiClient($slug);
                $response = $client->get('/leads', ['limit' => 1]);

                if ($response['ok'] && ! empty($response['meta'])) {
                    $stats['leads_total'] = $response['meta']['total'] ?? null;
                }
            } catch (\Throwable) {
                // API unreachable — show placeholder
            }

            $verticalStats[$slug] = array_merge($config, ['stats' => $stats]);
        }

        return view('pages.dashboard.global', [
            'title'         => 'Global Dashboard',
            'verticalStats' => $verticalStats,
        ]);
    }
}
