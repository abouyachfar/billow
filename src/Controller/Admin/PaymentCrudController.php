<?php

namespace App\Controller\Admin;

use App\Entity\Payment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PaymentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payment::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnDetail()->hideOnForm(),
            AssociationField::new('user'),
            AssociationField::new('pack'),
            TextField::new('card'),
            TextField::new('price'),
            TextField::new('status'),
            TextField::new('message'),
            DateTimeField::new('paymentDate'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['card', 'price', 'paymentDate', 'user.email', 
                'user.first_name', 'user.last_name', 'status'])
            ->setDefaultSort([
                    'paymentDate' => 'DESC',
                ])
        ;
    }
}
