<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CmsPageType extends AbstractType
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

        $builder->add('isActive', CheckboxType::class, [
            'label' => 'Podkategoria aktywna'
        ]);

        $builder->add('mainImageFile', FileType::class, [
            'required' => false,
            'label'    => 'Zdjęcie'
        ]);

        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'Nazwa'
                ],
                'description' => [
                    'attr' => [
                        'class' => 'ckeditor'
                    ],
                    'label' => 'Treść'
                ]
            ],
            'exclude_fields' => ['slug']
        ]);


    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\CmsPage'
        ));
    }
}
