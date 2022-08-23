<?php

namespace App\Factory;

interface EntidadeFactory
{
    public function criarEntidade(string $json);
}