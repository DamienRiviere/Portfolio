<?php

namespace App\Domain\Project;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @Assert\File(
     *     maxSize = "3000k",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Le format de l'image doit être du JPEG, JPG ou PNG !"
     * )
     * @var UploadedFile
     */
    protected $picture;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Vous devez entrer une description pour l'image"
     * )
     */
    protected $pictureDescription;

    /** @var string */
    protected $github;

    /** @var string */
    protected $link;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection
     */
    public function getTechnology()
    {
        return $this->technology;
    }

    /**
     * @param ArrayCollection $technology
     */
    public function setTechnology(ArrayCollection $technology): void
    {
        $this->technology = $technology;
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
     */
    public function setNote(string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return UploadedFile|null
     */
    public function getPicture(): ?UploadedFile
    {
        return $this->picture;
    }

    public function setPicture(UploadedFile $picture): void
    {
        $this->picture = $picture;
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
     */
    public function setPictureDescription(string $pictureDescription): void
    {
        $this->pictureDescription = $pictureDescription;
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
     */
    public function setGithub(string $github): void
    {
        $this->github = $github;
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
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }
}
