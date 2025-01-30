<?php
namespace App\Controller;

use App\Services\ActivityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activities')]
final class ActivityController extends AbstractController
{
    private ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    #[Route('', methods: ['GET'])]
    public function getActivities(Request $request): JsonResponse
    {
        $date = $request->query->get('date');
        return $this->json($this->activityService->findAll($date));
    }

    #[Route('', methods: ['POST'])]
    public function createActivity(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $message = $this->activityService->createActivity($data);
        return $this->json(['message' => $message], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function updateActivity(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $message = $this->activityService->updateActivity($id, $data);
        return $this->json(['message' => $message], 200);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteActivity(int $id): JsonResponse
    {
        $message = $this->activityService->deleteActivity($id);
        return $this->json(['message' => $message], 200);
    }
}
