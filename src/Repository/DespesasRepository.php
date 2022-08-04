<?php

namespace App\Repository;

use App\Entity\Despesas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Despesas>
 *
 * @method Despesas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Despesas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Despesas[]    findAll()
 * @method Despesas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DespesasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Despesas::class);
    }

    public function add(Despesas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Despesas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function VerificaSeJaExisteDespesaComOutroID($id, $descricao, $data)
    {
       return $this->createQueryBuilder('d')
                    ->select('count(d.id) as count')
                    ->Where('d.descricao = :descricao')
                    ->andWhere('d.data = :data')
                    ->andWhere('d.id != :id')
                    ->setParameter('descricao', $descricao)
                    ->setParameter('data', $data)
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getSingleScalarResult();
    }

//    /**
//     * @return Despesas[] Returns an array of Despesas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Despesas
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}