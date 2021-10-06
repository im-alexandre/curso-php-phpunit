<?php 
require_once('MinhaClasse.php');
use PHPUnit\Framework\TestCase;

class MinhaClasseTest extends TestCase {
    /**
     * @test
     * @dataProvider valueProvider
     *
     */
    public function shoudReturn($value, $expected) {

        $classe = new MinhaClasse($value);
        $retorno = $classe->minhafuncao($value);

        $this->assertEquals($retorno, $expected);
    }

    /**
     * @test
     * @dataProvider valueProvider
     *
     */
    public function shouldSave($value, $expected) {
        $classe = new MinhaClasse($value);
        $retorno = $classe->save($value);

        $this->assertEquals($retorno, $expected);
    }

    public function valueProvider() {
        return [
            "shoudReturnBWhenGivenB" => ["value" => "B", "B"],
            "shoudFailwithBWhenGivenA" => ["value" => "A", "A"],
        ];
    }
}
?>
