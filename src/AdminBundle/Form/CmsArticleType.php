<?php

namespace AdminBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AdminBundle\Entity\CmsArticle;
use AppBundle\Utils\LanguageHelper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class CmsArticleType extends AbstractType
{
    protected $languageHelper;
    protected $categoryTitleCode;
    protected $categoryId;
    protected $isNew = false;

    public function __construct(LanguageHelper $languageHelper)
    {
        $this->languageHelper= $languageHelper;
    }

    public function prepareParameters($options) {
        $categoriesMap = [
            'news'     => 1,
            'events'   => 2,
            'articles' => 3
        ];
        $this->categoryTitleCode = $options['category'];
        $this->categoryId        = $categoriesMap[$options['category']];
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$this->prepareParameters($options);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            /** @var $cmsArticle CmsArticle */
            $cmsArticle = $event->getData();
            //$form = $event->getForm();
            //only for new record
            if (!$cmsArticle || !$cmsArticle->getId()){
                $this->isNew = true;
            }
        });

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            /** @var $cmsArticle CmsArticle */
            $cmsArticle = $event->getData();
            $form = $event->getForm();
            $isActiveOptions = [
                'label' => 'lbl.is_active'
            ];

            if ($this->isNew){
                $isActiveOptions['data'] = true;
            }
            $form
                ->add('isActive', CheckboxType::class, $isActiveOptions)
            ;
        });

        $builder->add('date', DateType::class, [
            'attr'   => [
                'class' => 'date',
                'type'  => 'text'
            ],
            'label'  => 'Data wydarzenia',
            'widget' => 'single_text',
            'html5'  => false
        ]);

        $builder->add('mainImageFile', FileType::class, [
            'required' => false
        ]);

        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'lbl_title'
                ],
                'description' => [
                    'attr' => ['class' => 'ckeditor'],
                    'label' => 'lbl.content'
                ]
            ],
            'exclude_fields' => ['slug']
        ]);

        /**
        $builder->add('categories', EntityType::class, [
            'class'    => 'AdminBundle\Entity\CmsArticleCategory',
            'multiple' => true,
            'expanded' => true,
            'choice_label' => 'title',
            'choice_value' => 'id',
            'required' => true,
            'empty_data'=> [$this->categoryId]
        ]);
         **/


    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\CmsArticle'
        ));
    }
}
