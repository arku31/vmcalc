<?php
namespace App\Infrastructure\Contracts;

interface ComputerInterface
{
    public function __construct(int $cpu, int $ram, int $hdd);
    public function getHdd();
    public function getRam();
    public function getCpu();
}