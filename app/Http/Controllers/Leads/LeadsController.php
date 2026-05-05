<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use App\Services\VerticalManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * LeadsController
 *
 * Reads the active vertical from session — no vertical slug in the URL.
 * Routes are clean: /leads, /leads/create, /leads/{id}
 */
class LeadsController extends Controller
{
    public function __construct(
        private readonly VerticalManager $verticals,
    ) {}

    // ─── Private helper ───────────────────────────────────────────────────────

    /**
     * Resolve the active vertical config from session.
     * Aborts with 404 if no vertical is selected yet.
     */
    private function activeVertical(): array
    {
        $slug = session('active_vertical');

        if (! $slug) {
            abort(404, 'No vertical selected. Please select a vertical first.');
        }

        return $this->verticals->get($slug);
    }

    // ─── Actions ──────────────────────────────────────────────────────────────

    /**
     * GET /leads
     */
    public function index(Request $request): View
    {
        $config = $this->activeVertical();
        $client = $this->verticals->apiClient($config['slug']);

        $query = array_filter([
            'limit'  => $request->input('limit', 50),
            'type'   => $request->input('type'),
            'status' => $request->input('status'),
            'source' => $request->input('source'),
        ]);

        $response = $client->get('/leads', $query);

        return view('pages.verticals.leads.index', [
            'vertical' => $config,
            'leads'    => $response['data'],
            'meta'     => $response['meta'],
            'links'    => $response['links'],
            'filters'  => $request->only(['type', 'status', 'source', 'limit']),
            'error'    => $response['ok'] ? null : $response['message'],
        ]);
    }

    /**
     * GET /leads/create
     */
    public function create(): View
    {
        $config = $this->activeVertical();

        return view('pages.verticals.leads.create', [
            'vertical' => $config,
        ]);
    }

    /**
     * POST /leads
     */
    public function store(Request $request): RedirectResponse
    {
        $config = $this->activeVertical();
        $client = $this->verticals->apiClient($config['slug']);

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
        ]);

        $payload = array_filter($request->only([
            'name', 'email', 'phone', 'type', 'plotsize', 'message', 'source', 'status',
        ]));

        $payload['source'] = $payload['source'] ?? 'crm-manual';

        $response = $client->post('/leads', $payload);

        if (! $response['ok']) {
            return back()
                ->withInput()
                ->withErrors(['api' => $response['message'] ?? 'Failed to create lead.']);
        }

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    /**
     * GET /leads/{id}
     */
    public function show(int $id): View
    {
        $config = $this->activeVertical();
        $client = $this->verticals->apiClient($config['slug']);

        $response = $client->get("/leads/{$id}");

        if (! $response['ok']) {
            abort(404, 'Lead not found.');
        }

        return view('pages.verticals.leads.show', [
            'vertical' => $config,
            'lead'     => $response['data'],
        ]);
    }

    /**
     * PUT /leads/{id}
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $config = $this->activeVertical();
        $client = $this->verticals->apiClient($config['slug']);

        $payload = array_filter($request->only([
            'name', 'email', 'phone', 'type', 'plotsize', 'message', 'source', 'status',
        ]));

        $response = $client->put("/leads/{$id}", $payload);

        if (! $response['ok']) {
            return back()
                ->withInput()
                ->withErrors(['api' => $response['message'] ?? 'Failed to update lead.']);
        }

        return redirect()
            ->route('leads.show', $id)
            ->with('success', 'Lead updated successfully.');
    }

    /**
     * DELETE /leads/{id}
     */
    public function destroy(int $id): RedirectResponse
    {
        $config = $this->activeVertical();
        $client = $this->verticals->apiClient($config['slug']);

        $client->delete("/leads/{$id}");

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead deleted.');
    }
}
