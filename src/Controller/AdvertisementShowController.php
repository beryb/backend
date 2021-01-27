<?php


namespace App\Controller;

use App\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/", name="advertisement_show")
 */
class AdvertisementShowController extends AbstractController
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
     * Render advertisements by id
     *
     * @Route("/{code}", name="_render")
     *
     * @param $code
     * @return Response
     */
    public function renderAdvertisements($code): Response
    {
        // Gets client by code
        $client = $this->clientService->getByCode($code);

        // Get advertisements
        $advertisements = $client->getAdvertisements();

        return $this->render('public/slideshow.html.twig',[
            'advertisements' => $advertisements
        ]);

    }

    /**
     * Insert code
     *
     * @Route("/", name="_code")
     *
     * @param Request $request
     * @return Response
     */
    public function insertCode(Request $request): Response
    {
        $code = (isset($_COOKIE['code'])) ? $_COOKIE['code'] : $request->query->get('code');

        if(!is_null($code)) {
            setcookie('code', $code);
            return $this->redirectToRoute('advertisement_show_render',[
                'code' => $code
            ]);
        }

        return $this->render('public/code.html.twig',[]);
    }

}
