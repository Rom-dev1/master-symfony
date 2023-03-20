<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price', MoneyType::class, [
                // Si l'utilisateur saisit 99, on stocke 9900
                // Si le produit a 9900 en BDD, on affiche 99.00
                'divisor' => 100,
            ])
            ->add('image')
            ->add('category', null, [
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie...',
                // Pour avoir des boutons radios
                // 'expanded' => true,
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
