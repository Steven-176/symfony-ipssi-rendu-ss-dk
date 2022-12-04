<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', ChoiceType::class, [
                'label' => 'Prix',
                'choices' => [
                    '1 - 20 €' => '1 AND 20',
                    '20 - 50 €' => '20 AND 50',
                    '50 - 100 €' => '50 AND 100',
                    '100 - 150 €' => '100 AND 150',
                    '150 - 250 €' => '150 AND 250'
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => false
            ])
            ->add('seller', EntityType::class, [
                'label' => 'Vendeur',
                'class' => User::class,
                'choice_label' => 'fullname',
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('title', ChoiceType::class, [
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
