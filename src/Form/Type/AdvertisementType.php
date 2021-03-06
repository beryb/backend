<?php

namespace App\Form\Type;

use App\Entity\Advertisement;
use App\Entity\Client;
use App\Entity\User;
use App\Enum\AdvertisementTypeEnum;
use App\Service\ClientService;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class AdvertisementType
 * @package App\Form\Type
 */
class AdvertisementType extends AbstractType
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var ClientService
     */
    private $clientService;

    /**
     * AdvertisementType constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param ClientService $clientService
     */
    public function __construct(TokenStorageInterface $tokenStorage, ClientService $clientService)
    {
        $this->tokenStorage = $tokenStorage;
        $this->clientService = $clientService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (EntityRepository $repository) {
                    /** @var User $user */
                    $user = $this->tokenStorage->getToken()->getUser();
                    $qb = $repository->createQueryBuilder('c');
                    if(!$user->getIsAdmin()) {
                        $qb->where('c.user = :user')->setParameter('user', $user->getId());
                    }
                    return $qb;
                },
                'choice_label' => function (Client $client) {
                    return $client->getFirstName() . ' ' . $client->getLastName();
                }
            ])
            ->add('dateFrom', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateTo', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('isPayed', CheckboxType::class, [
                'required' => false
            ])
            ->add('type', ChoiceType::class, [
                'choices' => array_flip(AdvertisementTypeEnum::$labels),
            ])
            ->add('file', FileType::class, [
                'label' => 'File',
                'mapped' => false,
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisement::class,
        ]);
    }
}
