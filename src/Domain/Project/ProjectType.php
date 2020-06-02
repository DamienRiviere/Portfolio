<?php

namespace App\Domain\Project;

use App\Domain\Form\EventListener\AddTextFieldListener;
use App\Entity\Technology;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{

    /** @var RequestStack */
    protected $request;

    /**
     * ProjectType constructor.
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom du projet',
                    'attr' => [
                        'placeholder' => 'Écrivez le nom du projet ...'
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description du projet',
                    'attr' => [
                        'placeholder' => 'Écrivez la description du projet ...'
                    ]
                ]
            )
            ->add(
                'technology',
                EntityType::class,
                [
                    'class' => Technology::class,
                    'choice_label' => function (Technology $technology) {
                        return $technology->getName();
                    },
                    'label' => 'Technologies du projet',
                    'expanded' => true,
                    'multiple' => true,
                    'attr' => [
                        'class' => 'row col'
                    ],
                    'row_attr' => [
                        'class' => 'mr-3'
                    ]
                ]
            )
            ->add(
                'note',
                TextType::class,
                [
                    'label' => 'Note du projet',
                    'attr' => [
                        'placeholder' => 'Écrivez la note du projet ...'
                    ]
                ]
            )
            ->add(
                'github',
                TextType::class,
                [
                    'label' => 'Lien Github du projet',
                    'attr' => [
                        'placeholder' => 'Écrivez le lien Github du projet ...'
                    ]
                ]
            )
            ->add(
                'link',
                TextType::class,
                [
                    'label' => 'Lien du projet',
                    'attr' => [
                        'placeholder' => 'Écrivez lien du projet ...'
                    ]
                ]
            )
            ->addEventSubscriber(new AddTextFieldListener($this->request))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ProjectDTO::class
            ]
        );
    }
}
