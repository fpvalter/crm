<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /*
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.enabled = true");

        return $response;
    }
    */

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Usuário')
            ->setSearchFields(['email', 'nome'])
            ->setDefaultSort(['email' => 'ASC'])
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
        $nome = TextField::new('nome');
        $codigo = TextField::new('codigo');
        $telefone = TextField::new('telefone');
        $email = EmailField::new('email');
        $equipes = AssociationField::new('equipes');
        $vendedor = AssociationField::new('vendedor');

        $enabled = BooleanField::new('enabled');

        $lastLogin = DateTimeField::new('lastLogin');
        
        $roles = ChoiceField::new('roles')->setChoices(
            [
                'Admin' => 'ROLE_ADMIN',
                'Usuário' => 'ROLE_USER'

            ])->allowMultipleChoices();

        $password = TextField::new('plainPassword')->setLabel('Senha')->setFormType(PasswordType::class);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $nome, $vendedor, $equipes, $enabled, $equipes, $lastLogin];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$email, $enabled, $id, $nome, $telefone, $vendedor, $equipes, $lastLogin];
        } elseif (Crud::PAGE_NEW === $pageName) {

            $password->setRequired(true);
            $enabled->setFormTypeOptions(['data' => true]);
            $roles->setFormTypeOptions(['data' => ['ROLE_USER'] ]);

            return [$codigo, $email, $password, $nome, $telefone, $vendedor, $roles, $equipes, $enabled];
        } elseif (Crud::PAGE_EDIT === $pageName) {

            return [$codigo, $email, $password,  $nome, $telefone, $vendedor, $roles, $equipes, $enabled];
        }
    }
}
