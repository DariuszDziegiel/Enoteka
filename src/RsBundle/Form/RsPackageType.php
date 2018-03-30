<?php

namespace RsBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\ChoiceList;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;

class RsPackageType extends AbstractType
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
        $builder
            ->add('isActive', CheckboxType::class);

        $builder->add('mainImageFile', VichImageType::class, [
            'allow_delete' => false,
            //'required'      => false,
            'label' => 'Obraz'
        ]);


        $builder->add('price', MoneyType::class, [
            'label'    => 'Cena',
            'currency' => 'PLN'
        ]);


        /**
         $builder->add('detailsImageFile', VichImageType::class, [
            'allow_delete' => true,
            //'required'      => false,
            'label' => 'Obraz szczegółów pakietu'
         ]);
         **/

        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'lbl_title'
                ],
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
            ],
            'exclude_fields' => ['slug', 'createdAt', 'updatedAt']
        ]);
        
        /**
        $builder
            ->add('minStayDays', ChoiceType::class, [
                'choices' => array_combine(array_merge(['Dowolna długość pobytu'], range(1, 10, 1)), array_merge([0],range(1, 10, 1))),
                'attr' => [
                    'class' => 'number'
                ],
                'placeholder' => 'Wybierz liczbę dni',
                'label'       => 'lbl.minStayDays'
            ]);
         **/
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RsBundle\Entity\RsPackage'
        ));
    }
}
