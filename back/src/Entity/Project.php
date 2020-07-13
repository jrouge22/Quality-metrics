<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Project
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity=Version::class)
     */
    private $version;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=ProjectMetric::class, mappedBy="project", orphanRemoval=true)
     */
    private $projectMetrics;

    public function __construct()
    {
        $this->version = new ArrayCollection();
        $this->projectMetrics = new ArrayCollection();

        $this->createdAt = new \DateTime('now');
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Version[]
     */
    public function getVersion(): Collection
    {
        return $this->version;
    }

    public function addVersion(Version $version): self
    {
        if (!$this->version->contains($version)) {
            $this->version[] = $version;
        }

        return $this;
    }

    public function removeVersion(Version $version): self
    {
        if ($this->version->contains($version)) {
            $this->version->removeElement($version);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection|ProjectMetric[]
     */
    public function getProjectMetrics(): Collection
    {
        return $this->projectMetrics;
    }

    public function addProjectMetric(ProjectMetric $projectMetric): self
    {
        if (!$this->projectMetrics->contains($projectMetric)) {
            $this->projectMetrics[] = $projectMetric;
            $projectMetric->setProject($this);
        }

        return $this;
    }

    public function removeProjectMetric(ProjectMetric $projectMetric): self
    {
        if ($this->projectMetrics->contains($projectMetric)) {
            $this->projectMetrics->removeElement($projectMetric);
            // set the owning side to null (unless already changed)
            if ($projectMetric->getProject() === $this) {
                $projectMetric->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}
