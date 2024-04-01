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

    public function __construct(private Security $security)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//            ->add('name', TextType::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options): void {
            $form = $event->getForm();;

            if (($event->getData()->getType() === 'custom') || (in_array('ROLE_SUPER_ADMIN', $this->security->getUser()->getRoles()))) {
                $form->add('name', TextType::class);
            }
            if ($this->security->getUser()->getRoles())

                if ($options['row_order_initial_value']) {
                    $form->add('rowOrder', IntegerType::class, [
                        'mapped' => false,
                        'data' => $options['row_order_initial_value']
                    ]);
                }
        });

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event): void {
                $data = $event->getData();
                if ($data->getType() === 'custom')
                    $data->setOwner($this->security->getUser()->getStore());
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'row_order_initial_value' => null
        ]);
    }


}
