<?php

namespace OrderBundle\Test\Service;

use FidelityProgramBundle\Service\FidelityProgramService;
use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use OrderBundle\Exception\BadWordsFoundException;
use OrderBundle\Exception\CustomerNotAllowedException;
use OrderBundle\Exception\ItemNotAvailableException;
use OrderBundle\Repository\OrderRepository;
use OrderBundle\Service\BadWordsValidator;
use OrderBundle\Service\OrderService;
use PaymentBundle\Entity\PaymentTransaction;
use PaymentBundle\Service\PaymentService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    private $badWordsValidator;
    private $paymentService;
    private $orderRepository;
    private $fidelityProgramService;
    private $customer;
    private $item;
    private $creditCard;
    private $orderService;

    public function setUp()
    {
        $this->badWordsValidator = $this->createMock(BadWordsValidator::class);
        $this->paymentService = $this->createMock(PaymentService::class);
        $this->orderRepository = $this->createMock(OrderRepository::class);
        $this->fidelityProgramService = $this->createMock(FidelityProgramService::class);

        $this->customer = $this->createMock(Customer::class);
        $this->item = $this->createMock(Item::class);
        $this->creditCard = $this->createMock(CreditCard::class);
    }

    /**
     * @test
     */
    public function shouldNotProcessWhenCustomerIsNotAllowed()
    {
        $this->withOrderService()
            ->withCustomerAllowed(False);

        $this->expectException(CustomerNotAllowedException::class);

        $this->orderService->process(
            $this->customer,
            $this->item,
            '',
            $this->creditCard
        );
    }

    /**
     * @test
     */
    public function shouldNotProcessWhenItemIsNotAvailable()
    {
        $this->withOrderService()
            ->withCustomerAllowed()
            ->withAvailableItem(False);

        $this->expectException(ItemNotAvailableException::class);

        $this->orderService->process(
            $this->customer,
            $this->item,
            '',
            $this->creditCard
        );
    }

    /**
     * @test
     */
    public function shouldNotProcessWhenBadWordsIsFound()
    {
        $this->withOrderService()
            ->withCustomerAllowed()
            ->withAvailableItem()
            ->withBadWordsFound();

        $this->expectException(BadWordsFoundException::class);

        $this->orderService->process(
            $this->customer,
            $this->item,
            '',
            $this->creditCard
        );
    }

    /**
     * @test
     */
    public function shouldSuccessfullyProcess()
    {
        $this->withOrderService()
            ->withCustomerAllowed()
            ->withAvailableItem()
            ->withBadWordsFound(False);

        $paymentTransaction = $this->createMock(PaymentTransaction::class);

        $this->paymentService
            ->method('pay')
            ->willReturn($paymentTransaction);

        $this->fidelityProgramService
             ->expects($this->once())
             ->method('addPoints');
    

        $this->orderRepository
            ->expects($this->once())
            ->method('save');

        $createdOrder = $this->orderService->process(
            $this->customer,
            $this->item,
            '',
            $this->creditCard
        );

        $this->assertNotEmpty($createdOrder->getPaymentTransaction());
    }

    public function withOrderService()
    {
        $this->orderService = new OrderService(
            $this->badWordsValidator,
            $this->paymentService,
            $this->orderRepository,
            $this->fidelityProgramService
        );

        return $this;
    }


    public function withCustomerAllowed($permitido=True)
    {
        $this->customer
            ->method('isAllowedToOrder')
            ->willReturn($permitido);
        return $this;
    }


    public function withAvailableItem($disponivel=True)
    {
        $this->item
            ->method('isAvailable')
            ->willReturn($disponivel);

        return $this;
    }

    public function withBadWordsFound($encontrado=True)
    {
        $this->badWordsValidator
            ->method('hasBadWords')
            ->willReturn($encontrado);

        return $this;
    }

}
