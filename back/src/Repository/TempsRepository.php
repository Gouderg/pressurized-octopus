<?php

namespace App\Repository;

use App\Entity\Temps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    // Récupère le temps directement supérieur
    public function dbRequestNextSupTemps($table, $profondeur, $temps)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.esta = p.id')
        ->where('p.correspond = :id AND p.profondeur = :prof AND t.temps >= :temps')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur)
        ->setParameter('temps', $temps);

        return $query->getQuery()->getResult();   
    }

    // Récupère le dernier temps de la profondeur indiquée
    public function dbRequestLastTemps($table, $profondeur)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.esta = p.id')
        ->where('p.correspond = :id AND p.profondeur = :prof')
        ->orderBy('t.temps', 'desc')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur);

        return $query->getQuery()->getResult();   
    }

    // Récupère le dernier temps directement inférieur
    public function dbRequestBeforeTemps($table, $profondeur, $temps)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Temps', 't')
        ->join('App\Entity\Profondeur', 'p','WITH','t.esta = p.id')
        ->where('p.correspond = :id AND p.profondeur = :prof AND t.temps < :temps')
        ->orderBy('t.temps', 'desc')
        ->setMaxResults(1)
        ->setParameter('id', $table)
        ->setParameter('prof', $profondeur)
        ->setParameter('temps', $temps);

        return $query->getQuery()->getResult();   
    }
}
