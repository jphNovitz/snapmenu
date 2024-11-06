<?php

namespace App\Form;

use App\Dto\StoreDto;
use App\Entity\Store;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'store.name'])
            ->add('vatNumber', TextType::class, ['label' => 'store.vatNumber'])
            ->add('phoneNumber', TextType::class, ['label' => 'store.phoneNumber'])
            ->add('description', TextType::class, ['label' => 'store.description'])
            ->add('logoFile', VichImageType::class, [
                'required' => false,
                'label' => 'store.logo'
            ])
            ->add('streetName', TextType::class, ['label' => 'store.streetName'])
            ->add('houseNumber', TextType::class, ['label' => 'store.houseNumber'])
            ->add('postCode', TextType::class, ['label' => 'store.pc'])
            ->add('city', TextType::class, ['label' => 'store.city'])
            ->add('email', TextType::class, ['label' => 'store.email'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StoreDto::class,
        ]);
    }
}
