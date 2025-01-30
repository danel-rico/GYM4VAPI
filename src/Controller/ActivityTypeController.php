<?php
namespace App\Controller;

use App\Services\ActivityTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activity-types')]
final class ActivityTypeController extends AbstractController
{
    private ActivityTypeService $activityTypeService;

    public function __construct(ActivityTypeService $activityTypeService)
    {
        $this->activityTypeService = $activityTypeService;
    }

    #[Route('', methods: ['GET'])]
    public function getActivityTypes(): JsonResponse
    {
        $activityTypes = $this->activityTypeService->findAll();
        return $this->json($activityTypes);
    }
}
