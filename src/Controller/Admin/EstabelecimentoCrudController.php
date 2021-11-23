<?php

namespace App\Controller\Admin;

use App\Entity\Equipe;
use App\Entity\Estabelecimento;
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

class EstabelecimentoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Estabelecimento::class;
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Estabelecimento')
            ->setSearchFields(['codigo', 'razaoSocial', 'cnpj'])
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
        $razaoSocial = TextField::new('razaoSocial');
        $cnpj = TextField::new('cnpj');
        $logradouro = TextField::new('logradouro');
        $numero = TextField::new('numero');
        $bairro = TextField::new('bairro');
        $cep = TextField::new('cep');
        $email = TextField::new('email');
        $telefone = TextField::new('telefone');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $codigo, $razaoSocial, $cnpj];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$codigo, $razaoSocial, $cnpj, $logradouro, $numero, $bairro, $cep, $email, $telefone];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$codigo, $razaoSocial, $cnpj, $logradouro, $numero, $bairro, $cep, $email, $telefone];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$codigo, $razaoSocial, $cnpj, $logradouro, $numero, $bairro, $cep, $email, $telefone];
        }
    }
}
