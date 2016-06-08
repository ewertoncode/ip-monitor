<?php

namespace IPMonitor\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class IpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class,
                [
                    'label'=> 'Nome do equipamento:',
                    'attr' => [
                        'class' => 'form-control'
                    ]

                ])
            ->add('ip', TextType::class,
                [
                    'label'=> 'IP ou dominio:',
                    'attr' => [
                        'class' => 'form-control'
                    ]

                ])
            ->add('referencia', CheckboxType::class,
                [
                    'label'=> 'Referencia? ',
                    'required' => false

                ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IPMonitor\MonitorBundle\Entity\IP'
        ));
    }
}
