<?php

namespace ClientBundle\Form\Passport;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RussianPassportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Имя',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Фамилия',
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'Отчество',
            ])
            ->add('birthDate', BirthdayType::class, [
                'label' => 'Дата рождения',
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy'
            ])
            ->add('passportSeries', TextType::class, [
                'label' => 'Серия паспорта',
            ])
            ->add('passportIssuedBy', TextType::class, [
                'label' => 'Пасспорт выдан',
            ])
            ->add('passportIssuedDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Дата выдачи',
                'format' => 'dd.MM.yyyy'
            ])
            ->add('registrationAddress', TextType::class, [
                'label' => 'Адрес регистрации',
            ])
            ->add('mainImageFile', VichImageType::class, [
                'label' => 'Страница с портретом'
            ])
            ->add('addressImageFile', VichImageType::class, [
                'label' => 'Страница с регистрацией'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Passport\RussianPassport'
        ));
    }

    public function getBlockPrefix()
    {
        return 'client_bundle_russian_passport_type';
    }
}
