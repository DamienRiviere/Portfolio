<?php

namespace App\Entity;

use App\Domain\Technology\TechnologyDTO;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="technology")
     * @var Collection
     */
    private $project;

    public function __construct()
    {
        $this->project = new ArrayCollection();
    }

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

    public static function update(TechnologyDTO $dto, Technology $technology): Technology
    {
        $technology
            ->setName($dto->getName())
            ->setSlug($dto->getSlug())
        ;

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

    /**
     * @return Collection|Project[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Project $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
            $project->addTechnology($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->project->contains($project)) {
            $this->project->removeElement($project);
            $project->removeTechnology($this);
        }

        return $this;
    }
}
