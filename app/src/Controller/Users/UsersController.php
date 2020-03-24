<?php


namespace App\Controller\Users;


use App\Model\User\Application\Command\Activate\ActivateCommand;
use App\Model\User\Application\Command\Activate\ActivateHandler;
use App\Model\User\Application\Command\Block\BlockCommand;
use App\Model\User\Application\Command\Block\BlockHandler;
use App\Model\User\Application\Command\Confirm\ConfirmCommand;
use App\Model\User\Application\Command\Confirm\ConfirmHandler;
use App\Model\User\Application\Command\Create\CreateCommand;
use App\Model\User\Application\Command\Create\CreateForm;
use App\Model\User\Application\Command\Create\CreateHandler;
use App\Model\User\Application\Command\Edit\EditCommand;
use App\Model\User\Application\Command\Edit\EditForm;
use App\Model\User\Application\Command\Edit\EditHandler;
use App\Model\User\Application\Command\SetPassword\SetPasswordCommand;
use App\Model\User\Application\Command\SetPassword\SetPasswordForm;
use App\Model\User\Application\Command\SetPassword\SetPasswordHandler;
use App\Model\User\Application\Query\GetUserAllQuery;
use App\Model\User\Domain\User\User;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $users = $userAllQuery->execute(
            [
                'id',
                'email',
                'name_first',
                'name_last',
                'create_date',
                'status',
                'role'
            ]
        );

        return $this->render('app/users/index.html.twig', ['users' => $users]);
    }

    /** @Route("/users/view/{id}", name="user.view")
     * @param User $user
     * @return Response
     */
    public function view(User $user): Response
    {
        return $this->render('app/users/view.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/users/create", name="users.create")
     * @param Request $request
     * @param CreateCommand $createCommand
     * @param CreateHandler $createHandler
     * @return RedirectResponse|Response
     */
    public function create(Request $request, CreateCommand $createCommand, CreateHandler $createHandler)
    {
        $form = $this->createForm(CreateForm::class, $createCommand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $createHandler->handle($createCommand);
                return $this->redirectToRoute('users');
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/users/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("user/confirm", name="user.confirm.token")
     * @param Request $request
     * @param ConfirmCommand $confirmCommand
     * @param ConfirmHandler $confirmHandler
     * @return RedirectResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function confirm(Request $request, ConfirmCommand $confirmCommand, ConfirmHandler $confirmHandler)
    {
        $confirmCommand->id = $request->get('id');
        $confirmCommand->token = $request->get('token');

        try {
            $confirmHandler->handle($confirmCommand);
        } catch (\Exception $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('user.set.password', ['id' => $request->get('id')]);
    }

    /**
     * @Route("user/set_password", name="user.set.password")
     * @param Request $request
     * @param SetPasswordCommand $command
     * @param SetPasswordHandler $handler
     * @return RedirectResponse|Response
     */
    public function setPassword(Request $request, SetPasswordCommand $command, SetPasswordHandler $handler)
    {
        $command->id = $request->get('id');

        $form = $this->createForm(SetPasswordForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash(
                    'notice',
                    'Your password were saved!'
                );
                return $this->redirectToRoute('home');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/users/set.password.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("user/edit/{id}", name="user.edit")
     * @param Request $request
     * @param User $user
     * @param EditHandler $editHandler
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function edit(Request $request, User $user, EditHandler $editHandler): Response
    {
        $editCommand = new EditCommand(
            $user->getId()->getValue(),
            $user->getEmail()->getValue(),
            $user->getName()->getFirst(),
            $user->getName()->getLast()
        );

        $form = $this->createForm(EditForm::class, $editCommand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $editHandler->handle($editCommand);
            } catch (DomainException $exception) {
                $this->addFlash(
                    'error',
                    $exception->getMessage()
                );
            }

            $this->addFlash(
                'success',
                'Success!'
            );
        }

        return $this->render('app/users/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("user/block/{id}", name="user.block")
     * @param Request $request
     * @param BlockCommand $blockCommand
     * @param BlockHandler $blockHandler
     * @return RedirectResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function block(Request $request, BlockCommand $blockCommand, BlockHandler $blockHandler)
    {
        $blockCommand->id = $request->get('id');

        if ($blockCommand->id === $this->getUser()->getId()) {
            $this->addFlash(
                'error',
                'You cannot block yourself!'
            );
        } else {
            $blockHandler->handle($blockCommand);
        }

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("user/activate/{id}", name="user.activate")
     * @param Request $request
     * @param ActivateCommand $activateCommand
     * @param ActivateHandler $activateHandler
     * @return RedirectResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function activate(Request $request, ActivateCommand $activateCommand, ActivateHandler $activateHandler): RedirectResponse
    {
        $activateCommand->id = $request->get('id');
        $activateHandler->handle($activateCommand);

        return $this->redirectToRoute('users');
    }
}