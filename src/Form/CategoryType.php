<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategoryCustom;
use App\Entity\CategoryInStore;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class CategoryType extends AbstractType
{

    public function __construct(private Security $security, private EntityManagerInterface $entityManager)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        dd($options['row_order_initial_value']);
        $builder
            ->add('name', TextType::class)
            ->add('rowOrder', IntegerType::class, [
                'data'=> $options['row_order_initial_value'] ,
                'mapped' => false
            ]);

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event): void {
                $data = $event->getData();
                if ($data->getType() === 'custom')
                    if ($data->getCategoryInStores()->count() === 0) {
                        $categoryInStore = new CategoryInStore();
                        $categoryInStore->setStore($this->security->getUser()->getStore());
                        $categoryInStore->setRowOrder($event->getForm()->get('rowOrder')->getData());
                        $this->entityManager->persist($categoryInStore);
                        $data->addCategoryInStore($categoryInStore);
                    } else {
                        $categoryInStore = $data->getCategoryInStores()[0];
                        $categoryInStore->setRowOrder($event->getForm()->get('rowOrder')->getData());
                    }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'row_order_initial_value' => 1
        ]);
    }


}
