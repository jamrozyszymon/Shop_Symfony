<?php

namespace App\Form\EventListner;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Order;

class CartProductRemoveListner implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit',
        ];
    }

    /**
     * Remove individual product from cart
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $form->getData();
       

        if (!$cart instanceof Order) {
            return;
        }

        foreach($form->get('orderDetails')->all() as $child) {
            if ($child->get('remove')->isClicked()) {
                $cart->removeOrderDetail($child->getData());
                break;
                }
        }
    }

}
