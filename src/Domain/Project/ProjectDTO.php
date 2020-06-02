<?php

namespace App\Domain\Project;

use App\Entity\Project;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectDTO
{
    
    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Vous devez entrer un nom"
     * )
     */
    protected $name;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Vous devez entrer une description"
     * )
     */
    protected $description;

    /**
     * @var ArrayCollection
     * @Assert\NotBlank(
     *     message="Vous devez choisir des technologies"
     * )
     */
    protected $technology;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Vous devez entrer une note"
     * )
     */
    protected $note;

    /**
     * @var UploadedFile
     */
    protected $picture;

    /**
     * @var string
     */
    protected $pictureDescription;

    /** @var string */
    protected $github;

    /** @var string */
    protected $link;

    public function updateToDto(Project $project): ProjectDTO
    {
        $dto = new ProjectDTO();
        $dto
            ->setName($project->getName())
            ->setDescription($project->getDescription())
            ->setTechnology($project->getTechnology())
            ->setNote($project->getNote())
            ->setLink($project->getLink())
            ->setGithub($project->getGithub())
        ;

        return $dto;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ProjectDTO
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ProjectDTO
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTechnology(): ?Collection
    {
        return $this->technology;
    }

    /**
     * @param Collection $technology
     * @return $this
     */
    public function setTechnology(Collection $technology): self
    {
        $this->technology = $technology;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return ProjectDTO
     */
    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getPicture(): UploadedFile
    {
        return $this->picture;
    }

    /**
     * @param UploadedFile $picture
     * @return $this
     */
    public function setPicture(UploadedFile $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return string
     */
    public function getPictureDescription(): ?string
    {
        return $this->pictureDescription;
    }

    /**
     * @param string $pictureDescription
     * @return ProjectDTO
     */
    public function setPictureDescription(string $pictureDescription): self
    {
        $this->pictureDescription = $pictureDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getGithub(): ?string
    {
        return $this->github;
    }

    /**
     * @param string $github
     * @return ProjectDTO
     */
    public function setGithub(string $github): self
    {
        $this->github = $github;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return ProjectDTO
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
