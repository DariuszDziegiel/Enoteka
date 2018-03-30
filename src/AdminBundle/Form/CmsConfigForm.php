<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AdminBundle\Entity\CmsConfig;
use AppBundle\Utils\LanguageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CmsConfigForm extends AbstractType
{

    private $languageHelper;

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
                /** @var CmsConfig $cmsConfig */
                $cmsConfig = $event->getData();
                $form = $event->getForm();

                if (!$cmsConfig->getIsHasImage()) {
                    return;
                }

                $form->add('imageFile', VichImageType::class, [
                    'allow_delete' => false,
                    //'required'      => false,
                    'label' => 'Obraz'
                ]);

            });


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            /** @var CmsConfig $cmsConfig */
            $cmsConfig = $event->getData();
            $form = $event->getForm();

            if (!$cmsConfig->getIsHasAttachment()) {
                return;
            }

            $form->add('attachmentFile', VichFileType::class, [
                'allow_delete' => false,
                //'required'     => true,
                'label' => 'Załącznik'
            ]);

        });
        

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
                /** @var CmsConfig $cmsConfig */
                $cmsConfig = $event->getData();
                $form = $event->getForm();

                if ($cmsConfig->getIsTranslatable() || $cmsConfig->getIsHasImage()) {
                    return;
                }

                $defaultOptions = [
                    'label' => $cmsConfig->getConfigTitle()
                ];

                switch ($cmsConfig->getConfigType()) {
                    case 'number':
                        $form->add('configValue', NumberType::class, array_merge([
                        ], $defaultOptions));
                        break;
                    case 'text':
                        $form->add('configValue', TextType::class, array_merge([
                        ], $defaultOptions));
                        break;
                    case 'textarea':
                        $form->add('configValue', TextareaType::class, array_merge([
                            'attr' => [
                                'rows' => 10
                            ],
                        ], $defaultOptions));
                        break;
                    case 'email':
                        $form->add('configValue', EmailType::class, array_merge([
                        ], $defaultOptions));
                        break;
                    default:
                        $form->add('configValue', TextType::class, array_merge([
                        ], $defaultOptions));
                }
            });


            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
                /** @var CmsConfig $cmsConfig */
                $cmsConfig = $event->getData();
                $form = $event->getForm();

                if (!$cmsConfig->getIsTranslatable()) {
                    return;
                }

                $form->add('translations', TranslationsType::class, [
                    'locales'   => $this->languageHelper->getActiveLocales(),
                    'fields'  => [
                        'configDescription' => [
                            'attr' => [
                                'class' => 'ckeditor',
                                'rows'  => 10
                            ],
                            'label' => $cmsConfig->getConfigTitle()
                        ]
                    ],
                    'exclude_fields' => ['slug', 'updatedAt', 'createdAt']
                ]);
            });

            $builder->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\CmsConfig'
        ));
    }
}
