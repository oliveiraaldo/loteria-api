<?php
namespace Loteria\Models;

class ConferirBilhetes
{
    private $bilhetePremiado;

    public function __construct(array $bilhetePremiado)
    {
        $this->bilhetePremiado = $bilhetePremiado;
    }

    // Método para conferir os bilhetes gerados com o bilhete premiado
    public function verificarBilhetes(array $bilhetes)
    {
        $html = '<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">';
        $html .= '<thead><tr><th>Bilhete</th><th>Dezenas</th></tr></thead><tbody>';

        foreach ($bilhetes as $index => $bilhete) {
            $html .= "<tr><td>Bilhete " . ($index + 1) . "</td><td>";

            $dezenasDestacadas = array_map(function($numero) {
                return in_array($numero, $this->bilhetePremiado) ? "<b>{$numero}</b>" : $numero;
            }, $bilhete);

            $html .= implode(', ', $dezenasDestacadas);
            $html .= "</td></tr>";
        }

        $html .= '</tbody></table>';
        return $html;
    }
}