<?php

namespace App\Controller\Admin;

use App\Entity\Pack;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pack::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('price')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['title'])
            ->setSearchFields(['price'])
            ->setDefaultSort([
                'title' => 'ASC',
            ])
        ;
    }
}
