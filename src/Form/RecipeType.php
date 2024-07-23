<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('time')
            ->add('people')
            ->add('difficulty', ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5'
                ]
            ])
            ->add('step', TextType::class, [
                'label' => 'Step',
                'required' => true
            ])
            ->add('price')
            ->add('favorite')
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...));
    }

    public function autoSlug(PreSubmitEvent $event)
    {
        $data = $event->getData();
        if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($data['name'])->lower();
            $data['slug']=$slug;

            $event->setData($data);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}