<?php
use PHPUnit\Framework\TestCase;
use Loteria\Models\Bilhete;
use Loteria\Models\Sorteio;
use Loteria\Models\ConferirBilhetes;

class SorteioTest extends TestCase
{
    // Testa se a geração de bilhete tem a quantidade correta de dezenas
    public function testGerarBilhete()
    {
        $bilhete = new Bilhete(6);
        $numeros = $bilhete->gerarBilhete();
        $this->assertCount(6, $numeros);
    }

    // Testa se o bilhete premiado possui 6 dezenas únicas
    public function testGerarBilhetePremiado()
    {
        $sorteio = new Sorteio();
        $bilhetePremiado = $sorteio->gerarBilhetePremiado();
        $this->assertCount(6, $bilhetePremiado);
        $this->assertEquals(count($bilhetePremiado), count(array_unique($bilhetePremiado)));
    }

    // Testa a conferência dos bilhetes
    public function testConferirBilhetes()
    {
        $bilhetePremiado = [3, 7, 12, 18, 27, 36];
        $bilhetes = [
            [3, 5, 7, 9, 12, 18],
            [1, 2, 3, 4, 5, 6],
            [7, 12, 18, 27, 36, 45]
        ];

        $conferirBilhetes = new ConferirBilhetes($bilhetePremiado);
        $html = $conferirBilhetes->verificarBilhetes($bilhetes);

        $this->assertStringContainsString('<b>3</b>', $html);
        $this->assertStringContainsString('<b>7</b>', $html);
        $this->assertStringContainsString('<b>12</b>', $html);
    }
}