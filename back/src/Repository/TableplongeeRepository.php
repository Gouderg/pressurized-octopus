<?php

namespace App\Repository;

use App\Entity\Tableplongee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Profondeur;

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
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    // SELECT p.id FROM profondeur p JOIN tableplongee tp ON tp.id = p.correspond_id WHERE tp.id = 1;
    // SELECT p.id FROM tableplongee tp JOIN profondeur p ON p.correspond_id = tp.id WHERE tp.id = 1;
    public function findIdProfondeur($id) {
        $query = $this->createQueryBuilder('tp');
        $query->select('p.id')
              ->join('App\Entity\Profondeur', 'p', 'WITH', 'p.correspond = tp.id ')
              ->where('tp.id = :id')
              ->setParameter('id', $id);
        
        return $query->getQuery()->getResult();    
    }
}
