<?php

namespace App\Form;

use App\Entity\Contato;
use App\Entity\Negocio;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NegocioClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('contato', EntityType::class, [
                'class' => Contato::class,
                'placeholder' => 'Selecione',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.cliente=:cliente_id')
                        ->setParameter('cliente_id', $options['cliente_id'])
                        ->orderBy('c.nome', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Negocio::class,
            'cliente_id' => null
        ]);
    }
}
