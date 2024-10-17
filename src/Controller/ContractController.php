<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{
    #[Route('/contracts', name: 'missions_get', methods: ['GET'])]
    public function listAllContracts(ApiRequestService $apiRequestService): Response
    {
        $guzzleClient = $apiRequestService->getGuzzleClient();

        $missionsListResponse = $guzzleClient->request(
            'GET',
            'my/contracts',
            [
                'headers' => ['Authorization' => 'Bearer ' . $apiRequestService->getAgentToken() ],
            ]
        );

        $contractsList = json_decode($missionsListResponse->getBody()->getContents(), true) ?? [];

        $missionsList = [];
        foreach($contractsList as $contract) {
            $missionsList[] = $contract;
        }

        return $this->render('mission/list_all_contracts.html.twig', [
            'missionsList' => $missionsList,
        ]);
    }
}
