<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{
    public function __construct(
        public readonly ApiRequestService $apiRequestService,
    )
    {
    }

    #[Route('/contracts', name: 'contract.list', methods: ['GET'])]
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
            'contracts' => $missionsList,
        ]);
    }

    #[Route('/contracts/{contractId}', name: 'contract.accept', methods: ['GET'])]
    public function acceptContract(string $contractId): Response
    {
        $acceptContractResponse = $this->apiRequestService->getGuzzleClient()->request(
            'POST',
            'my/contracts/' . $contractId . '/accept',
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );

        return new Response(
            $acceptContractResponse->getBody()->getContents(),
            Response::HTTP_OK,
        );

        /**
         * {"data":{"contract":{"id":"cm3b6m2wvgs9hs60cxtwgyy6f","factionSymbol":"COSMIC","type":"PROCUREMENT","terms":{"deadline":"2024-11-17T05:56:32.940Z","payment":{"onAccepted":1510,"onFulfilled":11364},"deliver":[{"tradeSymbol":"COPPER_ORE","destinationSymbol":"X1-VG16-H56","unitsRequired":58,"unitsFulfilled":0}]},"accepted":true,"fulfilled":false,"expiration":"2024-11-11T05:56:32.940Z","deadlineToAccept":"2024-11-11T05:56:32.940Z"},"agent":{"accountId":"cm3b6m2vjgs9fs60colzbsho3","symbol":"SUN_NUPI_3","headquarters":"X1-VG16-A1","credits":176510,"startingFaction":"COSMIC","shipCount":2}}}
         */
    }
}
