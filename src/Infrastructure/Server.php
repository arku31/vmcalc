<?php
namespace App\Infrastructure;

use App\Infrastructure\Contracts\ComputerInterface;
use App\Infrastructure\Contracts\ResourceContract;
use App\Infrastructure\Contracts\ServerContract;

/**
 * Class Server
 * @package App\Infrastructure
 */
final class Server extends AbstractComputer implements ServerContract
{
    /**
     * Check does VM fit the current server. Return false if another server required.
     * @param ComputerInterface $virtualMachine
     * @return bool
     */
    public function canFit(ComputerInterface $virtualMachine) : bool
    {
        /** @var ResourceContract $resource */
        foreach ($this->getAllResources() as $resource) {
            if (!$resource->canFitVm($virtualMachine)) {
                return false;
            }
        }

        return true;
    }

    /**
     *  Dispatching the given vm
     * @param ComputerInterface $virtualMachine
     * @return bool
     */
    public function dispatch(ComputerInterface $virtualMachine) : bool
    {
        if ($this->canFit($virtualMachine)) {
            foreach ($this->getAllResources() as $resource) {
                /** @var ResourceContract $resource */
                $resource->allocate($virtualMachine);
            }
            return true;
        }
        return false;
    }

    /**
     * Set all resources to zero
     */
    public function freeResources() : void
    {
        /** @var ResourceContract $resource */
        foreach ($this->getAllResources() as $resource) {
            $resource->setUsed(0);
        }
    }
}