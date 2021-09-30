
## Testes unitários e TDD com PHP e PHPUnit

### Material do curso
https://www.udemy.com/testes-unitarios-php-phpunit/

## Instruções

Clone o projeto:

`git clone git@github.com:viniciuswebdev/curso-php-phpunit.git`

#### Parte 1

Para executar os testes da `parte 1` basta acessar o diretório:

`cd curso-php-phpunit/parte_1`

E executar os testes:

`php run_tests.php`

#### Parte 2

Para executar os testes da `parte 2` siga as seguintes instruções:

 Acesse o diretório do projeto:
 
`cd curso-php-phpunit/parte_2`

 Instale as dependências:
 
`./composer.phar install`

 Execute os testes:
 
`./vendor/bin/phpunit src/`


Stubs: são objetos cujos comportamentos retornam valores definidos;
Mocks: são objetos que, além de retornarem valores definidos, podemos
verificar se seus métodos estão sendo executados adequadamente;
Dummies: objetos criados apenas para serem passados como parâmetros de
funções ou satisfazerem dependências;
Spies: Objetos que injetam comportamentos em classes para
permitir asserções;
Fakes: Simula os comportamentos e retornos de uma determinada classe
