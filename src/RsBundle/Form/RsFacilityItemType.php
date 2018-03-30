<?php

namespace RsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Utils\LanguageHelper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RsFacilityItemType extends AbstractType
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


        //default icon only for new facilities
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $rsFacilityItem = $event->getData();
            $form = $event->getForm();
            //Only for new record
            if (!$rsFacilityItem || null === $rsFacilityItem->getId()) {
                $form->add('iconDefault', TextType::class, [
                    'label' => 'lbl.iconDefault'
                ]);
            }
        });



        $builder->add('mainImageFile', VichImageType::class, [
            'allow_delete' => true,
            //'required'      => false,
            'label' => 'lbl.icon'
        ]);



        $builder->add('translations', TranslationsType::class, [
            'locales'   => $this->_languageHelper->getActiveLocales(),
            'fields'  => [
                'title' => [
                    'label' => 'lbl_title'
                ],
                /*'description' => [
                    'attr' => ['class' => 'ckeditor'],
                    'label' => 'lbl.description'
                ]*/
            ],
            'exclude_fields' => ['slug', 'description']
        ]);

        $builder
            ->add('isActive');
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RsBundle\Entity\RsFacilityItem'
        ));
    }
}
