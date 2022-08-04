<?php

namespace App\Factory;

use App\Entity\Despesas;

class DespesasFactory
{
    public function criarDespesas (string $json) : Despesas
    {
        $dadoEmJson = json_decode($json);

        $despesas = new Despesas();
        $despesas->setDescricao($dadoEmJson->descricao);
        $despesas->setValor($dadoEmJson->valor);
        $despesas->setData(\DateTime::createFromFormat("Y-m-d", $dadoEmJson->data));

        return $despesas;
    }
}