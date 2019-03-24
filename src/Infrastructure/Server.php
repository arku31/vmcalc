<?php
namespace App\Infrastructure;

class Server extends AbstractComputer
{
    /**
     * Check does VM fit the current server. Return false if another server required.
     * @param VirtualMachine $virtualMachine
     * @return bool
     */
    public function canFit(VirtualMachine $virtualMachine) : bool
    {
        /** @var Resource $resource */
        foreach ($this->getAllResources() as $resource) {
            if (!$resource->canFitVm($virtualMachine)) {
                return false;
            }
        }

        return true;
    }

    /**
     *  Dispatching the given vm
     * @param VirtualMachine $virtualMachine
     * @return bool
     */
    public function dispatch(VirtualMachine $virtualMachine) : bool
    {
        if ($this->canFit($virtualMachine)) {
            foreach ($this->getAllResources() as $resource) {
                /** @var Resource $resource */
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
        /** @var Resource $resource */
        foreach ($this->getAllResources() as $resource) {
            $resource->setUsed(0);
        }
    }
}