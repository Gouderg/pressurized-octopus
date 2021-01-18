<?php

namespace App\Repository;

use App\Entity\Temps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Temps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temps[]    findAll()
 * @method Temps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temps::class);
    }

    public function dbRequestNextSupTemps($table, $profondeur, $temps)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.estA = p.id')
        ->where('p.correspond = :id AND p.profondeur = :prof AND t.temps >= :temps')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur)
        ->setParameter('temps', $temps);


        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }

    public function dbRequestLastTemps($table, $profondeur)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.estA = p.id')
        ->where('p.correspond = :id AND p.profondeur = :prof')
        ->orderBy('t.temps', 'desc')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur);


        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }

    public function dbRequestBeforeTemps($table, $profondeur, $temps)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.estA = p.id')
        ->where('p.correspond = :id AND p.profondeur = :prof AND t.temps < :temps')
        ->orderBy('t.temps', 'desc')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur)
        ->setParameter('temps', $temps);

        // returns an array of Product objects
        return $query->getQuery()->getResult();   
    }
}
