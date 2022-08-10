<?php

namespace App\Controller;

use App\Entity\Receitas;
use App\Factory\ReceitasFactory;
use App\Repository\ReceitasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReceitasController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ReceitasFactory
     */
    private $receitasFactory;

    /**
     * @var ReceitasRepository
     */
    private $receitasRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ReceitasFactory $receitasFactory,
        ReceitasRepository $receitasRepository
    ) {
        $this->entityManager = $entityManager;
        $this->receitasFactory = $receitasFactory;
        $this->receitasRepository = $receitasRepository;
    }

    /**
     * @Route("/receitas", methods={"POST"})
     */
    public function nova(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $receitas = $this->receitasFactory->criarReceitas($corpoRequisicao);

        if ($this->receitasRepository->count(
                [
                    'descricao' => $receitas->getDescricao(),
                    'data' => $receitas->getData()
                ]
            ))
            return new JsonResponse(["Erro" => "Já existe uma receita com essa descricao e data."]);

        $this->entityManager->persist($receitas);
        $this->entityManager->flush();

        return new JsonResponse($receitas);
    }

    /**
     * @Route("/receitas", methods={"GET"})
     */
    public function buscarTodos(Request $request) : Response
    {
        $descricao = $request->query->get('descricao');
        if($descricao!="") {
            $receitasList = $this->receitasRepository->findByDescricao($descricao);
        } else {
            $receitasList  = $this->receitasRepository->findAll();
        }

        return new JsonResponse($receitasList);
    }

    public function buscaReceitas(int $id) 
    {
        $receitas = $this->receitasRepository->find($id);
        return $receitas;
    }

    public function buscaReceitasReference(int $id)
    {
        $receitas = $this->entityManager->getReference(Receitas::class, $id);
        return $receitas;
    }

    /**
     * @Route("/receitas/{id}", methods={"GET"})
     */
    public function buscarUm(int $id) : Response
    {
        $receitas = $this->buscaReceitas($id);

        $codigoRetorno = is_null($receitas) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($receitas, $codigoRetorno);
    }

    /**
     * @Route("/receitas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $receitasEnviado = $this->receitasFactory->criarReceitas($corpoRequisicao);

        if ($this->receitasRepository
            ->VerificaSeJaExisteDespesaComOutroID(
                $id,
                $receitasEnviado->getDescricao(),
                $receitasEnviado->getData()->format('Y-m-d')
            ) >0
        ) 
        return new JsonResponse(["Erro" => "Já existe outra despesa igual."]);

        $receitasExistente = $this->buscaReceitas($id);

        if (is_null($receitasExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $receitasExistente->setDescricao($receitasEnviado->getDescricao()); 

        $this->entityManager->flush();

        return new JsonResponse($receitasExistente);
    }

    /**
     * @Route("/receitas/{id}", methods={"DELETE"})
     */
    public function remove(int $id) : Response
    {
        $receitas = $this->buscaReceitasReference($id);
        $this->entityManager->remove($receitas);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
