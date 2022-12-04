<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price_min', NumberType::class, [
                'label' => 'Prix Minimum'
            ])
            ->add('price_max', NumberType::class,[
                'label' => 'Prix Maximum'
            ])
            ->add('seller', EntityType::class, [
                'class' => User::class,
                'choice_label' => "Vendeur"
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => "Catégorie"
            ])
            ->add('order', ChoiceType::class, [
                'label' => 'Ordre',
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC'
                ],
                'expanded' => false,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
