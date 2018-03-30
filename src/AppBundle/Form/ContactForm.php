<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 2])
            ]
        ]);
        
        $builder->add('surname', TextType::class, [
        ]);

        $builder->add('phone', TextType::class, [
        ]);
        
        $builder->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank(),
                new Email(['checkHost' => true]),
                new Length(['min' => 2])
            ]
        ]);

        $builder->add('subject', TextType::class, [
            'label' => 'Temat',
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 2])
            ]
        ]);

        $builder->add('body', TextareaType::class, [
           'label' => 'Wiadomość',
           'constraints' => [
               new NotBlank(),
               new Length(['min' => 5])
           ]
        ]);
        
        $builder->add('code', RepeatedType::class, [
            //'invalid_message' => 'validation_code',
            'options' => array(
                'attr' => array('class' => '')
            ),
            'label' => 'Przepisz kod',
            'required' => true,
            'first_options'  => [
                'attr' => [
                    'readonly' => 'readonly',
                    'value'    => substr(uniqid(), -5)
                ],
                'label' => 'Kod',
                'error_bubbling' => true,
            ],
            'second_options' => [
                'label' => 'Przepisz kod',
                'error_bubbling' => true
            ],
            'first_name'  => 'code_first',
            'second_name' => 'code_repeat'
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false,
        ));
    }
}
