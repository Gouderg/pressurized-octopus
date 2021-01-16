<?php

namespace App\Repository;

use App\Entity\Tableplongee;
use App\Entity\Temps;
use App\Entity\Profondeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
// use Doctrine\ORM\QueryBuilder;

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

    public function findTables($id)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('p.profondeur, t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Profondeur', 'p')
        ->join('App\Entity\Temps', 't','WITH','t.est_a = p.id')
        ->where('p.correspond = :id')
        ->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

    }

    public function findTime($duree_pg,$profondeur, $tables)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.est_a = p.id')
        ->where('t.temps >= :temps AND p.profondeur = :prof AND p.correspond = :id')
        ->setMaxResults(1)
        ->setParameter('temps', $duree_pg)
        ->setParameter('prof', $profondeur)
        ->setParameter('id', $tables);

        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }


    public function findTime_error($duree_pg,$profondeur, $tables)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.est_a = p.id')
        ->where('t.temps <= :temps AND p.profondeur = :prof AND p.correspond = :id')
        ->orderBy('t.temps' ,'desc')
        ->setMaxResults(1)
        ->setParameter('temps', $duree_pg)
        ->setParameter('prof', $profondeur)
        ->setParameter('id', $tables);

        // returns an array of Product objects
        return $query->getQuery()->getResult();   
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
