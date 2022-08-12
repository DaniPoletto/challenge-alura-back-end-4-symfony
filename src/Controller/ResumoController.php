<?php

namespace App\Controller;

use App\Repository\DespesasRepository;
use App\Repository\ReceitasRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResumoController extends AbstractController
{
    /**
     * @var ReceitasRepository
     */
    private $receitasRepository;

    /**
     * @var DespesasRepository
     */
    private $despesasRepository;

    public function __construct(
        ReceitasRepository $receitasRepository,
        DespesasRepository $despesasRepository
    ) {
        $this->receitasRepository = $receitasRepository;
        $this->despesasRepository = $despesasRepository;
    }

    /**
     * @Route("/resumo/{ano}/{mes}", methods={"GET"})
     */
    public function buscarResumo(int $ano, int $mes) : JsonResponse
    {
        $valorTotalReceitasDoMes  = $this->getTotalReceitasDoMes($ano, $mes);
        $valorTotalDespesasDoMes  = $this->getTotalDespesasDoMes($ano, $mes);

        $saldoDoMes = $this->calculaSaldo($valorTotalReceitasDoMes, $valorTotalDespesasDoMes);

        $valorGastoPorCategoria = $this->despesasRepository
            ->SumAmountByMonthYearForEachCategory($ano, $mes);
        
        return new JsonResponse(
            [
                "valorTotalReceitasDoMes" => $valorTotalReceitasDoMes,
                "valorTotalDespesasDoMes" => $valorTotalDespesasDoMes,
                "saldoDoMes" => $saldoDoMes,
                "valorGastoPorCategoria" => $valorGastoPorCategoria,
            ]
        );
    }

    public function calculaSaldo(float $valorTotalReceitasDoMes, float $valorTotalDespesasDoMes) : float
    {
        return $valorTotalReceitasDoMes - $valorTotalDespesasDoMes;
    }

    public function getTotalReceitasDoMes(int $ano,int $mes) : float
    {
        return $this->receitasRepository->SumAmountByMonthYear($ano, $mes);
    }

    public function getTotalDespesasDoMes(int $ano, int $mes) : float
    {
        return $this->despesasRepository->SumAmountByMonthYear($ano, $mes);
    }
}
