<?php

namespace Louvre\LouvreBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVisit',  DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/mm/yy',
            ))
            ->add('type',       ChoiceType::class, array(
                'choices' => $this->journeyType(),
            ))
            ->add('email',      EmailType::class)
            ->add('tickets',     CollectionType::class, array(
                'entry_type' => TicketType::class
            ))
            ->add('save',       SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\LouvreBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_louvrebundle_booking';
    }

    public function journeyType()
    {

        return array(
            'Journée' => 'Journée',
            'Demi-journée' => 'Demi-journée',
        );
    }


}
