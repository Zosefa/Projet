<?php

namespace App\Repository;

use App\Entity\Vendeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vendeur>
 *
 * @method Vendeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vendeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vendeur[]    findAll()
 * @method Vendeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vendeur::class);
    }


    public function getByUser($user):int
    {
        return $this->createQueryBuilder('v')
                    ->select('v.id')
                    ->where('v.User = :user')
                    ->setParameter('user',$user)
                    ->getQuery()
                    ->getSingleScalarResult();
    }
//    /**
//     * @return Vendeur[] Returns an array of Vendeur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vendeur
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
