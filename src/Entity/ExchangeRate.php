<?php

namespace App\Entity;

use App\Enum\CurrencyType;
use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[ORM\Entity(repositoryClass: ExchangeRateRepository::class)]
#[ORM\Table(name: 'exchange_rates')]
#[ORM\HasLifecycleCallbacks]
class ExchangeRate
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(length: 3, nullable: true)]
    private CurrencyType $type;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $name         = null;

    #[ORM\Column(name: 'short_name', length: 5, unique: true)]
    private ?string $shortName    = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $symbol       = null;

    #[ORM\Column(name: 'created_at')]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: 'updated_at')]
    private ?\DateTime $updatedAt = null;

    #[ORM\PrePersist]
    public function onPrePersist(LifecycleEventArgs $args): void
    {
        $this->createdAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(LifecycleEventArgs $args): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setShortName(string $shortName): static
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function setSymbol(?string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
    }
}
