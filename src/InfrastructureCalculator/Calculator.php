<?php
namespace App\InfrastructureCalculator;

use App\Infrastructure\Contracts\ComputerInterface;
use App\Infrastructure\Contracts\ServerContract;

/**
 * Class Calculator
 * @package App\InfrastructureCalculator
 */
final class Calculator
{
    /** @var int  */
    protected $requiredServers = 1;
    /** @var ServerContract */
    protected $server;
    /** @var ComputerInterface[] */
    protected $virtualMachines;

    /**
     * Calculator constructor.
     * @param ServerContract $server
     */
    public function __construct(ServerContract $server)
    {
        $this->server = $server;
    }

    /**
     * @param ComputerInterface ...$virtualMachines
     * @return Calculator
     */
    public function setVirtualMachines(ComputerInterface ...$virtualMachines) : self
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
     * @param ComputerInterface $virtualMachine
     * @return bool
     */
    private function dispatch(ComputerInterface $virtualMachine) : bool
    {
        if (!$this->server->dispatch($virtualMachine)) {
            $this->server->freeResources();
            $this->server->dispatch($virtualMachine);
            return true;
        }
        return false;
    }
}