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
        $this->agentToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZGVudGlmaWVyIjoiU1VOX05VUElfMyIsInZlcnNpb24iOiJ2Mi4yLjAiLCJyZXNldF9kYXRlIjoiMjAyNC0xMC0yNyIsImlhdCI6MTczMTIxODE5Mywic3ViIjoiYWdlbnQtdG9rZW4ifQ.i74Okc8x_hMbeNJaCBG3yijgvpmIIgLn0dGwj9E7l515XklVClqxm7cB2yplM2SajU5SOTh4bzXMOpl33jYs64wi6keg_9WM9exYqYYNWoBBuqBY464CJhCUa4ZHlQLHQNi5agDX2iKlK7VuDVjRMrQisRi_UdmRzNx77P7rd5WibcAo2SoV3WZA9WQXvDTAceHIExexMGzzNGrOebvoaHgGO20nfvsCMMHT5cTaelO1G7onbgBg2UzTfzMr0KkbF-9rCeAGo3YzthIBHWelhMED4AdEax0VN7XYrf_ukLnVfVUR2YELruRT8HTfmbdtdgWts3DtRgqRwhcuPrq8sA';
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
