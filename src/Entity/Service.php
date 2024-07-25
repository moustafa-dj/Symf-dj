<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Domain $domain = null;

    /**
     * @var Collection<int, ServiceMedia>
     */
    #[ORM\OneToMany(targetEntity: ServiceMedia::class, mappedBy: 'service')]
    private Collection $service_media;

    public function __construct()
    {
        $this->service_media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection<int, ServiceMedia>
     */
    public function getServiceMedia(): Collection
    {
        return $this->service_media;
    }

    public function addServiceMedia(ServiceMedia $service_media): static
    {
        if (!$this->service_media->contains($service_media)) {
            $this->service_media->add($service_media);
            $service_media->setService($this);
        }

        return $this;
    }

    public function removeServiceMedia(ServiceMedia $service_media): static
    {
        if ($this->service_media->removeElement($service_media)) {
            if ($service_media->getService() === $this) {
                $service_media->setService(null);
            }
        }

        return $this;
    }
}
