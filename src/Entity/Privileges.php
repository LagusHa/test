<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Repository\PrivilegesRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use ReflectionException;
use ReflectionObject;

/**
 * @ORM\Entity(repositoryClass=PrivilegesRepository::class)
 */
class Privileges
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $loginToDashboard = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $callBid = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $rejectBid = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $acceptBid = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $postponeBid = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $confirmBid = false;

    /**
     * @return static
     */
    #[Pure] public static function createDefault(): self
    {
        return new self();
    }

    /**
     * @param $privileges
     */
    public function fromArray($privileges): void
    {
        foreach ($privileges as $prop => $privilege){
            $this->changePrivileges($prop, $privilege);
        }
        return;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        try{
            $list = [];
            $reflect = new ReflectionObject($this);

            $props = $reflect->getProperties();

            foreach ($props as $prop){
                if ($prop->getName() == 'id') continue;
                $prop->setAccessible(true);
                $list[$prop->getName()] = $prop->getValue($this);
            }
        }catch (ReflectionException $exception){
        }finally{
            return $list;
        }
    }

    /**
     * @return array
     */
    public static function privilegesList(): array
    {
        try{
            $list = [];
            $reflect = new ReflectionObject(new self());

            $props = $reflect->getProperties();

            foreach ($props as $prop){
                if ($prop->getName() == 'id') continue;
                $list[] = $prop->getName();
            }
        }catch (ReflectionException $exception){

        }finally{
            return $list;
        }
    }

    public function changePrivileges(string $property, bool $privilege): void
    {
        if (property_exists($this, $property)) {
            $this->$property = $privilege;
        }
    }

    /**
     * @param string $property
     * @return bool
     */
    public function can(string $property): bool
    {
        if (!property_exists($this, $property)){
            throw new \InvalidArgumentException("Такой привилегии не существует!");
        }
        return $this->{$property};
    }

    /**
     * @return bool
     */
    public function getLoginToDashboard(): bool
    {
        return $this->loginToDashboard;
    }

    /**
     * @return bool
     */
    public function getCallBid(): bool
    {
        return $this->callBid;
    }

    /**
     * @return bool
     */
    public function getRejectBid(): bool
    {
        return $this->rejectBid;
    }

    /**
     * @return bool
     */
    public function getAcceptBid(): bool
    {
        return $this->acceptBid;
    }

    /**
     * @return bool
     */
    public function getPostponeBid(): bool
    {
        return $this->postponeBid;
    }

    /**
     * @return bool
     */
    public function getConfirmBid(): bool
    {
        return $this->confirmBid;
    }
}
