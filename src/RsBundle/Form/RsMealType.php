<?php

namespace RsBundle\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RsMealType extends AbstractType
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
        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'lbl_title'
                ],
                'description' => [
                    'attr' => ['class' => 'ckeditor'],
                    'label' => 'lbl.description'
                ]
            ],
            'exclude_fields' => ['slug']
        ]);

        $builder
            ->add('isActive', CheckboxType::class, [
            ])
        ;
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RsBundle\Entity\RsMeal',
            //'cascade'    => true
        ));
    }
}
