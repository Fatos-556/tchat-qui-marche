<?php

namespace App\Controller;
use App\Entity\Conversation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConversationController extends AbstractController
{
  /**
   * @Route("/conversation", name="conversation")
   */
  public function index(): Response
  {
    if (!$this->getUser()) {
      return $this->redirectToRoute("conversation");
    }
    $repo_user = $this->getDoctrine()->getRepository(User::class);
    $all_users = '';

    if($this->getUser()->getRoleKln() == 'user')
    {
      $all_users =  $repo_user->findAllUsersByRoleKln($this->getUser()->getId(), 'admin');
    }
    if($this->getUser()->getRoleKln() == 'admin')
    {
      $all_users =  $repo_user->findAllUsersByRoleKln($this->getUser()->getId(), 'user');
    }

    return $this->render("conversation/index.html.twig", [
      "controller_name" => "ConversationController",
      "all_users" => $all_users,
      "is_admin" => $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
    ]);
  }
}
