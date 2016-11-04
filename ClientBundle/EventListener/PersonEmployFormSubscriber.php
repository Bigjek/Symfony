<?php

namespace ClientBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PersonEmployFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => [

                ['employTypeUpdate', 9]
            ],
            FormEvents::PRE_SUBMIT => [

                ['employTypeUpdate', 9]
            ],
        );
    }

    public function employTypeUpdate(FormEvent $event)
    {
        $form = $event->getForm();

        $employmentType = $event->getData();
        if (!$employmentType) {
            $employmentType = 'studywork';
        }

        $employmentTypeFormClass = "ClientBundle\\Form\\Employment\\".ucfirst($employmentType)."EmployType";
        $form->getParent()->add('employmentDetails', $employmentTypeFormClass, [
            'label' => false
        ]);
    }


}