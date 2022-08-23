<?php

namespace App\Factory;

use App\Entity\Despesas;
use App\Repository\CategoriaRepository;

class DespesasFactory implements EntidadeFactory
{
    /**
     * @var CategoriaRepository
     */
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function criarEntidade(string $json) : Despesas
    {
        $dadoEmJson = json_decode($json);

        $despesas = new Despesas();
        $despesas->setDescricao($dadoEmJson->descricao);
        $despesas->setValor($dadoEmJson->valor);
        $despesas->setData(\DateTime::createFromFormat("Y-m-d", $dadoEmJson->data));

        if (isset($dadoEmJson->id_categoria)) {
            $categoria = $this->categoriaRepository->find($dadoEmJson->id_categoria);
            $despesas->setCategoria($categoria);
        } else {
            $categoria = $this->categoriaRepository->find('3');
            $despesas->setCategoria($categoria);
        }

        return $despesas;
    }
}