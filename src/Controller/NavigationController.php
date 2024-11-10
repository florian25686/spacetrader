<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NavigationController extends BaseController
{
    #[Route('/listWaypoints/{coordinate}', name: 'navigation.listWaypoints')]
    public function listWaypoints(string $coordinate = 'X1-VG16-A1'): Response
    {
        // sector, system, location
        $separatedCoordinates = explode('-', $coordinate);
        $sector = $separatedCoordinates[0];
        $system = $separatedCoordinates[1];
        $location = $separatedCoordinates[2];
        // 'systems/X1-VG16/waypoints/X1-VG16-A1'
        $uri = sprintf('systems/%s-%s/waypoints/%s', $sector, $system, $coordinate);

       $waypointList = $this->apiRequestService->getGuzzleClient()->request(
           'GET',
           $uri
       );
       $waypointListResponse = json_decode($waypointList->getBody()->getContents(), true);
       return $this->render('navigation/overview.html.twig', [
           'waypoints' => $waypointListResponse,
       ]);
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
