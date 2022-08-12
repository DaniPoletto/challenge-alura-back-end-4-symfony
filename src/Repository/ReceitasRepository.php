<?php

namespace App\Repository;

use App\Entity\Receitas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Receitas>
 *
 * @method Receitas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Receitas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Receitas[]    findAll()
 * @method Receitas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceitasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Receitas::class);
    }

    public function add(Receitas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Receitas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function VerificaSeJaExisteDespesaComOutroID($id, $descricao, $data)
    {
       return $this->createQueryBuilder('r')
                    ->select('count(r.id) as count')
                    ->Where('r.descricao = :descricao')
                    ->andWhere('r.data = :data')
                    ->andWhere('r.id != :id')
                    ->setParameter('descricao', $descricao)
                    ->setParameter('data', $data)
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getSingleScalarResult();
    }

   /**
    * @return Receitas[] Returns an array of Receitas objects
    */
   public function findByDescricao($value): array
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.descricao LIKE :val')
           ->setParameter('val', '%'.$value."%")
           ->orderBy('r.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return Receitas[] Returns an array of Receitas objects
    */
    public function findByMonthYear($year, $month)
    {
        $fromTime = new \DateTime($year . '-' . $month . '-01');
        $toTime = new \DateTime($fromTime->format('Y-m-d') . ' first day of next month');

        return $this->createQueryBuilder('r')
            ->where('r.data >= :fromTime')
            ->andWhere('r.data < :toTime')
            ->setParameter('fromTime', $fromTime)
            ->setParameter('toTime', $toTime)
            ->getQuery()
            ->getResult();
    }

    public function SumAmountByMonthYear($year, $month)
    {
        $fromTime = new \DateTime($year . '-' . $month . '-01');
        $toTime = new \DateTime($fromTime->format('Y-m-d') . ' first day of next month');

        return $this->createQueryBuilder('r')
            ->select('sum(r.valor) as valor')
            ->where('r.data >= :fromTime')
            ->andWhere('r.data < :toTime')
            ->setParameter('fromTime', $fromTime)
            ->setParameter('toTime', $toTime)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    public function findOneBySomeField($value): ?Receitas
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
