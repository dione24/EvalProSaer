<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Taches;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Taches>
 *
 * @method Taches|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taches|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taches[]    findAll()
 * @method Taches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TachesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taches::class);
    }

    //    /**
    //     * @return Taches[] Returns an array of Taches objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Taches
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findTachesByUser($user): array
    {
        $qb = $this->createQueryBuilder('t')
            ->innerJoin('t.consultants', 'c') // Joindre les consultants de la tâche
            ->where('c.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery();
        return $qb->getResult();
    }


    //get all projet for user
    public function findUserProject(User $user): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.user = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery();
        return $qb->getResult();
    }

    // get all taches for user
    // get all taches for user
    public function findUserTaches(User $user): array
    {
        $qb = $this->createQueryBuilder('t')
            ->innerJoin('t.projet', 'p')
            ->where('p.user = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery();
        return $qb->getResult();
    }
}
