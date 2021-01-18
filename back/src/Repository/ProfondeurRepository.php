<?php

namespace App\Repository;

use App\Entity\Profondeur;
use App\Entity\Temps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Profondeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profondeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profondeur[]    findAll()
 * @method Profondeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfondeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profondeur::class);
    }
    public function findApiAll()
    {
         $entityManager = $this->getEntityManager();


        $query = $entityManager->createQueryBuilder();

        $query->select('p.correspond, p.profondeur, t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Profondeur', 'p')
        ->join('App\Entity\Temps', 't','WITH','t.estA = p.id');

         return $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    // select p.correspond_id, p.profondeur, t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3
    // from profondeur p
    // join temps t 
    // on p.id = t.est_a_id;

    public function findApiId ($value): ?Profondeur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // SELECT t.id FROM temps t JOIN profondeur p ON p.id = t.est_a_id WHERE t.id = 1;
    public function findIdTemps($id)
    {
        $query = $this->createQueryBuilder('p');
        $query->select('t.id')
              ->join('App\Entity\Temps', 't', 'WITH', 't.estA = p.id ')
              ->where('p.id = :id')
              ->setParameter('id', $id);
        
        return $query->getQuery()->getResult();    

    }

    public function dbRequestNextSupProf($table, $profondeur)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('p.profondeur')
        ->from('App\Entity\Profondeur', 'p')
        ->where('p.profondeur >= :prof AND p.correspond = :id')
        ->setMaxResults(1)
        ->setParameter('prof', $profondeur)
        ->setParameter('id', $table);

        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }

    public function dbRequestLastProf($table)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('p.profondeur')
        ->from('App\Entity\Profondeur', 'p')
        ->where('p.correspond = :id')
        ->orderBy('p.profondeur' ,'desc')
        ->setMaxResults(1)
        ->setParameter('id', $table);

        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }

    public function dbRequestBeforeProf($table, $profondeur)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('p.profondeur')
        ->from('App\Entity\Profondeur', 'p')
        ->where('p.correspond = :id AND p.profondeur < :prof')
        ->orderBy('p.profondeur' ,'desc')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur);

        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }
}








