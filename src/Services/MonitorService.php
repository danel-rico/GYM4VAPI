<?php

namespace App\Services;

use App\Entity\Monitor;
use App\Repository\MonitorRepository;
use Doctrine\ORM\EntityManagerInterface;

class MonitorService
{
    private MonitorRepository $monitorRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MonitorRepository $monitorRepository, EntityManagerInterface $entityManager)
    {
        $this->monitorRepository = $monitorRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->monitorRepository->findAll();
    }

    public function addMonitor(array $data): Monitor
    {
        $monitor = new Monitor();
        $monitor->setName($data['name']);
        $monitor->setEmail($data['email']);
        
        $this->entityManager->persist($monitor);
        $this->entityManager->flush();
        
        return $monitor;
    }

    public function updateMonitor(int $id, array $data): ?Monitor
    {
        $monitor = $this->monitorRepository->find($id);
        if (!$monitor) {
            return null;
        }
        
        $monitor->setName($data['name'] ?? $monitor->getName());
        $monitor->setEmail($data['email'] ?? $monitor->getEmail());
        
        $this->entityManager->flush();
        
        return $monitor;
    }

    public function deleteMonitor(int $id): bool
    {
        $monitor = $this->monitorRepository->find($id);
        if (!$monitor) {
            return false;
        }
        
        $this->entityManager->remove($monitor);
        $this->entityManager->flush();
        
        return true;
    }
}