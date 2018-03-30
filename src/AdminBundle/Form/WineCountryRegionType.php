<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WineCountryRegionType extends AbstractType
{
    protected $_languageHelper;

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

        /**$builder->add('mainImageFile', VichImageType::class, [
        'allow_delete' => false,
        //'required'      => false,
        'label' => 'lbl.main_image'
        ]); **/

        $builder->add('wineCountry', EntityType::class, [
            'class'    => 'AdminBundle\Entity\WineCountry',
            'choices' => $options['wineCountryRepo']->getAll(),
            'expanded' => false,
            'multiple' => false,
            'choice_label' => 'translations[pl].title',
            'placeholder'  => '--- Wybierz Kraj ---',
            'empty_data'   => '',
            'label' => 'Kraj',
        ]);

        
        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'lbl_title'
                ],
                /**
                'descriptionShort' => [
                'attr' => [
                'class' => '',
                'rows' => 5
                ],
                'label' => 'lbl.descriptionShortContent'
                ],
                'description' => [
                'attr' => ['class' => 'ckeditor'],
                'label' => 'lbl.description'
                ]
                 **/
            ],
            'exclude_fields' => ['slug', 'description']
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AdminBundle\Entity\WineCountryRegion',
            'wineCountryRepo' => null
        ));
    }
}
