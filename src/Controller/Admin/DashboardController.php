<?php

namespace App\Controller\Admin;

use App\Entity\Cliente;
use App\Entity\Equipe;
use App\Entity\Estabelecimento;
use App\Entity\NegocioEtapa;
use App\Entity\User;
use App\Entity\Vendedor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm:ss')
            ->setTimeFormat('HH:mm');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToUrl('CRM Home', 'fa fa-home', $this->generateUrl('crm_index')),
            
            MenuItem::subMenu('Cadastros', 'fa fa-database')->setSubItems([
                MenuItem::linkToCrud('Cliente', 'fas fa-building', Cliente::class),
                MenuItem::linkToCrud('Equipe', 'fas fa-users', Equipe::class),
                MenuItem::linkToCrud('Usuario', 'fas fa-user', User::class),
                MenuItem::linkToCrud('Negocio Etapa', 'fas fa-angle-double-right', NegocioEtapa::class),
                MenuItem::linkToCrud('Estabelecimento', 'fas fa-university', Estabelecimento::class),
                MenuItem::linkToCrud('Vendedor', 'fas fa-user', Vendedor::class)
            ])

        ];
    }
}
