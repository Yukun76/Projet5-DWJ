<?php

namespace App\Repository;

use App\Entity\Ad;
use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function getQueryExceptBooking(): QueryBuilder {
        return $this->createQueryBuilder('ad')
            ->leftJoin('ad.bookings', 'booking')
            ->where('booking.id IS NULL');
    }

     /**
     * @return Ad[]
     */
    public function findAllAdExceptBooking(): array
    {
        return $this->getQueryExceptBooking()
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Ad[]
     */
    public function findAdWithSearch($type, $sexe, $region): array
    {
        $query = $this->getQueryExceptBooking()
            ->innerJoin('ad.animal' , 'animal');
            
        if ($type) {
            $query
               ->andWhere('animal.type = :type')
               ->setParameter('type' , $type);
        }

       if ($sexe) {
            $query
               ->andWhere('animal.sexe = :sexe')
               ->setParameter('sexe' , $sexe);
        }

        if ($region) {
            $query
               ->andWhere('animal.region = :region')
               ->setParameter('region' , $region);
        }

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Ad[] Returns an array of Ad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')&²
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}