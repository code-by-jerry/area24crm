<?php

namespace App\Http\Controllers;

use App\Services\VerticalManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Handles switching the active vertical via session.
 * POST /switch-vertical  { vertical: 'atha-construction' }
 */
class VerticalSwitcherController extends Controller
{
    public function __construct(
        private readonly VerticalManager $verticals,
    ) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $slug = $request->input('vertical');

        // Validate the slug exists as a configured vertical
        $this->verticals->get($slug); // throws RuntimeException if not found

        session(['active_vertical' => $slug]);

        // Redirect to the vertical dashboard after switching
        return redirect()->route('dashboard.vertical');
    }
}
