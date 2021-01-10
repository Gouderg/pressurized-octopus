<?php

namespace App\Repository;

use App\Entity\Profondeur;
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
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }


    // /**
    //  * @return Profondeur[] Returns an array of Profondeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findApiId ($value): ?Profondeur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findTables($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT profondeur.profondeur, temps.temps, temps.palier15, temps.palier9, temps.palier12, temps.palier6, temps.palier,
            FROM profondeur,temps
            WHERE correspond_id = :id'
        )->setParameter('id', $value);

        return $query->getResult(Query::HYDRATE_ARRAY);

    }

    
}


    
/**
requetes sql pour recuperer temps, profondeur et palier pour 


select profondeur.profondeur, temps.temps, temps.palier15, temps.palier9, temps.palier12, temps.palier6, temps.palier3 
from profondeur, temps 
where profondeur.correspond_id=1;

*/








