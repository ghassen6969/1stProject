<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @return Author[] Returns an array of Author objects
     */
   public function myFindAll($value): array
   {
      $query=$this->createQueryBuilder('a');
          if(isset($value)){
              $query->andWhere('a.nbrBooks = :val')
              ->setParameter('val', $value);
          }
          $query->orderBy('a.id', 'ASC')
                ->setMaxResults(10);
          return $query->getQuery()->getResult()
        ;
    }
    public function findAuthorsByName($value): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.username = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAuthorsByEmail($value):array {
        $em=$this->getEntityManager();
        $query=$em->createQuery('SELECT a FROM App\Entity\Author a WHERE a.email LIKE :email')
            ->setParameter('email', '%'.$value.'%');
        return $query->getResult();
    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}