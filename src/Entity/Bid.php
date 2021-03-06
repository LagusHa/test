<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BidRepository")
 */
class Bid
{
    const WAIT_CALL = 1;
    const CALLED = 2;
    const ACCEPTED = 3;
    const REJECTED = 4;
    const POSTPONED = 5;
    const CONFIRMED = 6;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", length=11)
     */
    private int $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $middleName;
    /**
     * @var int
     * @ORM\Column(type="integer", length=3)
     */
    private int $age;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $email;
    /**
     * @var string
     * @ORM\Column(type="string", length=15)
     */
    private string $phone;
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private string $employ;
    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private ?string $information;
    /**
     * @var int|null
     * @ORM\Column(type="integer", length=100, nullable=true)
     */
    private ?int $price;
    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private int $status;

    public function __construct(string $lastName, string $firstName, string $email,
                                int $age, string $phone, string $employ)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->age = $age;
        $this->phone = $phone;
        $this->employ = $employ;

        $this->status = self::WAIT_CALL;
    }

    public function accept(): void
    {
        if ($this->status === self::WAIT_CALL){
            throw new \LogicException("Нельзя принять не прозвоненную заявку!");
        }
        if ($this->status === self::REJECTED){
            throw new \LogicException("Нельзя принять отклоненную заявку!");
        }
        if ($this->status === self::CONFIRMED){
            throw new \LogicException("Нельзя принять подтвержденную заявку!");
        }

        $this->status = self::ACCEPTED;
    }

    public function reject(): void
    {
        if ($this->status === self::ACCEPTED){
            throw new \LogicException("Нельзя отклонить принятую заявку!");
        }
        if ($this->status === self::CONFIRMED){
            throw new \LogicException("Нельзя отклонить подтвержденную заявку!");
        }

        $this->status = self::REJECTED;
    }

    public function call(): void
    {
        if ($this->status !== self::WAIT_CALL){
            throw new \LogicException("Нельзя поменять заявку!");
        }

        $this->status = self::CALLED;
    }

    public function postponed(): void
    {
        if ($this->status === self::REJECTED){
            throw new \LogicException("Нельзя отложить отклоненную заявку!");
        }
        if ($this->status === self::CONFIRMED){
            throw new \LogicException("Нельзя отложить подтвержденную заявку!");
        }
        if ($this->status !== self::WAIT_CALL){
            throw new \LogicException("Нельзя отложить непрозвоненную заявку!");
        }

        $this->status= self::POSTPONED;
    }

    public function confirm(): void
    {
        if ($this->status !== self::ACCEPTED){
            throw new \LogicException("Можно подтвердить только принятую заявку!");
        }

        $this->status = self::CONFIRMED;
    }

    /**
     * @return string|null
     */
    public function getInformation(): ?string
    {
        return $this->information;
    }


    /**
     * @param string|null $information
     */
    public function setInformation(?string $information): void
    {
        $this->information = $information;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param string|null $middleName
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmploy(): string
    {
        return $this->employ;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

}