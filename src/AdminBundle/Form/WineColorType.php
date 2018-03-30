<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WineColorType extends AbstractType
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
            'data_class' => 'AdminBundle\Entity\WineColor'
        ));
    }
}
