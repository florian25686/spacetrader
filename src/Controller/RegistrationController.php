<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\AgentRegistrationType;
use App\Service\ApiRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        public ApiRequestService $apiRequestService
    )
    {

    }

    #[Route('/', name: 'registerNewAgentPage', methods: ['GET', 'POST'])]
    public function newAgentRegistrationPage(Request $request): Response
    {
        $agentRegistrationType = new AgentRegistrationType();

        $form = $this->createForm(AgentRegistrationType::class, $agentRegistrationType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registrationData = $request->request->all('agent_registration');

            $username = $registrationData['agentName'];
            $faction = $registrationData['faction'];

            if (null !== $username && null !== $faction) {
                return $this->redirectToRoute('registerUser', [
                    'username' => $username,
                    'faction' => $faction,
                ]);
            }
        }

        return $this->render(
            'registration/newAgentRegistrationPage.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route('register/{username}/{faction}', name: 'registerUser', methods: ['GET'])]
    public function registerAgent(Request $request, string $username, string $faction = 'COSMIC'): Response
    {
        if (strlen($username) >= 14) {
            return new Response(
                'Username to long, must be below 14 characters.',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $registerAgentRequest = $this->apiRequestService->getGuzzleClient()->request('POST', 'register',
        [
            'json' => [
                'symbol' => $username,
                'faction' => $faction,
            ]
        ]);

        if ($registerAgentRequest->getStatusCode() !== Response::HTTP_CREATED) {
            return new Response(
                json_decode($registerAgentRequest->getBody()->getContents()),
            Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new Response(
            json_decode($registerAgentRequest->getBody()->getContents(), true)['data']['token'],
            Response::HTTP_OK
        );
    }
}
