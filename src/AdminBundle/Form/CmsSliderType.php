<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CmsSliderType extends AbstractType
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
            $form = $event->getForm();
            //Only for new record
            if (!$cmsSlider || null === $cmsSlider->getId()) {
                $this->isNew = true;
            }
        });


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            /** @var $cmsArticle CmsArticle */
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

        $builder->add('imageFile', FileType::class, [
            'required' => true,
            'label' => 'imageFile'
        ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\CmsSlider'
        ));
    }
}
