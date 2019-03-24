<?php

use App\InfrastractureCalculator\Calculator;
use App\Infrastructure\Server;
use App\Infrastructure\VirtualMachine;

if (!function_exists('calculate')) {
    function calculate(Server $server, VirtualMachine ...$virtualMachines)
    {
        return Calculator::calculate($server, ...$virtualMachines);
    }
}