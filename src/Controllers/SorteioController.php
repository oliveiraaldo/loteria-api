<?php
namespace Loteria\Controllers;

use Loteria\Services\SorteioService;

class SorteioController
{
    private $sorteioService;

    public function __construct(SorteioService $sorteioService)
    {
        $this->sorteioService = $sorteioService;
    }

    // Método para gerar bilhetes
    public function gerarBilhetes($quantidadeBilhetes, $quantidadeDezenas)
    {
        return $this->sorteioService->gerarBilhetes($quantidadeBilhetes, $quantidadeDezenas);
    }

    // Método para gerar o sorteio
    public function gerarSorteio()
    {
        return $this->sorteioService->gerarBilhetePremiado();
    }

    // Método para conferir os bilhetes
    public function conferirBilhetes()
    {
        return $this->sorteioService->conferirBilhetes();
    }
}