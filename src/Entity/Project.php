<?php

namespace App\Entity;

use App\Domain\Project\ProjectDTO;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Project
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
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $github;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $link;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Technology", inversedBy="project")
     * @var Collection
     */
    private $technology;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Picture", inversedBy="project", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @var Picture
     */
    private $picture;

    public static function create(ProjectDTO $projectDTO): Project
    {
        $project = new Project();
        $project
            ->setName($projectDTO->getName())
            ->setDescription($projectDTO->getDescription())
            ->setNote($projectDTO->getNote())
            ->setGithub($projectDTO->getGithub())
            ->setLink($projectDTO->getLink())
            ->setTechnology($projectDTO->getTechnology())
        ;

        return $project;
    }

    public static function update(ProjectDTO $projectDTO, Project $project): Project
    {
        $project
            ->setName($projectDTO->getName())
            ->setDescription($projectDTO->getDescription())
            ->setNote($projectDTO->getNote())
            ->setGithub($projectDTO->getGithub())
            ->setLink($projectDTO->getLink())
        ;

        foreach ($projectDTO->getTechnology() as $technology) {
            $project->addTechnology($technology);
        }

        return $project;
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

    public function __construct()
    {
        $this->technology = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

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

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTechnology(): Collection
    {
        return $this->technology;
    }

    public function setTechnology(Collection $technology): self
    {
        foreach ($technology->getValues() as $techno) {
            $this->technology[] = $techno;
        }

        return $this;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technology->contains($technology)) {
            $this->technology[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        if ($this->technology->contains($technology)) {
            $this->technology->removeElement($technology);
        }

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
