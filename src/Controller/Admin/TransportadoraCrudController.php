<?php

namespace App\Controller\Admin;

use App\Entity\Transportadora;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransportadoraCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transportadora::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Transportadora')
            ->setSearchFields(['razaoSocial', 'cnpj'])
            ->setDefaultSort(['razaoSocial' => 'ASC'])
            ->setPaginatorPageSize(30);
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-pencil');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-search');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-trash');
            })
            ;
    }

    public function configureFields(string $pageName): iterable
    {

        $id = IntegerField::new('id', 'ID');
        $codigo = TextField::new('codigo');
        $razaoSocial = TextField::new('razaoSocial');
        $cnpj = TextField::new('cnpj');
        $cidade = AssociationField::new('cidade');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $razaoSocial, $cnpj, $cidade];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $razaoSocial, $cnpj, $cidade];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$codigo, $razaoSocial, $cnpj, $cidade];
        } elseif (Crud::PAGE_EDIT === $pageName) {

            return [$codigo, $razaoSocial, $cnpj, $cidade];
        }
    }
}
