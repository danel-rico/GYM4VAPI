<?php
namespace App\Services;

use App\Entity\ActivityType;
use App\Repository\ActivityTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class ActivityTypeService
{
    private ActivityTypeRepository $activityTypeRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ActivityTypeRepository $activityTypeRepository, EntityManagerInterface $entityManager)
    {
        $this->activityTypeRepository = $activityTypeRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->activityTypeRepository->findAll();
    }
}
