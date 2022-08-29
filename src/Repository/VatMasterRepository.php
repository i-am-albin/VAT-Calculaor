<?php

namespace App\Repository;

use App\Entity\VatMaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VatMaster>
 *
 * @method VatMaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method VatMaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method VatMaster[]    findAll()
 * @method VatMaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VatMasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VatMaster::class);
    }

    public function add(VatMaster $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VatMaster $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllTableData()
    {
        return $this->createQueryBuilder('e')            
            ->getQuery()
            ->execute()
        ;
    }    

//    /**
//     * @return VatMaster[] Returns an array of VatMaster objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VatMaster
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
