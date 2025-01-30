<?php
namespace App\Services;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Monitor;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;

class ActivityService
{
    private ActivityRepository $activityRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ActivityRepository $activityRepository, EntityManagerInterface $entityManager)
    {
        $this->activityRepository = $activityRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll($date = null)
    {
        $query = $this->activityRepository->createQueryBuilder('a');

        if ($date) {
            $query->where("DATE_FORMAT(a.dateStart, '%d-%m-%Y') = :date")
                  ->setParameter('date', $date);
        }

        return $query->getQuery()->getResult();
    }

    public function createActivity(array $data): string
    {
        $activityType = $this->entityManager->getRepository(ActivityType::class)->find($data['activity_type_id']);
        if (!$activityType) {
            return 'Invalid activity type';
        }

        $monitors = $this->entityManager->getRepository(Monitor::class)->findBy(['id' => $data['monitors_id']]);
        if (count($monitors) < $activityType->getNumberMonitors()) {
            return 'Not enough monitors';
        }

        $allowedTimes = ['09:00', '13:30', '17:30'];
        $startTime = (new \DateTime($data['date_start']))->format('H:i');

        if (!in_array($startTime, $allowedTimes)) {
            return 'Invalid time. Must be 09:00, 13:30, or 17:30';
        }

        $activity = new Activity();
        $activity->setActivityType($activityType);
        $activity->setDateStart(new \DateTime($data['date_start']));
        $activity->setDateEnd((new \DateTime($data['date_start']))->modify('+90 minutes'));

        foreach ($monitors as $monitor) {
            $activity->getMonitors()->add($monitor);
        }

        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        return 'Activity created successfully';
    }

    public function updateActivity(int $id, array $data): string
    {
        $activity = $this->activityRepository->find($id);
        if (!$activity) {
            return 'Activity not found';
        }

        if (isset($data['date_start'])) {
            $activity->setDateStart(new \DateTime($data['date_start']));
            $activity->setDateEnd((new \DateTime($data['date_start']))->modify('+90 minutes'));
        }

        if (isset($data['activity_type_id'])) {
            $activityType = $this->entityManager->getRepository(ActivityType::class)->find($data['activity_type_id']);
            if ($activityType) {
                $activity->setActivityType($activityType);
            }
        }

        if (isset($data['monitors_id'])) {
            $monitors = $this->entityManager->getRepository(Monitor::class)->findBy(['id' => $data['monitors_id']]);
            $activity->getMonitors()->clear();
            foreach ($monitors as $monitor) {
                $activity->getMonitors()->add($monitor);
            }
        }

        $this->entityManager->flush();
        return 'Activity updated successfully';
    }

    public function deleteActivity(int $id): string
    {
        $activity = $this->activityRepository->find($id);
        if (!$activity) {
            return 'Activity not found';
        }

        $this->entityManager->remove($activity);
        $this->entityManager->flush();

        return 'Activity deleted successfully';
    }
}
