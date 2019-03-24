<?php
namespace App\InfrastractureCalculator;

use App\Infrastructure\Server;
use App\Infrastructure\VirtualMachine;

class Calculator
{
    public static function calculate(Server $server, VirtualMachine ...$virtualMachines) : int
    {
        $requiredServers = 1;
        foreach ($virtualMachines as $key => $virtualMachine) {
            if (!$server->dispatch($virtualMachine)) {
                $server->freeResources();
                $server->dispatch($virtualMachine);
                $requiredServers++;
            }
        }
        return $requiredServers;
    }
}