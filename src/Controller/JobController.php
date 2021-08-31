<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route('/job', name: 'job')]
    public function index(): Response
    {
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }

    #[Route('/', name: 'job.list', methods: "GET")]
    public function list(EntityManagerInterface $em) : Response
    {

        $categories = $em->getRepository(Category::class)->findByWithActiveJobs();
        $jobs = null;
        return $this->render('job/list.html.twig', [
            'categories' => $categories,
            'jobs' => $jobs,
        ]);

    }

    #[Route('/{id}', name: 'job.show', methods: "GET")]
    #[Entity('job', expr: 'repository.findActiveJob(id)')]

    public function show(Job $job) : Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }
}
