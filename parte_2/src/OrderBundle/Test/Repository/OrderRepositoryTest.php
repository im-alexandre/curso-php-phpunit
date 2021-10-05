<?php 
namespace OrderBundle\Test\Repository;

use OrderBundle\Repository\OrderRepository;
use OrderBundle\Entity\Order;
use MyFramework\DataBase\DataBase;

use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase {
    private $database;
    private $repository;

    public function setUp() {
        $this->database = $this->createMock(DataBase::class);
        $this->repository = new OrderRepository($this->database);
    }
    
    /**
     * @test
     *
     */
    public function shouldPersistWhenSave() {
        $order = $this->createMock(Order::class);
        $gravada = $this->repository->save($order);
        $transaction = $this->repository->persist($order);
        $this->assertEquals($gravada, $transaction);
    }

    public function shouldFailWithoutOrder() {
        $this->expectException('ArgumentCountError');
        $this->repository->save();
    }
}
?>
