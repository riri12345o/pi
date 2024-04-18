<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Prenom',
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Email User',
            ])
            ->add('password', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Password',
            ])
            ->add('roles', ChoiceType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'choices' => [
                    'Client' => 'client',
                    'Administrateur' => 'administrateur',
                ]
            ])
            ->add('cin', IntegerType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'cin',
            ])
            ->add('region', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Region',
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Ville',
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Adresse',
            ])
            ->add('isactive', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Active',
            ])
            ->add('isVerified', CheckboxType::class, [
                'label' => 'Verified',
            ])
            ->add('photo',FileType ::class,[
                'attr' => ['class' => 'form-control form-control-user'],
                'required'=>false,
                 'mapped'=>false,
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-user btn-block mt-4'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
