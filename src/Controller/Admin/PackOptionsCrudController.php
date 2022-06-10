<?php

namespace App\Controller\Admin;

use App\Entity\PackOptions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PackOptionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PackOptions::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('pack'),
            TextField::new('title'),
            TextEditorField::new('description'),
            BooleanField::new('activ')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['title', 'pack.title'])
        ;
    }
}
