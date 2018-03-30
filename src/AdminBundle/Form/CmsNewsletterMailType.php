<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsNewsletterMailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię i Nazwisko',
                'attr'  => [
                    'class' => 'newsletter-name'
                ],
                'label_attr' => [
                    'class' => 'newsletter-label'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr'  => [
                    'class' => 'newsletter-email'
                ],
                'label_attr' => [
                    'class' => 'newsletter-label'
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
            'data_class' => 'AdminBundle\Entity\CmsNewsletterMail'
        ));
    }
}
