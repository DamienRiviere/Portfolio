<?php

namespace App\Domain\Helper;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormHelper
 * @package App\Domain\Helper
 */
class FormHelper
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /**
     * FormHelper constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param string $classType
     * @param string|null $classDto
     * @param null $object
     * @return FormInterface
     */
    public function getFormType(Request $request, string $classType, ?string $classDto, $object = null): FormInterface
    {
        $dto = null;
        if ($request->attributes->get('slug')) {
            $dto = $classDto::updateToDto($object);
        }

        return $this->formFactory->create($classType, $dto)
                                 ->handleRequest($request);
    }
}
