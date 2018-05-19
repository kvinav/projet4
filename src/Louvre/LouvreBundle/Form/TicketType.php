<?php

namespace Louvre\LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',       TextType::class, array(
                'label' => 'Nom',
                'attr' => array(
                    'class' => 'form-control',

                    ),
            ))
            ->add('surname',    TextType::class, array(
                'label' => 'Prénom',
                'attr' => array(
                    'class' => 'form-control',

                ),
            ))
            ->add('country',    CountryType::class, array(
                'label' => 'Pays',
                'attr' => array(
                    'class' => 'form-control',

                ),

            ))
            ->add('dateOfBirth',BirthdayType::class, array(
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'placeholder'=> 'Date de naissance',
                'attr' => array(
                    'class' => 'form-control',

                ),
            ))
            ->add('discount',   CheckboxType::class, array(
                'label'    => 'Tarif réduit ?',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',

                ),
                ));


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\LouvreBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_louvrebundle_ticket';
    }


}
