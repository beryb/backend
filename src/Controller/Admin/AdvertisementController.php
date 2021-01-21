<?php

namespace App\Controller\Admin;

use App\Entity\Advertisement;
use App\Form\Type\AdvertisementType;
use App\Service\AdvertisementService;
use App\Service\FileUploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdvertisementController
 * @package App\Controller\Admin
 * @Route("/admin/advertisement", name="advertisement")
 */
class AdvertisementController extends AbstractController
{
    /**
     * @var AdvertisementService
     */
    private $advertisementService;

    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * AdvertisementController constructor.
     * @param AdvertisementService $advertisementService
     * @param FileUploadService $fileUploadService
     */
    public function __construct(AdvertisementService $advertisementService, FileUploadService $fileUploadService)
    {
        $this->advertisementService = $advertisementService;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Render list
     *
     * @Route("/list", name="_list")
     *
     * @return Response
     */
    public function list(): Response
    {
        // Gets advertisements
        $advertisements = $this->advertisementService->getAll();

        // Render template
        return $this->render('admin/views/advertisement/list.html.twig', [
            'advertisements' => $advertisements
        ]);
    }

    /**
     * Create new
     *
     * @Route("/new", name="_new")
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        // Initialize advertisement
        $advertisement = new Advertisement();

        // Create form
        $form = $this->createForm(AdvertisementType::class, $advertisement);

        // Handle form request
        $form->handleRequest($request);

        // Checks is post method
        if ($request->isMethod('POST')) {
            // Validate form
            if ($form->isSubmitted() && $form->isValid()) {

                /** @var UploadedFile $file */
                $file = $form->get('file')->getData();

                // If file exists - do upload
                if ($file) {
                    $fileName = $this->fileUploadService->upload($file);
                    $advertisement->setFile($fileName);
                } else {
                    $this->addFlash('error', 'Datoteka nije unešena.'); // TODO: Locales

                    return $this->redirectToRoute('advertisement_new');
                }

                // Creates advertisement
                $this->advertisementService->create($advertisement);

                // Shows success message
                $this->addFlash('success', 'Reklama je uspješno kreirana'); // TODO: locales

                // Redirects to list
                return $this->redirectToRoute('advertisement_list');
            }

            // Show error message
            $this->addFlash('error', 'Provjerite unešene podatke i pokušajte ponovno.'); // TODO: locales
        }

        // Render template
        return $this->render('admin/views/advertisement/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit
     *
     * @Route("/edit/{id}", name="_edit")
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function edit(Request $request, $id): Response
    {
        // Initialize advertisement
        $advertisement = $this->advertisementService->getById($id);

        // Create form
        $form = $this->createForm(AdvertisementType::class, $advertisement);

        // Handle form request
        $form->handleRequest($request);

        // Checks is post method
        if ($request->isMethod('POST')) {
            // Validate form
            if ($form->isSubmitted() && $form->isValid()) {

                /** @var UploadedFile $file */
                $file = $form->get('file')->getData();

                // If file exists - do upload
                if ($file) {
                    $fileName = $this->fileUploadService->upload($file);
                    $advertisement->setFile($fileName);
                }

                // Update advertisement
                $this->advertisementService->update($advertisement);

                // Shows success message
                $this->addFlash('success', 'Reklama je uspješno ažurirana.'); // TODO: locales

                // Redirects to list
                return $this->redirectToRoute('advertisement_list');
            }

            // Show error message
            $this->addFlash('error', 'Provjerite unešene podatke i pokušajte ponovno.'); // TODO: locales
        }

        // Render template
        return $this->render('admin/views/advertisement/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete advertisement
     *
     * @Route("/delete/{id}", name="_delete")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {
        // Gets advertisement
        $advertisement = $this->advertisementService->getById($id);

        // Checks
        if (empty($advertisement)) {
            // Display error message
            $this->addFlash('error', 'Traženi klijent ne postoji'); // TODO: Locales

            // Redirect to advertisement list
            return $this->redirectToRoute('advertisement_list');
        }

        // Remove advertisement
        $this->advertisementService->remove($advertisement);

        // Display success message
        $this->addFlash('success', 'Reklama je uspješno izbrisana!'); // TODO: Locales

        // Redirects
        return $this->redirectToRoute('advertisement_list');
    }
}
