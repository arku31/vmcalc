<?php

use App\Infrastructure\Contracts\ComputerInterface;
use App\Infrastructure\Contracts\ServerContract;
use App\InfrastructureCalculator\Calculator;

if (!function_exists('calculate')) {
    function calculate(ServerContract $server, ComputerInterface ...$virtualMachines)
    {
        return (new Calculator($server))
            ->setVirtualMachines(...$virtualMachines)
            ->calculate();
    }
}