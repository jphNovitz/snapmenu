<?php

namespace App\Form;

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

class ProductType extends AbstractType
{

    public function __construct(private Security $security,)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'title.product.name'])
            ->add('description', TextType::class, ['label' => 'title.product.description'])
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
                            ->andWhere('c.type = :default OR (c.type = :custom AND c.owner = :user)')
                            ->setParameter('default', 'default')
                            ->setParameter('custom', 'custom')
                            ->setParameter('user', $this->security->getUser())
                            ->orderBy('c.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
