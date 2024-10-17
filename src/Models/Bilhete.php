<?php
namespace Loteria\Models;

class Bilhete
{
    private $quantidadeDezenas;

    public function __construct($quantidadeDezenas)
    {
        $this->quantidadeDezenas = $quantidadeDezenas;
    }

    // Método para gerar um bilhete com dezenas únicas em ordem crescente
    public function gerarBilhete()
    {
        $numeros = [];
        while (count($numeros) < $this->quantidadeDezenas) {
            $numero = rand(1, 60);
            if (!in_array($numero, $numeros)) {
                $numeros[] = $numero;
            }
        }
        sort($numeros);
        return $numeros;
    }
}