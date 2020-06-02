<?php

namespace App\Domain\Helper;

use phpDocumentor\Reflection\Types\Mixed_;
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

    /**
     * @return mixed
     */
    public function getFlashMessageCreate()
    {
        return $this->flash->add(
            "bg-success",
            "L'élément a bien été créer !"
        );
    }

    /**
     * @return mixed
     */
    public function getFlashMessageUpdate()
    {
        return $this->flash->add(
            "bg-warning",
            "L'élément a bien été modifier !"
        );
    }

    /**
     * @return mixed
     */
    public function getFlashMessageDelete()
    {
        return $this->flash->add(
            "bg-danger",
            "L'élément a bien été supprimer !"
        );
    }
}
