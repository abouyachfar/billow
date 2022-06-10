<?php

namespace App\Controller\Admin;

use App\Entity\SellPage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SellPageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SellPage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnDetail()->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('content'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['title'])
        ;
    }
}
