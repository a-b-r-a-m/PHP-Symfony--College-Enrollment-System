<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StudentType extends AbstractType  //zapravo niko nebi triba uopce moc minjat ikoga, samo lozinku, i upise
{                                       // ni brisat, to sve zakomentirat na kraju
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class)   //ili null?
            ->add('password', PasswordType::class)    //to negdi posebno changepassword student sam sebi, ovo mentor
            //->add('role', TextType::class)
            ->add('role', ChoiceType::class, [
                'choices'  => [
                    'student' => 'student',
                    'mentor' => 'mentor',
                ],
            ])                                              //da je stavit ovisno jel uredujes ili pravis novog
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