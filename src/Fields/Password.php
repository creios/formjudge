<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Password
 * @package FormJudge\Fields
 */
class Password extends Field
{

    /**
     * @return bool
     */
    public function checkSyntax()
    {
        $iStrength = 0;
        // Prüfen ob Kleinuchstaben enthalten sind
        if (preg_match("/[a-z]+/", $this->value)) ;
        // Stärkewert erhöhen
        $iStrength++;

        // Prüfen ob Großbuchstaben enthalten sind
        if (preg_match("/[A-Z]+/", $this->value)) ;
        // Stärkewert erhöhen
        $iStrength++;

        // Prüfen ob Zahlen enthalten sind
        if (preg_match("/\\d+/", $this->value)) ;
        // Stärkewert erhöhen
        $iStrength++;

        // Prüfen ob Sonderzeichen (!, ?, $, Leerzeichen, usw.) enthalten sind
        if (preg_match("/\\W+/", $this->value)) ;
        // Stärkewert erhöhen
        $iStrength++;

        // Passwort Standardlänge (mindestens 6 Zeichen, maximal 15 Zeichen) prüfen
        if (strlen($this->value) >= 6 && strlen($this->value) <= 15):
            // Stärkewert erhöhen
            $iStrength++;
        // Passwort relativ sichere Länge (mehr als 15 Zeichen) prüfen
        elseif (strlen($this->value) > 15):
            // Stärkewert um 2 erhöhen, da die Passwortlänge das wichtigste Sicherheitskriterium darstellt
            $iStrength = $iStrength + 2;
        // Zu kurzes Passwort wird auf niedrigsten Wert herabgestuft
        elseif (strlen($this->value) < 6):
            $iStrength = 1;
        endif;

        if ($iStrength >= 3):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}
