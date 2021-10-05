<?php 
class MinhaClasse {
    private $entrada;
    public function __construct($entrada=null) {
        $this->entrada = $entrada;
    }
    public function minhafuncao($entrada) {
        return ($this->entrada) ? $this->entrada : $entrada;
    }
    public function save() {
        return $this->entrada;
    }
}
?>
