<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('agentName', TextType::class,
        [
            'empty_data' => '',
            'mapped' => false,
        ])
        ->add('faction', ChoiceType::class, [
            'choices' => [
                'COSMIC' => 'COSMIC',
            ],
            'mapped' => false,
        ])
        ->add('register', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
