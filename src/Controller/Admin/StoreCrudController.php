<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setLabel('fields.store.name')
                ->setColumns(12),
            TextEditorField::new('description')
                ->setLabel('fields.store.description')
                ->setColumns(12)
                ->hideOnIndex(),
            ImageField::new('logoName')
                ->setBasePath('images/store')
                ->onlyOnIndex(),
            TextField::new('logoFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms()
                ->hideOnIndex(),
            TextField::new('streetName')
                ->setLabel('fields.store.street')
                ->setColumns(10)
                ->hideOnIndex(),
            TextField::new('houseNumber')
                ->setLabel('fields.store.nr')
                ->setColumns(2)
                ->hideOnIndex(),
            TextField::new('postCode')
                ->setLabel('fields.store.postal_code')
                ->setColumns(4)
                ->hideOnIndex(),
            TextField::new('city')
                ->setLabel('fields.store.city')
                ->setColumns(8),
            TextField::new('phoneNumber')
                ->setLabel('fields.store.phone')
                ->setColumns(6),
            TextField::new('vatNumber')
                ->setLabel('fields.store.vat')
                ->setColumns(6),
        ];
    }

}
