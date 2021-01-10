<?php

namespace App\Repository;

use App\Entity\Tableplongee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Tableplongee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tableplongee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tableplongee[]    findAll()
 * @method Tableplongee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableplongeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tableplongee::class);
    }
    public function findApiAll()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    public function findTables($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT profondeur.profondeur, temps.temps, temps.palier15, temps.palier9, temps.palier12, temps.palier6, temps.palier3 
            FROM App\Entity\Temps temps 
            JOIN App\Entity\Profondeur profondeur  
            ON temps.est_a = profondeur.id 
            WHERE profondeur.correspond_id=:id;'
        )->setParameter('id', $value);

        return $query->getResult(Query::HYDRATE_ARRAY);

    }





    // /**
    //  * @return Tableplongee[] Returns an array of Tableplongee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tableplongee
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')temps.palier15, temps.palier9, t
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
