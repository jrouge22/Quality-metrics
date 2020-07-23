<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\VersionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"},
 *     attributes={"order"={"version"}}
 * )
 *
 * @ApiFilter(OrderFilter::class, properties={"version", "isLts", "endSupport"}, arguments={"orderParameterName"="order"})
 *
 * @ORM\Entity(repositoryClass=VersionRepository::class)
 */
class Version
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isLts;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endSupport;

    /**
     * @ORM\ManyToOne(targetEntity=Techno::class, inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $techno;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getIsLts(): ?bool
    {
        return $this->isLts;
    }

    public function setIsLts(?bool $isLts): self
    {
        $this->isLts = $isLts;

        return $this;
    }

    public function getEndSupport(): ?\DateTimeInterface
    {
        return $this->endSupport;
    }

    public function setEndSupport(?\DateTimeInterface $endSupport): self
    {
        $this->endSupport = $endSupport;

        return $this;
    }

    public function getTechno(): ?Techno
    {
        return $this->techno;
    }

    public function setTechno(?Techno $techno): self
    {
        $this->techno = $techno;

        return $this;
    }

    public function getTechnoVersionName(): ?string
    {
        return $this->techno->getName() . ' ' . $this->version;
    }
}