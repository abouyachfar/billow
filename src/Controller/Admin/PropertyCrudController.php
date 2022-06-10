<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnDetail()->hideOnForm(),
            AssociationField::new('city', 'City'),
            AssociationField::new('PropertyType', 'PropertyType'),
            AssociationField::new('owner', 'User'),
            TextField::new('title'),
            TextEditorField::new('description')->hideOnIndex(),
            TextField::new('price'),
            IntegerField::new('bedrooms')->hideOnIndex(),
            IntegerField::new('bathrooms')->hideOnIndex(),
            TextField::new('street'),
            TextField::new('livingSpace')->hideOnIndex(),
            TextField::new('lotDimensions')->hideOnIndex(),
            IntegerField::new('level')->hideOnIndex(),
            IntegerField::new('halfBarth', 'half Bath')->hideOnIndex(),
            TextField::new('reference')->hideOnIndex(),
            DateTimeField::new('onlineFrom')->hideOnIndex(),
            TextField::new('latitude')->hideOnIndex(),
            TextField::new('longitude')->hideOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            BooleanField::new('is_online', 'Enabled by owner'),
            BooleanField::new('disabledByAdmin', 'Enabled by admin'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['title', 'price', 'region.label', 'city.label', 
                'street', 'reference', 'owner.email', 
                'owner.first_name', 'owner.last_name',
                'created_at', 'PropertyType.label'])
            ->setDefaultSort([
                    'created_at' => 'DESC',
                ])
        ;
    }
}
