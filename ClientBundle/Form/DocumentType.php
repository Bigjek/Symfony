<?php

namespace ClientBundle\Form;

use ClientBundle\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => Document::getTypes(),
                'label' => 'Выберите документ'
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Загрузите фаил'
            ])
            ->add('comments', TextType::class, [
                
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ваши комментарии'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Document'
        ));
    }
}
