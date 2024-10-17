<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiRequestService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NavigationController
{
    public function __construct(
        public readonly ApiRequestService $apiRequestService,
    )
    {
    }

    #[Route('/listWaypoints')]
    public function listWaypoints(): Response
    {
       $waypointList = $this->apiRequestService->getGuzzleClient()->request(
           'GET',
           'systems/X1-RD20/waypoints/X1-RD20-A1'
       );

       new Response(
           print_r(json_decode($waypointList->getBody()->getContents(), true)),
           Response::HTTP_OK,
       );
    }

    #[Route('/systems')]
    public function getSystems(): Response
    {
       $systemsList = $this->apiRequestService->getGuzzleClient()->request(
           'GET',
           'systems'
       );

       return new Response(
           json_decode($systemsList->getBody()->getContents(), true),
           Response::HTTP_OK,
       );
    }
}
