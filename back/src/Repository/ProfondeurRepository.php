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

    // Récupère l'id d'un temps en fonction de la profondeur
    public function findIdTemps($id)
    {
        $query = $this->createQueryBuilder('p');
        $query->select('t.id')
              ->join('App\Entity\Temps', 't', 'WITH', 't.estA = p.id ')
              ->where('p.id = :id')
              ->setParameter('id', $id);
        
        return $query->getQuery()->getResult();    

    }

    // Récupère la profondeur directement supérieur à celle choisie
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

        return $query->getQuery()->getResult();   
    }

    // Récupère la dernière profondeur de la table
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

        return $query->getQuery()->getResult();   
    }

    // Récupère la profondeur directement inférieure
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

        return $query->getQuery()->getResult();   
    }
}








