<?php

namespace AppBundle\Form;

use AdminBundle\Form\UserProfileType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userGroup', EntityType::class, [
                'class' => 'AdminBundle\Entity\UserGroup',
                'multiple' => false,
                'expanded' => true,
                'choice_label' => 'title',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('ug')
                        ->where('ug.role = :role_organizer')
                        ->orWhere('ug.role = :role_autor')
                        ->setParameter(':role_organizer', 'ROLE_ORGANIZER')
                        ->setParameter(':role_autor', 'ROLE_AUTOR');
                },
                'required' => true
            ])
            
            ->add('userType', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'lbl.company_type' => 1,
                    'lbl.person_type' => 2,
                ]
            ])
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'lbl.password',
                ],
                'second_options'=> [
                    'label' => 'lbl.password_repeat'
                ]
            ])
            ->add('email', EmailType::class)
            ->add('userProfile', UserProfileType::class)

            ->add('isRegulationsAccepted', CheckboxType::class, [
                'mapped' => false,
                //'label' => 'lbl.isRegistrationRegulationsAccepted',
                'constraints' => [
                    new NotBlank([
                        'message' => 'valid.isRegistrationRegulationsAccepted'
                    ])
                ]
            ])
            ->add('isDataProcessingAccepted', CheckboxType::class, [
                'mapped' => false,
                'label' => 'lbl.isDataProcessingAccepted',
                'constraints' => [
                    new NotBlank([
                        'message' => 'valid.isDataProcessingAccepted'
                    ])
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\User'
        ));
    }
}
