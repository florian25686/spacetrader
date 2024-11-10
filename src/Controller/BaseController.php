<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    public function __construct(
        public readonly ApiRequestService $apiRequestService,
    )
    {
    }
}
