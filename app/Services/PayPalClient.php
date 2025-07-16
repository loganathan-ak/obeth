<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayPalClient
{
    protected $accessToken;
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function setApiCredentials(array $config)
    {
        $this->clientId = $config['client_id'];
        $this->secret = $config['secret'];
        $this->baseUrl = $config['mode'] === 'live'
            ? 'https://api.paypal.com'
            : 'https://api.sandbox.paypal.com';
    }

    public function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->secret)
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ]);

        $this->accessToken = $response->json()['access_token'] ?? null;
        return $this->accessToken;
    }

    public function createSubscription(array $data)
    {
        return Http::withToken($this->accessToken)
            ->post("{$this->baseUrl}/v1/billing/subscriptions", $data)
            ->json();
    }

    public function showSubscriptionDetails(string $subscriptionId)
    {
        return Http::withToken($this->accessToken)
            ->get("{$this->baseUrl}/v1/billing/subscriptions/{$subscriptionId}")
            ->json();
    }

    public function cancelSubscription(string $subscriptionId)
    {
        return Http::withToken($this->accessToken)
            ->post("{$this->baseUrl}/v1/billing/subscriptions/{$subscriptionId}/cancel", [
                'reason' => 'User requested cancellation',
            ])
            ->json();
    }
}
