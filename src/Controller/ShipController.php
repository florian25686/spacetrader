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
    public function purchaseShip(string $shipType, string $shipyardCoordinate = 'X1-VG16-A1'): Response
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

    #[Route('/ship/{ship}/flyToMiningLocation/{miningLocationCoordinate}', name: 'ship.flyToMiningLocation')]
    public function flyShipToMiningLocation(string $ship, string $miningLocationCoordinate): Response
    {
        // Make sure the ship is in orbit before starting to navigate
        $orbitShip = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships/%s/orbit', $ship),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        if ($orbitShip->getStatusCode() !== Response::HTTP_OK) {
            return new Response(
                $orbitShip->getBody()->getContents(),
                $orbitShip->getStatusCode(),
                [
                    'Content-Type' => 'application/json',
                ]
            );
        }

        $sendShipToMiningLocation = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships/%s/navigate', $ship),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
                'json' => [
                    'waypointSymbol' => $miningLocationCoordinate,
                ]
            ]
        );

        return new Response(
            $sendShipToMiningLocation->getBody()->getContents(),
            $sendShipToMiningLocation->getStatusCode(),
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    #[Route('/ship/{ship}/dock', name: 'ship.dock', methods: ['GET'])]
    public function dockShip(string $ship): Response
    {
        $dockShip = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships/%s/dock', $ship),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return new Response(
            $dockShip->getBody()->getContents(),
            $dockShip->getStatusCode(),
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    #[Route('/ship/{ship}/refuel', name: 'ship.refuel', methods: ['GET'])]
    public function refuelShip(string $ship): Response
    {
        $refuelShip = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships/%s/refuel', $ship),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return new Response(
            $refuelShip->getBody()->getContents(),
            $refuelShip->getStatusCode(),
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    #[Route('/ship/{ship}/orbit', name: 'ship.orbit', methods: ['GET'])]
    public function orbitShip(string $ship): Response
    {
        $orbitShip = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships/%s/orbit', $ship),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return new Response(
            $orbitShip->getBody()->getContents(),
            $orbitShip->getStatusCode(),
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    #[Route('/ship/{ship}/startMining', name: 'ship.startMining', methods: ['GET'])]
    public function startMining(string $ship): Response
    {
        $mining = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            sprintf('my/ships/%s/extract', $ship),
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return new Response(
            $mining->getBody()->getContents(),
            $mining->getStatusCode(),
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
