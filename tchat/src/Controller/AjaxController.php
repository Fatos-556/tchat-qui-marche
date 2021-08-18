<?php

namespace App\Controller;
use App\Entity\Conversation;
use App\Entity\ConversationMessage;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AjaxController extends AbstractController
{
  /**
   * @Route("/ajax", name="ajax")
   */
  public function index()
  {
    if ($_POST["action"] == "checkToken") {
      return $this->checkToken($_POST["values"]);
    }
    if ($_POST["action"] == "sendMessage") {
      return $this->sendMessage($_POST["values"]);
    }
    if ($_POST["action"] == "refreshMessages") {
      return $this->refreshMessages($_POST["values"]);
    }
    if($_POST["action"] == "checkNotification")
    {
      return $this->checkNotification($_POST["values"]);
    }
    if($_POST["action"] == "seeMessage")
    {
      return $this->seeMessage($_POST["values"]);
    }
  }

  public function checkToken(array $values)
  {
    $ajax_result = "";
    $id_user = (int) $this->getUser()->getId();
    $id_user_tchat = (int) $values["id_user_tchat"];
    $repo_user = $this->getDoctrine()->getRepository(User::class);
    $repo_conv = $this->getDoctrine()->getRepository(Conversation::class);
    $token_exist = $repo_conv->getTokenByIdUsers($id_user_tchat, $id_user);

    if (empty($token_exist)) {
      $token = "token" . rand(0, 9999) . "_" . $id_user . "_" . $id_user_tchat;
      $ids_user = [$id_user, $id_user_tchat];
      $em = $this->getDoctrine()->getManager();
      foreach ($ids_user as $id_user) {
        $conversation = new Conversation();
        $conversation->setIdUser((int) $id_user);
        $conversation->setToken($token);
        $conversation->setDateAdd(date("Y-m-d"));
        $em->persist($conversation);
        $em->flush();
      }
    } else {
      $token = $token_exist["token"];
    }
    return $this->render("ajax/index.html.twig", [
      "ajax_result" => str_replace("\n", "", $token),
    ]);
  }

  public function sendMessage($values)
  {
    $em = $this->getDoctrine()->getManager();
    $message = new ConversationMessage();
    $message->setIdUser((int) $this->getUser()->getId());
    $message->setDateAdd(date("Y-m-d"));
    $message->setToken(str_replace("\n", "", $values["token"]));
    $message->setMessage($values["message"]);
    $message->setSeeAdd('');

    $em->persist($message);
    $em->flush();

    return $this->render("ajax/index.html.twig", [
      "ajax_result" => true,
    ]);
  }

  public function refreshMessages($values = null)
  {
    if ($values) {
      $repo_message = $this->getDoctrine()->getRepository(
        ConversationMessage::class
      );

      $values = $repo_message->getAllMessagesByToken(
        str_replace("\n", "", $values["token"])
      );
      if ($values == 1) {
        $values = null;
      }
      return $this->render("ajax/messages.html.twig", [
        "ajax_result" => "refreshMessage",
        "messages" => $values,
      ]);
    } else {
      return $this->render("ajax/index.html.twig", [
        "ajax_result" => str_replace("\n", "", $values["token"]),
      ]);
    }
  }

  public function checkNotification($values)
  {
    $repo_message = $this->getDoctrine()->getRepository(
        ConversationMessage::class
      );
    $values["token"] = str_replace("\n", "", $values["token"]);
    $notification = $repo_message->checkNotification($this->getUser()->getId(), $values["token"]);
    if($notification["id"] == null) {
        $notification["id"] = 0;
    }
    return $this->render("ajax/index.html.twig", [
      "ajax_result" => $notification["id"],
    ]);
  }

  public function seeMessage($values){
      $return = true;
      $repo_message = $this->getDoctrine()->getRepository(
        ConversationMessage::class
      );
      $ids = $repo_message->getIdMessageNoSee($this->getUser()->getId(), str_replace("\n", "", $values["token"]));
      if(is_array($ids))
      {
        foreach($ids as $id){
        $update = $repo_message->updateSeeAdd($id);
        
        }
        $return = str_replace("\n", "", $values["token"]);
      }
      
      return $this->render("ajax/index.html.twig", [
      "ajax_result" => $return,
    ]);
  }

}
