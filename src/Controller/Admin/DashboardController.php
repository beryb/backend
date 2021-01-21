<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin", name="admin")
 */
class DashboardController extends AbstractController
{
    /**
     * Renders dashboard.
     *
     * @Route("/", name="_dashboard")
     *
     * @return Response
     */
    public function renderDashboard(): Response
    {
        // Render template
        return $this->render('admin/views/dashboard/dashboard.html.twig',[]);
    }
}
