<?php

namespace App\Infrastructure;

abstract class AbstractComputer implements ComputerInterface
{
    /**
     * @var Resource
     */
    protected $cpu;
    /**
     * @var Resource
     */
    protected $ram;
    /**
     * @var Resource
     */
    protected $hdd;

    /**
     * AbstractComputer constructor.
     * @param int $cpu
     * @param int $ram
     * @param int $hdd
     * @throws Exceptions\WrongResourceTypeException
     * @throws Exceptions\NullResourceException
     */
    public function __construct(int $cpu, int $ram, int $hdd)
    {
        $this->cpu = new Resource('CPU', $cpu);
        $this->ram = new Resource('RAM', $ram);
        $this->hdd = new Resource('HDD', $hdd);
    }

    /**
     * @return Resource[]
     */
    public function getAllResources() : array
    {
        return [$this->cpu, $this->ram, $this->hdd];
    }


    /**
     * @return Resource
     */
    public function getHdd(): Resource
    {
        return $this->hdd;
    }

    /**
     * @return Resource
     */
    public function getRam(): Resource
    {
        return $this->ram;
    }

    /**
     * @return Resource
     */
    public function getCpu(): Resource
    {
        return $this->cpu;
    }
}