<?php

namespace App\Domain\Technology;

use App\Entity\Technology;

class TechnologyDTO
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $slug;

    public function updateToDto(Technology $technology): TechnologyDTO
    {
        $dto = new TechnologyDTO();
        $dto
            ->setName($technology->getName())
            ->setSlug($technology->getSlug())
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
     * @return TechnologyDTO
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return TechnologyDTO
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
