<?php
namespace Loteria\Services;

use Loteria\Models\Bilhete;
use Loteria\Models\Sorteio;
use Loteria\Models\ConferirBilhetes;
use PDO;

class SorteioService
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Método para gerar bilhetes e salvar no banco de dados
    public function gerarBilhetes($quantidadeBilhetes, $quantidadeDezenas)
    {
        if (!is_numeric($quantidadeBilhetes) || $quantidadeBilhetes < 1 || $quantidadeBilhetes > 50) {
            return ['erro' => 'Quantidade de bilhetes inválida'];
        }

        if (!is_numeric($quantidadeDezenas) || $quantidadeDezenas < 6 || $quantidadeDezenas > 10) {
            return ['erro' => 'Quantidade de dezenas inválida'];
        }

        // Limpa os bilhetes antigos do banco de dados
        $this->db->exec("DELETE FROM bilhetes");

        $bilhetesGerados = [];

        // Gera os bilhetes e insere no banco
        for ($i = 0; $i < $quantidadeBilhetes; $i++) {
            $bilhete = new Bilhete($quantidadeDezenas);
            $numeros = $bilhete->gerarBilhete();
            $bilhetesGerados[] = $numeros;
            $stmt = $this->db->prepare("INSERT INTO bilhetes (numeros) VALUES (:numeros)");
            $stmt->bindValue(':numeros', implode(',', $numeros));
            $stmt->execute();
        }

        return ['mensagem' => 'Bilhetes gerados com sucesso!', 'bilhetes' => $bilhetesGerados];
    }

    // Método para gerar o bilhete premiado e salvar no banco de dados
    public function gerarBilhetePremiado()
    {
        $this->db->exec("DELETE FROM bilhete_premiado");

        $sorteio = new Sorteio();
        $bilhetePremiado = $sorteio->gerarBilhetePremiado();
        $numeros = implode(',', $bilhetePremiado);

        $stmt = $this->db->prepare("INSERT INTO bilhete_premiado (numeros) VALUES (:numeros)");
        $stmt->bindValue(':numeros', $numeros);
        $stmt->execute();

        return ['bilhetePremiado' => $bilhetePremiado];
    }

    // Método para conferir os bilhetes e retornar um HTML
    public function conferirBilhetes()
    {
        $stmt = $this->db->query("SELECT numeros FROM bilhetes");
        $bilhetes = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($bilhetes)) {
            return ['erro' => 'Bilhetes não foram gerados ainda.'];
        }

        $stmt = $this->db->query("SELECT numeros FROM bilhete_premiado LIMIT 1");
        $bilhetePremiado = $stmt->fetchColumn();

        if (!$bilhetePremiado) {
            return ['erro' => 'O sorteio ainda não foi realizado.'];
        }

        $bilhetePremiadoArray = explode(',', $bilhetePremiado);
        $bilhetesArray = array_map(function ($numeros) {
            return explode(',', $numeros);
        }, $bilhetes);

        $conferir = new ConferirBilhetes($bilhetePremiadoArray);
        return $conferir->verificarBilhetes($bilhetesArray);
    }
}