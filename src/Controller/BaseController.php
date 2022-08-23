<?php

namespace App\Controller;

use App\Factory\EntidadeFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EntidadeFactory
     */
    protected $factory;

    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }
    
    public function buscarTodos(Request $request) : Response
    {
        $informacoesDeOrdenacao = $request->query->get('sort');
        $EntityList = $this->repository->findBy([], $informacoesDeOrdenacao);
        return new JsonResponse($EntityList);
    }

    public function buscarUm(int $id) : Response
    {
        $entity = $this->repository->find($id);

        $codigoRetorno = is_null($entity) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($entity, $codigoRetorno);
    }

    public function remove(int $id) : Response
    {
        $entity = $this->repository->find($id);
        $this->repository->remove($entity, true);
        
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entity = $this->factory->criarEntidade($corpoRequisicao);

        if ($this->repository->count(
            [
                'descricao' => $entity->getDescricao(),
                'data' => $entity->getData()
            ]
        ))
        return new JsonResponse(
            ["Erro" => "Já existe uma despesa/receita com essa descricao e data."]
        );

        $this->repository->add($entity, true);

        return new JsonResponse($entity);
    }

    public function atualiza(int $id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $entityEnviado = $this->factory->criarEntidade($corpoRequisicao);

        if ($this->repository
            ->VerificaSeJaExisteDespesaComOutroID(
                $id,
                $entityEnviado->getDescricao(),
                $entityEnviado->getData()->format('Y-m-d')
            ) >0
        ) 
        return new JsonResponse(["Erro" => "Já existe outra despesa/receita igual."]);

        $entityExistente = $this->repository->find($id);

        if (is_null($entityExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->atualizarEntidadeExistente($entityExistente, $entityEnviado);

        $this->entityManager->flush();

        return new JsonResponse($entityExistente);
    }

    abstract public function atualizarEntidadeExistente(
        $entityExistente,
        $entityEnviado
    );
}