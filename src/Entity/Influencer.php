<?php

namespace App\Entity;

use App\Repository\InfluencerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfluencerRepository::class)]
class Influencer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $followers_count = null;

    #[ORM\ManyToMany(mappedBy: 'influencers', targetEntity: Campaign::class)]
    private Collection $campaigns;

    public function __construct()
    {
        $this->campaigns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFollowersCount(): ?int
    {
        return $this->followers_count;
    }

    public function setFollowersCount(?int $followers_count): static
    {
        $this->followers_count = $followers_count;

        return $this;
    }

    public function getCampaigns(): Collection
    {
        return $this->campaigns;
    }
}
