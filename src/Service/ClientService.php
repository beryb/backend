<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ClientService
 * @package App\Service
 */
class ClientService
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * ClientService constructor.
     * @param ClientRepository $clientRepository
     * @param LoggerInterface $logger
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ClientRepository $clientRepository, LoggerInterface $logger, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->clientRepository = $clientRepository;
        $this->logger = $logger;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Client $client
     */
    public function create(Client $client)
    {
        try {
            // Encode password
            $client->getUser()->setPassword($this->passwordEncoder->encodePassword($client->getUser(), $client->getUser()->getPassword()));

            // Create client
            $this->clientRepository->create($client);

        } catch (\Exception $e) {
            $this->logger->log(0, $e->getMessage());
        }
    }

    /**
     * @param Client $client
     */
    public function update(Client $client)
    {
        try {
            $oldClient = $this->getById($client->getId());
            $client->getUser()->setPassword($oldClient->getUser()->getPassword());

            // Update client
            $this->clientRepository->update($client);

        } catch (\Exception $e) {
            $this->logger->log(0, $e->getMessage());
        }
    }

    /**
     * @param Client $client
     */
    public function remove(Client $client)
    {
        try {
            // Remove client
            $this->clientRepository->remove($client);

        } catch (\Exception $e) {
            $this->logger->log(0, $e->getMessage());
        }
    }

    /**
     * @return Client[]
     */
    public function getAll(): array
    {
        return $this->clientRepository->findAll();
    }

    /**
     * @param int $id
     * @return Client
     */
    public function getById(int $id): Client
    {
        return $this->clientRepository->findOneBy(['id' => $id]);
    }

    /**
     * @param string $code
     * @return Client
     */
    public function getByCode(string $code): Client
    {
        return $this->clientRepository->findOneBy(['code' => $code]);
    }

    /**
     * @param User $user
     * @return Client
     */
    public function getByUser(User $user): Client
    {
        return $this->clientRepository->findOneBy(['user' => $user]);
    }

    /**
     * @param User $user
     * @return Client[]
     */
    public function getAllByUser(User $user)
    {
        return $this->clientRepository->findBy(['user' => $user]);
    }
}
