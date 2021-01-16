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

    public function findApiId ($value): ?Profondeur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
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








