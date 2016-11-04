<?php

namespace ClientBundle\Form;

use AppBundle\Form\Type\AppCollectionType;
use ClientBundle\Entity\Passport\Passport;
use ClientBundle\Entity\Person;
use ClientBundle\Form\BookingType;
use ClientBundle\EventListener\PersonEmployFormSubscriber;
use ClientBundle\EventListener\PersonPassportFormSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('passportType', ChoiceType::class, [
                'label' => 'Гражданство',
                'choices' => Passport::getTypes(),
                'mapped' => false,
            ])
            ->add('documents', AppCollectionType::class, [
                'type' => DocumentType::class,
                'label' => 'Дополнительные документы',
                'allow_add' => true,
                'allow_delete'=> true,
                'button_add_label' => 'Добавить',
                'button_delete_label' => '',
                'mapped' => true
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Ваша фотография'
            ])
            ->add('address', TextType::class, [
                'label' => 'Фактический адрес проживания',
            ])
            ->add('homePhone', TextType::class, [
                'label' => 'Домашний телефон',
                'required' => false
            ])
            ->add('mobilePhone', TextType::class, [
                'label' => 'Мобильный телефон',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('url', UrlType::class, [
                'label' => 'Веб-сайт',
                'required' => false
            ])
            ->add('socialProfiles', AppCollectionType::class, [
                'type' => SocialProfileType::class,
                'label' => 'Профили соц сетей',
                'allow_add' => true,
                'allow_delete'=> true,
                'button_add_label' => 'Добавить',
                'button_delete_label' => '',
                'mapped' => true,
                'by_reference' => false
            ])
            ->add('bookings', CollectionType::class, [
                 'type' => BookingType::class,
                 'by_reference' => false
            ])
            // ->add('referrers', EntityType::class, array(
            //     'label' => 'Откуда вы узнали о нас',
            //     'class' => 'ClientBundle\Entity\Referrer',
            //     'multiple' => true,
            //     'expanded' => true
            // ))
            ->add('friends', TextType::class, [
                'label' => 'Кто из наших клиентов может вас по рекомендовать',
            ])
            ->add('accept', CheckboxType::class, [
                'label' => 'Я согласен на обработку и хранение персональных данных',
                'required' => true,
                'mapped' => false
            ])
            ->add('employmentType', ChoiceType::class, [
                'choices' => Person::getEmployTypes(),
                'label' => 'Тип занятости'
            ])
            ->add('employmentNewType', ChoiceType::class, [
                'placeholder' => 'Выберите откуда о нас узнали',
                'choices' => 
                [
                    'Интернет' => [
                        'Социальная сеть' => 'Социальная сеть',
                        'Yandex/Google' => 'Yandex/Google',
                    ],
                    'Промо-мероприятия' => [
                        'Городской фестиваль' => 'Городской фестиваль',
                        'Кинофестиваль' => 'Кинофестиваль'
                    ],
                    'Рекомендация' => [
                        'Друг' => 'Друг',
                        'Наш партнёр' => 'Наш партнёр',
                        'Учебное заведение' => 'Учебное заведение',
                        'Работа' => 'Работа'
                    ],
                    'Другое' => 'Другое'
                ],
                'label' => 'Откуда узнали',
                'required' => true,
            ])
            ->add('employmentNewDetails', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'other-form'
                ],
                'required' => false
            ])
        ;
        $builder->get('employmentType')->addEventSubscriber(new PersonEmployFormSubscriber());
        $builder->get('passportType')->addEventSubscriber(new PersonPassportFormSubscriber());
        $builder->get('friends')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Person'
        ));
    }

    public function getBlockPrefix()
    {
        return 'client_bundle_person_form';
    }
}
