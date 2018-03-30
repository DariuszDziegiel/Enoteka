<?php

namespace RsBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RsConfigType extends AbstractType
{
    private $_languageHelper;

    public function __construct(LanguageHelper $languageHelper)
    {
        $this->_languageHelper = $languageHelper;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'lbl.object_title'
                ],
                'description' => [
                    'attr' => ['class' => 'ckeditor'],
                    'label' => 'lbl.description'
                ],
                'descriptionRegulations' => [
                    'attr' => ['class' => 'ckeditor'],
                    'label' => 'lbl.description_regulations'
                ],
                'descriptionReservationRegulations'=> [
                    'attr' => ['class' => 'ckeditor'],
                    'label' => 'lbl.description_reservation_regulations'
                ]
            ],
            'exclude_fields' => ['slug']
        ]);

        $builder
            ->add('city', TextType::class, [

            ])
            ->add('street')
            ->add('zip', TextType::class, [])
            ->add('country', CountryType::class, [
                'preferred_choices' => [
                    'Polska' => 'PL'
                ]
            ])
            ->add('email', EmailType::class)
            ->add('phone')
            ->add('cellPhone')
            ->add('companyTitleInvoice')
            ->add('nipInvoice')
            ->add('streetInvoice')
            ->add('cityInvoice')
            ->add('zipInvoice')
            ->add('countryInvoice', CountryType::class, [
                'preferred_choices' => [
                    'Polska' => 'PL'
                ]
            ])
            ->add('emailInvoice', EmailType::class)
            ->add('lat')
            ->add('lng')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RsBundle\Entity\RsConfig'
        ));
    }
}
