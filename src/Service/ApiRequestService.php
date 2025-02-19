<?php
declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;

class ApiRequestService
{
    private string $agentToken;

    private Client $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client(
            [
                'base_uri' => 'https://api.spacetraders.io/v2/',
            ]
        );

        // Needs storage solution (e.g. Database) built in later
        $this->setAgentToken('');
    }

    public function setAgentToken(string $agentToken): void
    {
        $this->agentToken = $_ENV['AGENT_TOKEN'] ?? '';
    }

    public function getAgentToken(): string
    {
        return $this->agentToken;
    }

    public function getGuzzleClient(): Client
    {
        return $this->guzzleClient;
    }
}
