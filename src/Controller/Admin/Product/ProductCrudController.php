<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('priceHome')->setLabel('fields.price_home')->setColumns(2),
            TextField::new('priceAway')->setLabel('fields.price_away')->setColumns(2),
            TextField::new('name')->setLabel('fields.name')->setColumns(12),
            AssociationField::new('category')->setLabel('fields.category')->setColumns(6),
            BooleanField::new('veggie')->setLabel('fields.veggie')->setColumns(3),
            BooleanField::new('halal')->setLabel('fields.halal')->setColumns(3),
            TextField::new('description')->setLabel('fields.description')->setColumns(12),
            TextField::new('ingredients')->setLabel('fields.ingredients')->setColumns(12),
            AssociationField::new('allergens')->setLabel('fields.allergens')->setColumns(12),
        ];
    }

}
