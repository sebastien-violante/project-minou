<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('reports')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Groups('reports')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('reports')]
    private $coordx;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('reports')]
    private $coordy;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups('reports')]
    private $message;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('reports')]
    private $status;

    #[ORM\ManyToOne(targetEntity: Cat::class, inversedBy: 'reports')]
    private $cat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCoordx(): ?string
    {
        return $this->coordx;
    }

    public function setCoordx(string $coordx): self
    {
        $this->coordx = $coordx;

        return $this;
    }

    public function getCoordy(): ?string
    {
        return $this->coordy;
    }

    public function setCoordy(string $coordy): self
    {
        $this->coordy = $coordy;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCat(): ?Cat
    {
        return $this->cat;
    }

    public function setCat(?Cat $cat): self
    {
        $this->cat = $cat;

        return $this;
    }
}
