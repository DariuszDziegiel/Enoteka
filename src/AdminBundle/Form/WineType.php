<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AdminBundle\Entity\Wine;
use AdminBundle\Entity\WineCountry;
use AdminBundle\Entity\WineCountryRegion;
use AdminBundle\Entity\WineCountrySubregion;
use AppBundle\Utils\LanguageHelper;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WineType extends AbstractType
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
        
        $builder->add('title', TextType::class, [
            'label' => 'Nazwa'
        ]);

        $builder->add('isActive', CheckboxType::class, [
            'label' => 'Wino aktywne'
        ]);

        $builder->add('year', IntegerType::class, [
            'label'    => 'Rocznik',
            'required' => false
        ]);
        
        $builder->add('price2comma5cl', TextType::class, [
            'label'    => '2,5 cl',
            'required' => false,
        ] );

        $builder->add('price5cl', TextType::class, [
            'label'    => '5 cl',
            'required' => false,
        ] );

        $builder->add('price10cl', TextType::class, [
            'label'    => '10 cl',
            'required' => false
        ] );

        $builder->add('price75cl', TextType::class, [
            'label'    => '75 cl',
            'required' => false
        ] );
        
        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'description' => [
                    'attr' => [
                        'class' => 'ckeditor'
                    ],
                    'label' => 'lbl.description'
                ]
                /**
                'descriptionShort' => [
                'attr' => [
                'class' => '',
                'rows' => 5
                ],
                'label' => 'lbl.descriptionShortContent'
                ],
                
                 **/
            ],
            'exclude_fields' => ['slug'],
        ]);

        $builder->add('wineCountry', EntityType::class, [
            'class'        => 'AdminBundle\Entity\WineCountry',
            'choice_label' => 'translations[pl].title',
            'empty_data'   => null,
            'placeholder'  => '--- Wybierz kraj ---',
            'label'        => 'Kraj',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('wico')
                    ->join('wico.translations', 'trans')
                    ->where('trans.locale = :locale')
                    ->setParameter('locale', 'pl')
                    ->orderBy('trans.title');
            }
        ]);

        //Wine country region
        $formModifier = function (FormInterface $form, $wineCountry) {
            $countryRegions = null === $wineCountry ? array() : $wineCountry->getWineCountryRegions();
            $form->add('wineCountryRegion', EntityType::class, [
                'class'        => WineCountryRegion::class,
                'label'        => 'Region',
                'empty_data'   => null,
                'placeholder'  => '--- Wybierz Region ---',
                'choices'      => $countryRegions,
                'choice_label' => 'translations[pl].title',
                'required'     =>  false
            ]);
        };

        $builder->addEventListener(
          FormEvents::PRE_SET_DATA,
          function(FormEvent $event) use ($formModifier) {
              /** @var Wine $data */
              $data = $event->getData();
              $formModifier($event->getForm(), $data->getWineCountry());
          }
        );

        $builder->get('wineCountry')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $wineCountry = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $wineCountry);
            }
        );

        //Wine country SUBREGION dynamic Select

        $wineCountrySubregionModifier = function (FormInterface $form,  $wineCountryRegion) {
            /** @var WineCountryRegion  $wineCountryRegion */
            $countrySubRegions = null === $wineCountryRegion ? array() : $wineCountryRegion->getWineCountrySubregions();
            $form->add('wineCountrySubregion', EntityType::class, [
                'class'        =>  WineCountrySubregion::class,
                'label'        => 'Podregion',
                'empty_data'   => null,
                'placeholder'  => ' --- Wybierz Podregion --- ',
                'choices'      => $countrySubRegions,
                'choice_label' => 'title',
                'required'     => false
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($wineCountrySubregionModifier) {
                /** @var Wine $data */
                $data = $event->getData();
                $wineCountrySubregionModifier($event->getForm(), $data->getWineCountryRegion());
            }
        );


        /**$builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($wineCountrySubregionModifier) {
                $wineCountryRegion = $event->getForm()->get('wineCountryRegion')->getData();
                $wineCountrySubregionModifier($event->getForm(), $wineCountryRegion);
            }
        );**/

        
       $builder->add('wineColor', EntityType::class, [
            'class'        => 'AdminBundle\Entity\WineColor',
            'choice_label' => 'translations[pl].title',
            'label'        => 'Kolor / Rodzaj',
            'empty_data'   => null,
            'placeholder'  => '--- Wybierz kolor ---'
        ]);

        $builder->add('wineMaturity', EntityType::class, [
            'class'        => 'AdminBundle\Entity\WineMaturity',
            'choice_label' => 'translations[pl].title',
            'label'        => 'Wytrawność',
            'empty_data'   => null,
            'placeholder'  => '--- Wybierz wytrawność ---',
            'required'     => false
        ]);


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Wine',
            'auto_initialize' => false
        ));
    }
}
