<?php

namespace App\Controller\Admin;

use App\Entity\NegocioEtapa;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NegocioEtapaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NegocioEtapa::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Negocio Etapa')
            ->setSearchFields(['descricao'])
            ->setDefaultSort(['ordem' => 'ASC'])
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
                return $action->setIcon('fa fa-fw fa-trash');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-fw fa-search');
            })
            ;
    }

    public function configureFields(string $pageName): iterable
    {

        $id = IntegerField::new('id', 'ID');
        $descricao = TextField::new('descricao');
        $ordem = IntegerField::new('ordem');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $descricao, $ordem];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $descricao, $ordem];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$descricao, $ordem];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$descricao, $ordem];
        }
    }
}
