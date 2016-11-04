<?php

namespace ClientBundle\Form;

use ClientBundle\Entity\Booking;
use ClientBundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tovar', TextType::class, [
                'label' => 'Выберите товар'
            ])
        ;
    }

     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Booking'
        ));
    }
}
