<?php
namespace App\Infrastructure\Contracts;

interface ResourceContract
{
    public function getUsed(): int;
    public function setUsed(int $used): void;
    public function getAvailable(): int;
    public function getType(): string;
    public function allocate(ComputerInterface $virtualMachine) : void;
    public function canFitVm(ComputerInterface $virtualMachine) : bool;
}