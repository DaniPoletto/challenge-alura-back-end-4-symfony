<?php

namespace App\Controller;

use App\Entity\Despesas;
use App\Factory\DespesasFactory;
use App\Controller\BaseController;
use App\Repository\DespesasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DespesasController extends BaseController
{
    /**
     * @var DespesasFactory
     */
    private $despesasFactory;

    public function __construct(
        DespesasRepository $despesasRepository,
        EntityManagerInterface $entityManager,
        DespesasFactory $despesasFactory
    ) {
        parent::__construct
        (
            $despesasRepository, 
            $entityManager, 
            $despesasFactory
        );
    }

    /**
     * @Route("/despesas/{ano}/{mes}", methods={"GET"})
     */
    public function buscarReceitasDoMes(int $ano, int $mes) : Response
    {
        $despesasList  = $this->repository
            ->findByMonthYear($ano, $mes);
        return new JsonResponse($despesasList);
    }

    /**
     * @Route("/despesas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $despesasEnviado = $this->factory->criarEntidade($corpoRequisicao);

        if ($this->repository
            ->VerificaSeJaExisteDespesaComOutroID(
                $id,
                $despesasEnviado->getDescricao(),
                $despesasEnviado->getData()->format('Y-m-d')
            ) >0
        ) 
            return new JsonResponse(["Erro" => "Já existe outra despesa igual."]);

        $despesasExistente = $this->repository->find($id);

        if (is_null($despesasExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $despesasExistente->setDescricao($despesasEnviado->getDescricao()); 

        $dadoEmJson = json_decode($corpoRequisicao);
        if (isset($dadoEmJson->id_categoria))
            $despesasExistente->setCategoria($despesasEnviado->getCategoria()); 

        $this->entityManager->flush();

        return new JsonResponse($despesasExistente);
    }

    /**
     * @param Despesas $entityExistente
     * @param Despesas $entityEnviado
     */
    public function atualizarEntidadeExistente($entityExistente, $entityEnviado)
    {
        $entityExistente->setDescricao($entityEnviado->getDescricao()); 
    }
}
