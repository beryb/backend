<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class FileUploadService
 * @package App\Service
 */
class FileUploadService
{
    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * FileUploadService constructor.
     * @param SluggerInterface $slugger
     * @param ParameterBagInterface $params
     * @param LoggerInterface $logger
     */
    public function __construct(SluggerInterface $slugger, ParameterBagInterface $params, LoggerInterface $logger)
    {
        $this->slugger = $slugger;
        $this->params = $params;
        $this->logger = $logger;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        // Get target directory
        $targetDirectory = $this->params->get('advertisements_directory');

        // Gets original file name
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Creates safe file name
        $safeFilename = $this->slugger->slug($originalFilename);

        // Generate file name
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $e) {
            $this->logger->error($e->getMessage());
        }

        return $fileName;
    }
}
