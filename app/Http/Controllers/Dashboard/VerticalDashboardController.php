<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\VerticalManager;
use Illuminate\View\View;

/**
 * VerticalDashboardController
 *
 * Shows the dashboard for the currently active vertical (from session).
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
            return redirect()->route('dashboard.global');
        }

        $config  = $this->verticals->get($slug);
        $client  = $this->verticals->apiClient($slug);
        $statuses = $config['lead_statuses'] ?? [];

        // ── Fetch recent leads (last 10) ──────────────────────────────────────
        $recentLeads = [];
        $leadStats   = [
            'total'     => null,
            'pending'   => 0,
            'contacted' => 0,
            'converted' => 0,
            'rejected'  => 0,
        ];

        // ── Fetch all leads for stats (up to 200 for counting) ────────────────
        $allLeadsResponse = [];

        try {
            // Recent leads for the table
            $recent = $client->get('/leads', ['limit' => 10]);
            if ($recent['ok']) {
                $recentLeads           = $recent['data'] ?? [];
                $leadStats['total']    = $recent['meta']['total'] ?? count($recentLeads);
            }

            // Fetch more for status breakdown (use a higher limit)
            $all = $client->get('/leads', ['limit' => 200]);
            if ($all['ok']) {
                $allLeadsResponse = $all['data'] ?? [];

                // Count by status
                foreach ($allLeadsResponse as $lead) {
                    $s = $lead['status'] ?? 'pending';
                    if (isset($leadStats[$s])) {
                        $leadStats[$s]++;
                    } else {
                        $leadStats['pending']++;
                    }
                }

                // Count by type for chart
                $typeBreakdown = [];
                foreach ($allLeadsResponse as $lead) {
                    $t = $lead['type'] ?? 'other';
                    $typeBreakdown[$t] = ($typeBreakdown[$t] ?? 0) + 1;
                }
            }
        } catch (\Throwable) {
            // Degrade gracefully
        }

        // ── Build chart data ──────────────────────────────────────────────────
        // Status donut chart data
        $statusChartData = [];
        foreach ($statuses as $key => $meta) {
            $statusChartData[] = [
                'label' => $meta['label'],
                'value' => $leadStats[$key] ?? 0,
                'color' => match($key) {
                    'pending'   => '#f59e0b',
                    'contacted' => '#3b82f6',
                    'converted' => '#10b981',
                    'rejected'  => '#ef4444',
                    default     => '#94a3b8',
                },
            ];
        }

        // Type bar chart data
        $typeLabels = array_keys($typeBreakdown ?? []);
        $typeValues = array_values($typeBreakdown ?? []);

        return view('pages.dashboard.vertical', [
            'title'           => $config['name'] . ' — Dashboard',
            'vertical'        => $config,
            'recentLeads'     => $recentLeads,
            'leadStats'       => $leadStats,
            'statusChartData' => $statusChartData,
            'typeLabels'      => $typeLabels,
            'typeValues'      => $typeValues,
        ]);
    }
}

