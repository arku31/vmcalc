<?php
namespace App\Infrastructure\Contracts;

interface ServerContract
{
    public function canFit(ComputerInterface $virtualMachine) : bool;
    public function dispatch(ComputerInterface $virtualMachine) : bool;
    public function freeResources() : void;
}