<?php

namespace App\Controller\Admin;

use App\Entity\Produto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProdutoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produto::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Produto')
            ->setSearchFields(['descricao', 'codigo', 'categoria'])
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
        $categoria = TextField::new('categoria');
        $familia = AssociationField::new('familia');
        $subfamilia = AssociationField::new('subfamilia');
        $grupo = AssociationField::new('grupo');
        $marca = AssociationField::new('marca');
        $indice = TextField::new('indice');
        $altura = TextField::new('altura');
        $largura = TextField::new('largura');
        $aro = TextField::new('aro');
        $ht = TextField::new('ht');
        $runflat = TextField::new('runflat');


        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $codigo, $descricao, $categoria, $familia];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $codigo, $descricao, $categoria, $familia, $subfamilia, $grupo, $marca, $indice, $altura, $largura, $aro, $ht, $runflat];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$codigo, $descricao, $categoria, $familia, $subfamilia, $grupo, $marca, $indice, $altura, $largura, $aro, $ht, $runflat];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$codigo, $descricao, $categoria, $familia, $subfamilia, $grupo, $marca, $indice, $altura, $largura, $aro, $ht, $runflat];
        }
    }
}
