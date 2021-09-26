<?php

namespace App\Controller;

use App\Entity\Adm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdmController extends AbstractController
{
    private $admRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->admRepository = $entityManager->getRepository(Adm::class);
    }

    /** 
     * @Route("/getAdm")
     */
    public function getAdm(Request $request): Response
    {
        return new JsonResponse($this->admRepository->findOneBy(['id' => 1]), 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
