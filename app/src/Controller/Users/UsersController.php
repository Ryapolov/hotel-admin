<?php


namespace App\Controller\Users;


use App\Model\User\Application\Command\Create\Command;
use App\Model\User\Application\Command\Create\Form;
use App\Model\User\Application\Command\Create\Handler;
use App\Model\User\Application\Query\GetUserAllQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     * @param GetUserAllQuery $userAllQuery
     * @return Response
     */
    public function index(GetUserAllQuery $userAllQuery): Response
    {
        $users = $userAllQuery->execute(['email', 'name_first', 'name_last', 'create_date', 'status', 'role']);

        return $this->render('app/users/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/users/create", name="users.create")
     * @param Request $request
     * @param Command $command
     * @param Handler $handler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function create(Request $request, Command $command, Handler $handler)
    {
        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('users');
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/users/create.html.twig', ['form' => $form->createView()]);
    }
}