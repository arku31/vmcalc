<?php
namespace App\InfrastructureCalculator;

use App\Infrastructure\Server;
use App\Infrastructure\VirtualMachine;

class Calculator
{
    /** @var int  */
    protected $requiredServers = 1;
    /** @var Server */
    protected $server;
    /** @var VirtualMachine[] */
    protected $virtualMachines;

    /**
     * Calculator constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @param VirtualMachine ...$virtualMachines
     * @return Calculator
     */
    public function setVirtualMachines(VirtualMachine ...$virtualMachines) : self
    {
        $this->virtualMachines = $virtualMachines;
        return $this;
    }

    /**
     * @return int
     */
    public function calculate() : int
    {
        foreach ($this->virtualMachines as $virtualMachine) {
            if ($this->dispatch($virtualMachine)) {
                $this->requiredServers++;
            }
        }
        return $this->requiredServers;
    }

    /**
     * @param VirtualMachine $virtualMachine
     * @return bool
     */
    private function dispatch(VirtualMachine $virtualMachine) : bool
    {
        if (!$this->server->dispatch($virtualMachine)) {
            $this->server->freeResources();
            $this->server->dispatch($virtualMachine);
            return true;
        }
        return false;
    }
}