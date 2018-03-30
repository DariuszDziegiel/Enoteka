<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CmsPageBackgroundType extends AbstractType
{
    protected $isNew = false;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $cmsSlider = $event->getData();
            //$form = $event->getForm();
            //Only for new record
            if (!$cmsSlider || null === $cmsSlider->getId()) {
                $this->isNew = true;
            }
        });

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $isActiveOptions = [
                'label' => 'lbl.is_active'
            ];
            //only for new record
            if ($this->isNew){
                $isActiveOptions['data'] = true;
            }
            $form
                ->add('isActive', CheckboxType::class, $isActiveOptions)
            ;
        });

        $builder->add('imageFile', VichImageType::class, [
            'label'         => 'imageFile',
            'allow_delete'  => false,
        ]);

        $builder->add('sort', IntegerType::class, [
            'label' => 'lbl.sort',
            'attr' => [
                'class' => 'number'
            ]
        ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\CmsPageBackground'
        ));
    }
}
