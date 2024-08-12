<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductType extends AbstractType
{

    public function __construct(private Security $security, private TranslatorInterface $translator,)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'title.product.name'])
//            ->add('description', TextType::class, ['label' => 'title.product.description'])
            ->add('ingredients', TextType::class, ['label' => 'title.product.ingredients'])
            ->add('priceHome', TextType::class, ['label' => 'title.product.price_home'])
            ->add('priceAway', TextType::class, ['label' => 'title.product.price_away'])
            ->add('veggie', CheckboxType::class, [
                'label' => 'title.product.veggie',
                'required' => false
            ])
            ->add('halal', CheckboxType::class, [
                'label' => 'title.product.halal',
                'required' => false
            ])
            ->add('category', EntityType::class,
                [
                    'class' => Category::class,
                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('c')
//                            ->innerJoin('c.activeCategories', 'active_categories')
                            ->select('c') // Include category_in_store
                            ->where('c.type = :default OR (c.owner = :store)') // Filter by store ID
                            ->setParameter('default', 'default')
                            ->setParameter('store', $this->security->getUser()->getStore())
                            ->orderBy('c.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ])
            ->add('allergens', EntityType::class,
                [
                    'label'=>'title.product.allergens',
                    'class' => Allergen::class,
                    'multiple' => true,
                    'expanded' => true,
                    'choice_attr' => function($choice, $key, $value) {
                        return ['class' => 'custom-checkbox-class'];
                    },
                    'choice_label' => function ($choice, $key, $value) {
                    return $this->translator->trans('allergen.' . $choice->getName());
                },
                    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
