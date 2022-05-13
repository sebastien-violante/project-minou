<?php

namespace App\Entity;

use App\Repository\CatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatRepository::class)]
class Cat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $race;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $picture;

    #[ORM\Column(type: 'text', nullable: true)]
    private $details;

    #[ORM\Column(type: 'boolean')]
    private $islost;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $datelost;

    #[ORM\Column(type: 'string', length: 255)]
    private $place;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email = "default";

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $colorStyle;

    #[ORM\OneToMany(mappedBy: 'cat', targetEntity: Report::class)]
    private $reports;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getIslost(): ?bool
    {
        return $this->islost;
    }

    public function setIslost(bool $islost): self
    {
        $this->islost = $islost;

        return $this;
    }

    public function getDatelost(): ?\DateTimeInterface
    {
        return $this->datelost;
    }

    public function setDatelost(?\DateTimeInterface $datelost): self
    {
        $this->datelost = $datelost;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getColorStyle(): ?string
    {
        return $this->colorStyle;
    }

    public function setColorStyle(?string $colorStyle): self
    {
        $this->colorStyle = $colorStyle;

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setCat($this);
        }

        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getCat() === $this) {
                $report->setCat(null);
            }
        }

        return $this;
    }
}
