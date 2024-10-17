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
        //$this->agentToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZGVudGlmaWVyIjoiTE9DQUxfVEVTVFVTRVIiLCJ2ZXJzaW9uIjoidjIuMi4wIiwicmVzZXRfZGF0ZSI6IjIwMjQtMDktMDEiLCJpYXQiOjE3Mjc3MjQ3MDcsInN1YiI6ImFnZW50LXRva2VuIn0.ED1sHyO7ijNDFJRAW_u_U_VyR8cy-xBJc3Pcja9x54HMpvO4doNNtWivw_Jt9etNr7XV34zawqvjKmDAWIyqREcm95LJsiLDEpKW1HY5wDI9scjzvHByKGtSls42iv00Lao09fvt3My1d511LksewLAPpYv3rPtfStco6gfm1KymRPlg1xac2VE9_es-TEDyA2outHbPsaPWfei7YhiYQYjJCw3ku2gExBi8mgNxqQoypmN31dO-fe0hGdQmFYIAYt_nTWC4izjD6OL3QtgpmWmcY4fvQsw5nzntPki_UVf2Hu2o22UwpNx6Y29ZjaFm-7kMnll-pZhZrfDzpFiONA';
        $this->agentToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZGVudGlmaWVyIjoiU1VOREFZLVRFU1QiLCJ2ZXJzaW9uIjoidjIuMi4wIiwicmVzZXRfZGF0ZSI6IjIwMjQtMTAtMDYiLCJpYXQiOjE3Mjg4NDgxMjAsInN1YiI6ImFnZW50LXRva2VuIn0.CO2erHbS_HsYPW3GEFbdunJE-YFaU_RY5LCk_MCZlKjXVErIMbabCGGz1DgGY2SNO_60-ZhHu2oEfKQIenHwon_3jLiuvY4K5abxI9YNBkvOqbVka1ZrTCf2C5A703F9rUVx_9ZCwXMiSP2XAIGR9Z3sOEe-DFQl_nazlPw3UIloLxlk51f_c5VsjwO4uqS29s7qN6KBmUyErFbImYpNYicidOOKwPxhioTg4fprJ61ZVliH03FUoZ7K-LbZ6IYKJ5HRGz5vLXZIRsOHcQQYN7vs0C-NHIWjQC9fLMMo3rXm4bKZZK7RHcXzeDfdYnoCuViAU5f1uxEse6k1aRGAkw';
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
