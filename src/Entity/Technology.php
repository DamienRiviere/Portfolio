<?php

namespace App\Entity;

use App\Domain\Technology\TechnologyDTO;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnologyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Technology
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $slug;

    /**
     * @param TechnologyDTO $dto
     * @return Technology
     */
    public static function create(TechnologyDTO $dto): Technology
    {
        $technology = new Technology();
        $technology->setName($dto->getName());

        return $technology;
    }

    /**
     * Initialize slug when a technology is created
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSlug(): void
    {
        $slugify = new Slugify();
        $this->setSlug($slugify->slugify($this->getName()));
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
