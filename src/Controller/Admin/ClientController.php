<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Form\Type\ClientType;
use App\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller\Admin
 * @Route("/admin/client", name="client")
 */
class ClientController extends AbstractController
{
    /**
     * @var ClientService
     */
    private $clientService;

    /**
     * ClientController constructor.
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
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
        // Gets clients
        $clients = $this->clientService->getAll();

        // Render template
        return $this->render('admin/views/client/list.html.twig',[
            'clients' => $clients
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
        // Initialize client
        $client = new Client();

        // Create form
        $form = $this->createForm(ClientType::class, $client);

        // Handle form request
        $form->handleRequest($request);

        // Checks is post method
        if ($request->isMethod('POST')) {
            // Validate form
            if ($form->isSubmitted() && $form->isValid()) {
                // Creates client
                $this->clientService->create($client);
                // Shows success message
                $this->addFlash('success', 'Klijent je uspješno kreiran'); // TODO: locales

                // Redirects to list
                return $this->redirectToRoute('client_list');
            }

            // Show error message
            $this->addFlash('error', 'Provjerite unešene podatke i pokušajte ponovno.'); // TODO: locales
        }

        // Render template
        return $this->render('admin/views/client/new.html.twig', [
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
     * @return Response
     */
    public function edit(Request $request, $id): Response
    {
        // Initialize client
        $client = $this->clientService->getById($id);

        // Create form
        $form = $this->createForm(ClientType::class, $client);

        // Handle form request
        $form->handleRequest($request);

        // Checks is post method
        if ($request->isMethod('POST')) {
            // Validate form
            if ($form->isSubmitted() && $form->isValid()) {
                // Updates client
                $this->clientService->update($client);
                // Shows success message
                $this->addFlash('success', 'Klijent je uspješno ažuriran'); // TODO: locales

                // Redirects to list
                return $this->redirectToRoute('client_list');
            }

            // Show error message
            $this->addFlash('error', 'Provjerite unešene podatke i pokušajte ponovno.'); // TODO: locales
        }

        // Render template
        return $this->render('admin/views/client/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete client
     *
     * @Route("/delete/{id}", name="_delete")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {
        // Initialize client
        $client = $this->clientService->getById($id);

        // Checks
        if(empty($client))
        {
            // Redirect to client list
            return $this->redirectToRoute('client_list');
        }

        // Remove the client
        $this->clientService->remove($client);

        // Display success message
        $this->addFlash('success', 'Klijent je uspješno izbrisan!'); // TODO: Locales

        // Redirects
        return $this->redirectToRoute('client_list');
    }
}
