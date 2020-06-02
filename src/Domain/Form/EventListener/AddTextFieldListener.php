<?php

namespace App\Domain\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddTextFieldListener implements EventSubscriberInterface
{

    /** @var RequestStack */
    protected $request;

    /**
     * AddTextFieldListener constructor.
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => "onPreSetData"
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        $route = $this->request->getCurrentRequest()->attributes->get("_route");

        if ($route === "admin_project_new") {
            $form
                ->add(
                    'picture',
                    FileType::class,
                    [
                        'label' => "Image du projet",
                        'required' => false,
                        'attr' => [
                            'placeholder' => 'Image du projet ...'
                        ],
                        'constraints' => [new File([
                            'maxSize' => "3000k",
                            'mimeTypes' => ["image/jpeg", "image/jpg", "image/png"],
                            'mimeTypesMessage' => "Le format de l'image doit être du JPEG, JPG ou PNG !"
                        ])]
                    ]
                )
                ->add(
                    'pictureDescription',
                    TextType::class,
                    [
                        'label' => 'Description de l\'image du projet',
                        'attr' => [
                            'placeholder' => 'Écrivez une description de l\'image du projet ...'
                        ],
                        'constraints' => [new NotBlank([
                            'message' => "Vous devez entrer une description pour l'image"
                        ])]
                    ]
                )
            ;
        }
    }
}
