<?php

namespace App\Controller;

use App\Entity\Receitas;
use App\Factory\ReceitasFactory;
use App\Controller\BaseController;
use App\Repository\ReceitasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReceitasController extends BaseController
{
    /**
     * @var ReceitasFactory
     */
    private $receitasFactory;

    public function __construct(
        ReceitasRepository $receitasRepository,
        EntityManagerInterface $entityManager,
        ReceitasFactory $receitasFactory
    ) {
        parent::__construct
        (
            $receitasRepository, 
            $entityManager, 
            $receitasFactory
        );
    }

    /**
     * @Route("/receitas/{ano}/{mes}", methods={"GET"})
     */
    public function buscarReceitasDoMes(int $ano, int $mes) : Response
    {
        $receitasList  = $this->receitasRepository
            ->findByMonthYear($ano, $mes);
        return new JsonResponse($receitasList);
    }

    /**
     * @param Receitas $entityExistente
     * @param Receitas $entityEnviado
     */
    public function atualizarEntidadeExistente($entityExistente, $entityEnviado)
    {
        $entityExistente->setDescricao($entityEnviado->getDescricao()); 
    }
}
