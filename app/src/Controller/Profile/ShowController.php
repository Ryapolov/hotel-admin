<?php

namespace App\Controller\Profile;

use App\Model\User\Repository\UserRepository;
use App\ReadModel\User\UserFether;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * ShowController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/profile", name="profile_show")
     */
    public function show(): Response
    {
        $user = $this->userRepository->find($this->getUser()->getId());

        return $this->render('app/profile/show.html.twig');
    }
}