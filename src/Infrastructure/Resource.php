<?php
namespace App\Infrastructure;

use App\Infrastructure\Contracts\ComputerInterface;
use App\Infrastructure\Contracts\ResourceContract;
use App\Infrastructure\Exceptions\NullResourceException;
use App\Infrastructure\Exceptions\ServerCannotFitResourceException;
use App\Infrastructure\Exceptions\WrongResourceTypeException;

/**
 * Class Resource
 * @package App\Infrastructure
 */
final class Resource implements ResourceContract
{
    private const RESOURCE_TYPES = ['CPU', 'RAM', 'HDD'];

    /** @var string  */
    private $type;
    /** @var int  */
    private $available;
    /** @var int */
    private $used = 0;

    /**
     * Resource constructor.
     * @param string $type
     * @param int $limit
     * @throws NullResourceException
     * @throws WrongResourceTypeException
     */
    public function __construct(string $type, int $limit)
    {
        if (!in_array($type, self::RESOURCE_TYPES)) {
            throw new WrongResourceTypeException('Invalid resource type');
        }

        if ($limit == 0) {
            throw new NullResourceException();
        }

        $this->type = $type;
        $this->available = $limit;
    }

    /**
     * @return int
     */
    public function getUsed(): int
    {
        return $this->used;
    }

    /**
     * @param int $used
     */
    public function setUsed(int $used): void
    {
        $this->used = $used;
    }

    /**
     * @return int
     */
    public function getAvailable(): int
    {
        return $this->available;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param ComputerInterface $virtualMachine
     * @return bool
     * @throws ServerCannotFitResourceException
     */
    public function canFitVm(ComputerInterface $virtualMachine) : bool
    {
        $getter = 'get'.ucfirst(strtolower($this->getType()));

        if ($virtualMachine->$getter()->getAvailable() > $this->getAvailable()) {
            throw new ServerCannotFitResourceException();
        }

        $shouldAllocate = $this->getUsed() + $virtualMachine->$getter()->getAvailable();
        return $this->getAvailable() >= $shouldAllocate;
    }

    /**
     * @param ComputerInterface $virtualMachine
     */
    public function allocate(ComputerInterface $virtualMachine) : void
    {
        $getter = 'get'.ucfirst(strtolower($this->getType()));
        $vmResourceLimit = $virtualMachine->$getter()->getAvailable();
        $shouldAllocate = $this->getUsed() + $vmResourceLimit;
        $this->setUsed($shouldAllocate);
    }
}