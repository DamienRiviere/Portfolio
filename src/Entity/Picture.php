<?php

namespace App\Entity;

use App\Domain\Project\ProjectDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
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
     * @ORM\OneToOne(targetEntity="App\Entity\Project", mappedBy="picture", cascade={"persist", "remove"})
     * @var Project
     */
    private $project;

    public static function create(string $newFileName, ProjectDTO $projectDto, Project $project): Picture
    {
        $picture = new Picture();
        $picture
            ->setName($newFileName)
            ->setDescription($projectDto->getPictureDescription())
            ->setProject($project)
        ;

        return $picture;
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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        // set the owning side of the relation if necessary
        if ($project->getPicture() !== $this) {
            $project->setPicture($this);
        }

        return $this;
    }
}
