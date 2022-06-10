<?php

namespace App\Controller\Admin;

use App\Entity\City;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return City::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label'),
            AssociationField::new('region', 'Region')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['label', 'region.label'])
            ->setDefaultSort([
                'label' => 'ASC',
            ])
        ;
    }
}
