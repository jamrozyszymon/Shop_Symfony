<?php

namespace App\Form\EventListner;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Order;

class CartDeleteListner implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit',
        ];
    }

    /**
     * Delete cart with all products
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $form->getData();
       

        if (!$cart instanceof Order) {
            return;
        }

        if(!$form->get('delete')->isClicked()) {
            return;
        }

        $cart->removeAllOrderDetail();
    }

}
