<?php

namespace App\Form;

use App\Entity\OrderDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AddToCartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'attr'=> array (
                    'class'=>'quantity'
                ),
            ])
            ->add('minus', ButtonType::class, [
                'label' =>'-',
            ])
            ->add('plus', ButtonType::class, [
                'label'=>'+',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDetail::class,
        ]);
    }
}
