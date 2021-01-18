<?php

namespace App\Repository;

use App\Entity\Tableplongee;
use App\Entity\Temps;
use App\Entity\Profondeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;


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
    
    // Récupère les paliers et les profondeurs nécessaires à une table de plongée
    public function findTables($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();
        $query->select('p.profondeur, t.temps, t.palier15, t.palier12, t.palier9, t.palier6, t.palier3')
        ->from('App\Entity\Profondeur', 'p')
        ->join('App\Entity\Temps', 't','WITH','t.estA = p.id')
        ->where('p.correspond = :id')
        ->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

    }
  
    // Récupère les profondeurs correspondant à la table de plongée choisie
    public function findIdProfondeur($id) {
        $query = $this->createQueryBuilder('tp');
        $query->select('p.id')
              ->join('App\Entity\Profondeur', 'p', 'WITH', 'p.correspond = tp.id ')
              ->where('tp.id = :id')
              ->setParameter('id', $id);
        
        return $query->getQuery()->getResult();    
    }
}
