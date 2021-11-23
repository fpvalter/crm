<?php

namespace App\Controller\Admin;

use App\Entity\Seguimento;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeguimentoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seguimento::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Seguimento')
            ->setSearchFields(['descricao', 'codigo'])
            ->setDefaultSort(['descricao' => 'ASC'])
            ->setPaginatorPageSize(30);
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-pencil');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-trash')->setCssClass('action-delete');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-search');
            })
            ;
    }

    public function configureFields(string $pageName): iterable
    {

        $id = IntegerField::new('id', 'ID');
        $codigo = TextField::new('codigo');
        $descricao = TextField::new('descricao');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $descricao];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $descricao];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$codigo, $descricao];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$codigo, $descricao];
        }
    }
}
