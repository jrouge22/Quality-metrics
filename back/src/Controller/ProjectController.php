<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;

class ProjectController extends AbstractController
{
    /**
     * @Route("/api/show_metrics_projects", name="show_metrics_projects")
     */
    public function ShowMetricsProjects(ProjectRepository $projectRepository)
    {
		$res = $projectRepository->findLastProjectMetricsForProject();

		return $this->json($res);
    }

}
