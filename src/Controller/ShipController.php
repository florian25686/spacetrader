<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShipController extends BaseController
{
    #[Route('/ship/findShipyard/{coordinate}', name: 'ship.findShipyard')]
    public function locateShipyard(string $coordinate = 'X1-VG16'): Response
    {
        $findShipYardResponse = $this->apiRequestService->getGuzzleClient()->request(
            'GET',
            sprintf('systems/%s/waypoints?traits=SHIPYARD', $coordinate),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return $this->render(
            'ship/shipyardOverview.html.twig',
            [
                'shipyardList' => json_decode($findShipYardResponse->getBody()->getContents(), true)['data']
            ]
        );
    }

    #[Route('/ship/viewAvailableShips/{coordinate}/{shipyardCoordinate}', name: 'ship.viewAvailableShips')]
    public function viewAvailableShips(string $coordinate = 'X1-VG16-A1', string $shipyardCoordinate = 'X1-VG16-A1'): Response
    {
        $availableShipsResponse = $this->apiRequestService->getGuzzleClient()->request(
            'GET',
            sprintf('systems/%s/waypoints/%s/shipyard', $coordinate, $shipyardCoordinate),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return $this->render(
            'ship/shipsOverview.html.twig',
            [
                'shipsList' => json_decode($availableShipsResponse->getBody()->getContents(), true),
                'shipyardCoordinate' => $shipyardCoordinate,
            ]
        );
    }

    #[Route('/ship/purchase/{shipType}/{shipyardCoordinate}', name: 'ship.purchase')]
    public function purchaseShip(string $shipType, string $shipyardCoordinate = 'X1-VG16-A1')
    {
        $purchaseData = [
            'shipType' => $shipType,
            'waypointSymbol' => $shipyardCoordinate,
        ];

        $shipPurchaseResponse = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships'),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
                'json' => $purchaseData,
            ]
        );

        return new Response(
            $shipPurchaseResponse->getBody()->getContents(),
            Response::HTTP_OK,
        );
    }
}
