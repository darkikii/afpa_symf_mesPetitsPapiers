<?php

namespace App\Repository;

use App\Entity\Creation;
use App\Entity\CreationSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Creation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creation[]    findAll()
 * @method Creation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creation::class);
    }

    // /**
    //  * @return Creation[] Returns an array of Creation objects
    //  */
    
    public function findFourLast()/*cherche les 4 derniers*/
    {
        return $this->createQueryBuilder('c')
            /*->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)*/
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Query
    */
    /*public function findAllVisibleQuery(CreationSearch $search): Query
    {
        $query = $this->findAll();

        if($search->getType()){
            $query = $query
                ->andWhere('p.type = :type')
                ->setParameter('type', $search->getType());
        }

        return $query->getQuery();
    }*/

    // /**
    //  * @return Creation[] Returns an array of Creation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Creation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
