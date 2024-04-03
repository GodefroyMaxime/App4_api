<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Seniorities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SenioritiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profileStartDate', null, [
                'widget' => 'single_text',
            ])
            ->add('level1')
            ->add('level2')
            ->add('level3')
            ->add('level4')
            ->add('level5')
            ->add('level6')
            ->add('level7')
            ->add('level8')
            ->add('level9')
            ->add('level10')
            ->add('managementLevel')
            ->add('managementChain')
            ->add('seniority')
            ->add('positionId')
            ->add('active')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seniorities::class,
        ]);
    }
}
