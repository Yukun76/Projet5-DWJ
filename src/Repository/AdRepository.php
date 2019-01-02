<?php

namespace App\Repository;

use App\Entity\Ad;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


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


     /**
     * @return Booking[]
     * @return Ad[]
     */
    public function findAllAdExceptBooking(): array
    {
        $qb = $this->createQueryBuilder('id')
            ->select('id')
            ->From('App\Entity\Ad', 'a')
            ->leftJoin('App\Entity\Booking', 'b', 'WITH', 'id = b.ad')
            ->Where('b.ad IS NULL')
            ->getQuery();

        return $qb->execute();
    }


    /**
     * @param string $type
     * @param string $sexe
     * @param string $region
     * @return Ad[]
     */
    public function findAdWithSearch($type, $sexe, $region): array
    {
        $qb = $this->createQueryBuilder('animal')
            ->select('animal')
            ->from('App\Entity\Ad' , 'a')
            ->leftJoin('App\Entity\Animal', 'an', 'WITH', 'animal = an.id')
            ->where('an.type = :type')
            ->andWhere('an.sexe = :sexe')
            ->andWhere('an.region = :region')
            ->setParameter(':type' , $type)
            ->setParameter(':sexe' , $sexe)
            ->setParameter(':region' , $region)
            ->getQuery();

        return $qb->execute();
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