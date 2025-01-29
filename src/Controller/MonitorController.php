<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MonitorRepository;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/monitors')]
final class MonitorController extends AbstractController
{
    private MonitorRepository $monitorRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MonitorRepository $monitorRepository, EntityManagerInterface $entityManager)
    {
        $this->monitorRepository = $monitorRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('', methods: ['GET'])]
    public function findAll(): Response
    {
        $monitors = $this->monitorRepository->findAll();
        return $this->json($monitors);
    }

    #[Route('', methods: ['POST'])]
    public function addMonitor(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $monitor = new Monitor();
        $monitor->setName($data['name']);
        $monitor->setEmail($data['email']);
        
        $this->entityManager->persist($monitor);
        $this->entityManager->flush();
        
        return $this->json($monitor, Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function updateMonitor(Request $request, int $id): Response
    {
        $monitor = $this->monitorRepository->find($id);
        if (!$monitor) {
            return $this->json(['error' => 'Monitor not found'], Response::HTTP_NOT_FOUND);
        }
        
        $data = json_decode($request->getContent(), true);
        $monitor->setName($data['name'] ?? $monitor->getName());
        $monitor->setEmail($data['email'] ?? $monitor->getEmail());
        
        $this->entityManager->flush();
        
        return $this->json($monitor);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteMonitor(int $id): Response
    {
        $monitor = $this->monitorRepository->find($id);
        if (!$monitor) {
            return $this->json(['error' => 'Monitor not found'], Response::HTTP_NOT_FOUND);
        }
        
        $this->entityManager->remove($monitor);
        $this->entityManager->flush();
        
        return $this->json(['message' => 'Monitor deleted successfully']);
    }
}
