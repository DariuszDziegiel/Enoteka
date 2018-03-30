<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

use AdminBundle\Entity\CmsStaticPage;
use AppBundle\Utils\LanguageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsStaticPageType extends AbstractType
{
    protected $isNew = false;
    private   $languageHelper;

    public function __construct(LanguageHelper $languageHelper)
    {
        $this->languageHelper = $languageHelper;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $cmsStaticPage = $event->getData();
            $form = $event->getForm();
            //Only for new record
            if (!$cmsStaticPage || null === $cmsStaticPage->getId()) {
                $this->isNew = true;
            }
        });


        //param only for new page
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $cmsStaticPage = $event->getData();
            $form = $event->getForm();
            //Only for new record
            if (!$cmsStaticPage || null === $cmsStaticPage->getId()) {
                $form->add('param', TextType::class);
            }
        });
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            /** @var $cmsStaticPage CmsStaticPage */
            $cmsStaticPage = $event->getData();
            $form = $event->getForm();

            //Translatable fields
            $translatableFields = [
                'title' => [
                    //'disabled' => !$this->isNew,
                    'label' => 'lbl_title'
                ]
            ];

            if ($cmsStaticPage->getIsHasSubtitle()) {
                $translatableFields['subTitle'] = [
                    'label' => 'lbl.subTitle'
                ];
            }

            if ($cmsStaticPage->getIsHasDescriptionShort()) {
                $translatableFields['descriptionShort'] = [
                    'attr' => [
                        'class' => '',
                        'rows' => 7
                    ],
                    'label' => 'Treść skrócona'
                ];
            }

            //Translatable fields
            $translatableFields['description'] = [
                'attr' => ['class' => 'ckeditor'],
                'label' => 'Treść'
            ];


            //Get SEO fields
            $descriptionShortField = $this->getDescriptionShort($cmsStaticPage);
            $seoFields = $this->getSeoFields($cmsStaticPage);

            $translatableFields = array_merge($translatableFields, $descriptionShortField, $seoFields);

            $form->add('translations', TranslationsType::class, [
                'locales'   => $this->languageHelper->getActiveLocales(),
                'fields'    => $translatableFields,
                'exclude_fields' => ['slug', 'title', 'seoTitle', 'seoKeywords', 'seoDescription', 'subTitle', 'descriptionShort']
            ]);
        });

        /**
         * mainImage field
         * */
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var $cmsStaticPage CmsStaticPage */
            $cmsStaticPage = $event->getData();
            $form = $event->getForm();
            if (!$cmsStaticPage || ($cmsStaticPage && $cmsStaticPage->getIsHasMainImage())) {
                $form->add('mainImageFile', FileType::class, [
                ]);
            }
        });
        
        /**
         * mainPageImage field
         * */
        /**
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $cmsStaticPage = $event->getData();
            $form = $event->getForm();
            if (!$cmsStaticPage || ($cmsStaticPage && $cmsStaticPage->getIsHasMainPageImage())) {
                $form->add('mainPageImageFile', FileType::class, [

                ]);
            }
        });
        **/

    }

    /**
     * Get Seo Fields if ON
     * @param CmsStaticPage|null $cmsStaticPage
     * @return array
     */
    public function getSeoFields(CmsStaticPage $cmsStaticPage = null) {
        if ($cmsStaticPage && $cmsStaticPage->getIsHasSeo()) {
            $translatableFields['seoTitle'] = [];
            $translatableFields['seoKeywords'] = [
                'attr' => ['rows' => 3]
            ];
            $translatableFields['seoDescription'] = [
                'attr' => ['rows' => 5]
            ];
            return $translatableFields;
        }
        return [];
    }


    /**
     * Get description Short field if ON
     * @param CmsStaticPage|null $cmsStaticPage
     * @return array
     */
    public function getDescriptionShort(CmsStaticPage $cmsStaticPage = null) {
        if ($cmsStaticPage && $cmsStaticPage->getIsHasDescriptionShort()) {
            $translatableFields['descriptionShort'] = [
                'attr'  => [
                    'rows' => 5
                ],
                'label' => 'lbl.descriptionShort'
            ];
            return $translatableFields;
        }
        return [];
    }





    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'  => 'AdminBundle\Entity\CmsStaticPage',
            'cascade'     => true
        ));
    }



}
