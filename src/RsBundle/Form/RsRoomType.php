<?php

namespace RsBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Doctrine\ORM\EntityRepository;
use RsBundle\Entity\RsRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RsRoomType extends AbstractType
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
            'label' => 'lbl.main_image'
        ]);


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
            'exclude_fields' => ['slug']
        ]);
        
        /**
         $builder->add('roomNumber', TextType::class);
        $builder->add('floor', ChoiceType::class, [
           'choices' => [
               'lbl.parter'  => 0,
               '1 piętro'    => 1,
               '2 piętro'    => 2,
               '3 piętro'    => 3,
               '4 piętro'    => 4,
               '5 piętro'    => 5,
               '6 piętro'    => 6,
               '7 piętro'    => 7,
               '8 piętro'    => 8,
               '9 piętro'    => 9,
               '10 piętro'   => 10,
               '11 piętro'   => 11,
               '12 piętro'   => 12,
               '13 piętro'   => 13,
               '14 piętro'   => 14,
               '15 piętro'   => 15
           ]
        ]);
        **/
        
        $builder
            ->add('maxAdults', ChoiceType::class, [
                'choices' => array_combine(range(0, 10, 1), range(0, 10, 1)),
                'attr' => ['class' => 'number']
            ])
            ->add('maxKids', ChoiceType::class, [
                'choices' => array_combine(range(0, 10, 1), range(0, 10, 1)),
                'attr' => ['class' => 'number']
            ]);

        $builder->add('area', NumberType::class, [
            'attr' => ['class' => 'number']
        ]);


        //BEDS
        $builder->add('singleBeds', ChoiceType::class, [
            'choices' => array_combine(range(0, 10, 1), range(0, 10, 1)),
            'attr' => ['class' => 'number']
        ]);
        $builder->add('doubleBeds', ChoiceType::class, [
            'choices' => array_combine(range(0, 10, 1), range(0, 10, 1)),
            'attr' => ['class' => 'number']
        ]);
        $builder->add('additionalBeds', ChoiceType::class, [
            'choices' => array_combine(range(0, 10, 1), range(0, 10, 1)),
            'attr' => ['class' => 'number']
        ]);

        //Facilities
        $builder
            ->add('facilityItems', EntityType::class, [
                'class'    => 'RsBundle\Entity\RsFacilityItem',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'title',
                'choice_value' => 'id'
            ]);


    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RsBundle\Entity\RsRoom'
        ));
    }
}
