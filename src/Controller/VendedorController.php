<?php

namespace App\Controller;

use App\Entity\Contato;
use App\Repository\VendedorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vendedor")
 */
class VendedorController extends BaseController
{

    private VendedorRepository $repository;

    public function __construct(VendedorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/panel", name="vendedor_panel")
     */
    public function index(): Response
    {

        if(!$this->getUser()->getVendedor()) {
            $this->addFlash('danger', 'Para acessar o painel do vendedor, você precisa ser um vendedor ;)');
            return $this->redirectToRoute('crm_index');
        }

        $contatoRepo = $this->getDoctrine()->getRepository(Contato::class);
        $contatosAniversariantes = $contatoRepo->countContatosAniversariantesByVendedor($this->getUser()->getVendedor()->getId());

        return $this->render('vendedor/panel.html.twig', [
            'contatosAniversariantes' => $contatosAniversariantes
        ]);
    }
    
}
