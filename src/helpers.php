<?php

use App\InfrastructureCalculator\Calculator;
use App\Infrastructure\Server;
use App\Infrastructure\VirtualMachine;

if (!function_exists('calculate')) {
    function calculate(Server $server, VirtualMachine ...$virtualMachines)
    {
        return (new Calculator($server))
            ->setVirtualMachines(...$virtualMachines)
            ->calculate();
    }
}