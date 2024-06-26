<?php

namespace App\Repository;

use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rapport>
 *
 * @method Rapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rapport[]    findAll()
 * @method Rapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rapport::class);
    }

    //    /**
    //     * @return Rapport[] Returns an array of Rapport objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Rapport
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findRapportByUser($user): array
    { // selection tous les rapports d'un utilisateur donné via les projets et les taches associés
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            JOIN r.tache t
            JOIN t.consultants c
            JOIN c.user u
            WHERE u.id = :user'
        )->setParameter('user', $user);
        return $query->getResult();
    }

    //find user Rapport
    public function findUserRapport($user): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            JOIN r.user u
            WHERE u.id = :user'
        )->setParameter('user', $user);
        return $query->getResult();
    }
}