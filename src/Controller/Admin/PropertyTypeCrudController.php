<?php

namespace App\Controller\Admin;

use App\Entity\PropertyType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropertyTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PropertyType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['label'])
        ;
    }
}
