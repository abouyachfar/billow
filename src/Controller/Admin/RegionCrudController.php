<?php

namespace App\Controller\Admin;

use App\Entity\Region;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Region::class;
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
            ->setDefaultSort([
                'label' => 'ASC',
            ])
        ;
    }
}
