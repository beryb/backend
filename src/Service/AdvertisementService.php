<?php

namespace App\Service;

use App\Entity\Advertisement;
use App\Repository\AdvertisementRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdvertisementService
 * @package App\Service
 */
class AdvertisementService
{
    /**
     * @var AdvertisementRepository
     */
    private $advertisementRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * AdvertisementService constructor.
     * @param AdvertisementRepository $advertisementRepository
     * @param LoggerInterface $logger
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(AdvertisementRepository $advertisementRepository, LoggerInterface $logger, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->advertisementRepository = $advertisementRepository;
        $this->logger = $logger;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Advertisement $advertisement
     */
    public function create(Advertisement $advertisement)
    {
        try {
            // Create advertisement
            $this->advertisementRepository->create($advertisement);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param Advertisement $advertisement
     */
    public function update(Advertisement $advertisement)
    {
        try {
            // Update advertisement
            $this->advertisementRepository->update($advertisement);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param Advertisement $advertisement
     */
    public function remove(Advertisement $advertisement)
    {
        try {
            // Remove advertisement
            $this->advertisementRepository->remove($advertisement);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @return Advertisement[]
     */
    public function getAll(): array
    {
        return $this->advertisementRepository->findAll();
    }

    /**
     * @param int $id
     * @return Advertisement
     */
    public function getById(int $id): Advertisement
    {
        return $this->advertisementRepository->findOneBy(['id' => $id]);
    }
}
