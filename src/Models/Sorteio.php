<?php
namespace Loteria\Models;

class Sorteio
{
    // Método para gerar o bilhete premiado com 6 dezenas únicas
    public function gerarBilhetePremiado()
    {
        $numeros = [];
        while (count($numeros) < 6) {
            $numero = rand(1, 60);
            if (!in_array($numero, $numeros)) {
                $numeros[] = $numero;
            }
        }
        sort($numeros);
        return $numeros;
    }
}