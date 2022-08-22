<?php

namespace App\Form;

use App\Entity\Order;
use App\Form\EventListner\CartDeleteListner;
use App\Form\EventListner\CartProductRemoveListner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('orderDetails', CollectionType::class, [
                'entry_type' => OrderDetailsType::class
            ])
            ->add('proceed', SubmitType::class)
            ->add('delete', SubmitType::class)
            ->addEventSubscriber(new CartProductRemoveListner())
            ->addEventSubscriber(new CartDeleteListner());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
