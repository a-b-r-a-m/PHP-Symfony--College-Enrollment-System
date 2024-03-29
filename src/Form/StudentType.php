<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class)
            ->add('password', PasswordType::class)
            //->add('role', TextType::class)
            ->add('role', ChoiceType::class, [
                'choices'  => [
                    'student' => 'student',
                    'mentor' => 'mentor',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'redovan' => 'redovan',
                    'izvanredan' => 'izvanredan',
                    '' => ''
                ],
            ])
            //->add('status', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Student::class,
        ));
    }
}