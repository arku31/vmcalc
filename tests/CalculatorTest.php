<?php
namespace App\Tests;

use App\Infrastructure\Exceptions\NullResourceException;
use App\Infrastructure\Exceptions\ServerCannotFitResourceException;
use App\Infrastructure\Server;
use App\Infrastructure\VirtualMachine;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @throws \App\Infrastructure\Exceptions\WrongResourceTypeException
     * @throws NullResourceException
     */
    public function testSeveralVms()
    {
        $server = new Server(3, 3, 3);
        $vms = [
            new VirtualMachine(1, 1, 1), //1
            new VirtualMachine(1, 1, 1), //1
            new VirtualMachine(1, 1, 1), //1
        ];
        $result = calculate($server, ...$vms);
        $this->assertEquals($result, 1);

        $server = new Server(3, 3, 3);
        $vms = [
            new VirtualMachine(3, 3, 3), //1
        ];
        $result = calculate($server, ...$vms);
        $this->assertEquals($result, 1);
    }

    /**
     * @throws \App\Infrastructure\Exceptions\WrongResourceTypeException
     * @throws NullResourceException
     */
    public function testNotEqualVms()
    {
        $server = new Server(3, 3, 3);
        $vms = [
            new VirtualMachine(1, 2, 1), //1
            new VirtualMachine(2, 1, 2), //1
        ];
        $result = calculate($server, ...$vms);
        $this->assertEquals($result, 1);

        $server = new Server(10, 10, 10);
        $vms = [
            new VirtualMachine(1, 1, 1), //1
            new VirtualMachine(2, 2, 2), //1
            new VirtualMachine(3, 3, 3), //1
        ];
        $result = calculate($server, ...$vms);
        $this->assertEquals($result, 1);
    }

    /**
     * @throws \App\Infrastructure\Exceptions\WrongResourceTypeException
     * @throws NullResourceException
     */
    public function testSeveralVmsDoNotFitOneServer()
    {
        $server = new Server(3, 3, 3);
        $vms = [
            new VirtualMachine(1, 1, 1), //1
            new VirtualMachine(1, 1, 1), //1
            new VirtualMachine(1, 1, 1), //1
            new VirtualMachine(1, 1, 1), //2
        ];
        $result = calculate($server, ...$vms);
        $this->assertEquals($result, 2);

        $vms[] = new VirtualMachine(3, 3, 3);
        $result = calculate($server, ...$vms);
        $this->assertEquals($result, 3);
    }

    /**
     * @throws \App\Infrastructure\Exceptions\WrongResourceTypeException
     * @throws NullResourceException
     */
    public function testVmTooBigForServer()
    {
        $server = new Server(3, 3, 3);
        $vms = [
            new VirtualMachine(10, 10, 10)
        ];
        $this->expectException(ServerCannotFitResourceException::class);
        calculate($server, ...$vms);
    }

    /**
     * @throws \App\Infrastructure\Exceptions\WrongResourceTypeException
     * @throws NullResourceException
     */
    public function testNullResourceServer()
    {
        $this->expectException(NullResourceException::class);
        new Server(0, 0, 0);
    }
}