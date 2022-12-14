<?php

namespace App\Form;

use App\Entity\CartProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_quantity', TextType::class, [
                'label' => 'Quantité'
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Taille',
                'choices' => [
                    '38' => '38',
                    '39' => '39',
                    '40' => '40',
                    '41' => '41',
                    '42' => '42',
                    '43' => '43'
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('size_top', ChoiceType::class, [
                'label' => 'Taille',
                'choices' => [
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL'
                ],
                'expanded' => false,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CartProduct::class,
        ]);
    }
}
