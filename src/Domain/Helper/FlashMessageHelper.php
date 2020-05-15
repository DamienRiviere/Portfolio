<?php

namespace App\Domain\Helper;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class FlashMessageHelper
{

    /** @var FlashBagInterface */
    protected $flash;

    /**
     * FlashMessageHelper constructor.
     * @param FlashBagInterface $flash
     */
    public function __construct(FlashBagInterface $flash)
    {
        $this->flash = $flash;
    }

    public function getFlashMessageCreate()
    {
        return $this->flash->add(
            "bg-success",
            "L'élément a bien été créer !"
        );
    }

    public function getFlashMessageUpdate()
    {
        return $this->flash->add(
            "bg-warning",
            "L'élément a bien été modifier !"
        );
    }

    public function getFlashMessageDelete()
    {
        return $this->flash->add(
            "bg-danger",
            "L'élément a bien été supprimer !"
        );
    }
}
