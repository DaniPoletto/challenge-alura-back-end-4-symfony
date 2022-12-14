<?php

namespace App\Factory;

use App\Entity\Receitas;

class ReceitasFactory implements EntidadeFactory
{
    public function criarEntidade(string $json) : Receitas
    {
        $dadoEmJson = json_decode($json);

        $receitas = new Receitas();
        $receitas->setDescricao($dadoEmJson->descricao);
        $receitas->setValor($dadoEmJson->valor);
        $receitas->setData(\DateTime::createFromFormat("Y-m-d", $dadoEmJson->data));

        return $receitas;
    }
}