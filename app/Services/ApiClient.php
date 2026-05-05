<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * ApiClient
 *
 * Generic HTTP client wrapper used by all verticals.
 * Handles base URL, auth token, error normalisation.
 * Controllers never call Http:: directly — always go through this.
 */
class ApiClient
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $token = '',
    ) {}

    // ─── Public Methods ───────────────────────────────────────────────────────

    public function get(string $endpoint, array $query = []): array
    {
        $response = $this->request()->get($this->url($endpoint), $query);
        return $this->handle($response);
    }

    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->request()->post($this->url($endpoint), $data);
        return $this->handle($response);
    }

    public function put(string $endpoint, array $data = []): array
    {
        $response = $this->request()->put($this->url($endpoint), $data);
        return $this->handle($response);
    }

    public function patch(string $endpoint, array $data = []): array
    {
        $response = $this->request()->patch($this->url($endpoint), $data);
        return $this->handle($response);
    }

    public function delete(string $endpoint): array
    {
        $response = $this->request()->delete($this->url($endpoint));
        return $this->handle($response);
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    private function request()
    {
        $pending = Http::acceptJson()
            ->timeout(15);

        if (! empty($this->token)) {
            $pending = $pending->withToken($this->token);
        }

        return $pending;
    }

    private function url(string $endpoint): string
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    /**
     * Normalise the response into a consistent array shape:
     * ['ok' => bool, 'status' => int, 'data' => array, 'errors' => array, 'message' => string]
     */
    private function handle(Response $response): array
    {
        $body = $response->json() ?? [];

        return [
            'ok'      => $response->successful(),
            'status'  => $response->status(),
            'data'    => $body['data']    ?? $body,
            'meta'    => $body['meta']    ?? [],
            'links'   => $body['links']   ?? [],
            'errors'  => $body['errors']  ?? [],
            'message' => $body['message'] ?? $response->reason(),
        ];
    }
}
