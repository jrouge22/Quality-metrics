<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\MetricRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"},
 *     attributes={"order"={"name"}}
 * )
 *
 * @ApiFilter(OrderFilter::class, properties={"name"}, arguments={"orderParameterName"="order"})
 * @ORM\Entity(repositoryClass=MetricRepository::class)
 */
class Metric
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $levelOk;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $levelNice;

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

    public function getLevelOk(): ?int
    {
        return $this->levelOk;
    }

    public function setLevelOk(?int $levelOk): self
    {
        $this->levelOk = $levelOk;

        return $this;
    }

    public function getLevelNice(): ?int
    {
        return $this->levelNice;
    }

    public function setLevelNice(?int $levelNice): self
    {
        $this->levelNice = $levelNice;

        return $this;
    }
}
