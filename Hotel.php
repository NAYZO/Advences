<?php
/*
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 */

class Hotel
{
    private $x;
    private $types = array();
    private $result = array();

    public function __construct($x, $types)
    {
        $this->x = $x;
        $this->types = $types;
        arsort($this->types);
    }

    public function execute()
    {
        $buffer = $this->types;
        while (count($buffer) > 0) {
            $this->recherche($buffer, $this->x);
            $this->shift($buffer);
        }

        $this->result = array_unique($this->result);
    }

    public function recherche($buffer, $x)
    {
        if ($x != 0 && !empty($buffer)) {

            $type = reset($buffer);
            $key = key($buffer);
            $new = $type;

            if (count($buffer) == 1 && ($x % $type) == 0) {
                $val = $x / $type;
                $this->result[] = "$val $key ";
            } else {
                while ($new <= $x) {
                    $val = $new / $type;
                    $str = "$val $key ";

                    $this->interne($buffer, $x - $new, $str);
                    $new += $type;
                }
            }
        }

    }

    public function interne($buffer, $x, $str)
    {
        if (count($buffer) >= 3) {
            $this->result[] = $this->traitement($buffer, $x, $str);
            $this->shift($buffer);
            $this->interne($buffer, $x, $str);
        } else {
            $this->result[] = $this->traitement($buffer, $x, $str);
        }
    }

    public function traitement($buffer, $x, $str)
    {
        $this->shift($buffer);
        if ($x != 0 && !empty($buffer)) {

            $type = reset($buffer);
            $key = key($buffer);
            $new = $this->getNombre($x, $type);
            $newStr = $str;

            if ($new == 0) {
                return $this->traitement($buffer, $x, $str);
            } elseif (count($buffer) == 1 && ($x % $type) == 0) {
                $val = $x / $type;
                $str .= "$val $key ";
            } else {

                $this->traitement($buffer, $x, $str);
                $str .= "$new $key ";
                $autreVal = $x - ($new * $type);
                $new--;
                while ($new > 0) {

                    $chaine = $newStr . "$new $key ";
                    $var = $x - ($new * $type);
                    $this->result[] = $this->traitement($buffer, $var, $chaine);
                    $new--;
                }

                return $this->traitement($buffer, $autreVal, $str);
            }
        }

        return $str;
    }

    public function shift(&$tab)
    {
        list($k) = array_keys($tab);
        unset($tab[$k]);
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getNombre($x, $type)
    {
        if ($x >= $type) {
            $var = $x / $type;
            return floor($var);
        }

        return 0;
    }
}

?>