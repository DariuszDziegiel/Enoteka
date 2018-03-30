<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class)
            ->add('companyNip', TextType::class)
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('zip', TextType::class)
            ->add('phone', TextType::class)
            ->add('isEmailMarketingAgreement', CheckboxType::class, [
                'label' => 'lbl.isEmailMarketingAgreement'
            ])
            ->add('isEmailMarketingDataProcessingAgreement', CheckboxType::class, [
                'label' => 'lbl.isEmailMarketingDataProcessingAgreement'
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\UserProfile'
        ));
    }
}
