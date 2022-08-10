<?php

namespace App\Controller;

use App\Entity\Despesas;
use App\Factory\DespesasFactory;
use App\Repository\DespesasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DespesasController extends AbstractController
{
     /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DespesasFactory
     */
    private $despesasFactory;

    /**
     * @var DespesasRepository
     */
    private $despesasRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DespesasFactory $despesasFactory,
        DespesasRepository $despesasRepository
    ) {
        $this->entityManager = $entityManager;
        $this->despesasFactory = $despesasFactory;
        $this->despesasRepository = $despesasRepository;
    }

    /**
     * @Route("/despesas", methods={"POST"})
     */
    public function nova(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $despesas = $this->despesasFactory->criarDespesas($corpoRequisicao);

        if ($this->despesasRepository->count(
            [
                'descricao' => $despesas->getDescricao(),
                'data' => $despesas->getData()
            ]
        ))
            return new JsonResponse(["Erro" => "Já existe uma despesa com essa descricao e data."]);

        $this->entityManager->persist($despesas);
        $this->entityManager->flush();

        return new JsonResponse($despesas);
    }

    /**
     * @Route("/despesas", methods={"GET"})
     */
    public function buscarTodos(Request $request) : Response
    {
        $descricao = $request->query->get('descricao');
        if($descricao!="") {
            $despesasList = $this->despesasRepository->findByDescricao($descricao);
        } else {
            $despesasList  = $this->despesasRepository->findAll();
        }

        return new JsonResponse($despesasList);
    }

    public function buscaDespesas(int $id) 
    {
        $despesas = $this->despesasRepository->find($id);
        return $despesas;
    }

    public function buscaDespesasReference(int $id)
    {
        $despesas = $this->entityManager->getReference(Despesas::class, $id);
        return $despesas;
    }

    /**
     * @Route("/despesas/{id}", methods={"GET"})
     */
    public function buscarUm(int $id) : Response
    {
        $despesas = $this->buscaDespesas($id);

        $codigoRetorno = is_null($despesas) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($despesas, $codigoRetorno);
    }

    /**
     * @Route("/despesas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $despesasEnviado = $this->despesasFactory->criarDespesas($corpoRequisicao);

        if ($this->despesasRepository
            ->VerificaSeJaExisteDespesaComOutroID(
                $id,
                $despesasEnviado->getDescricao(),
                $despesasEnviado->getData()->format('Y-m-d')
            ) >0
        ) 
            return new JsonResponse(["Erro" => "Já existe outra despesa igual."]);

        $despesasExistente = $this->buscaDespesas($id);

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
     * @Route("/despesas/{id}", methods={"DELETE"})
     */
    public function remove(int $id) : Response
    {
        $despesas = $this->buscaDespesasReference($id);
        $this->entityManager->remove($despesas);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
