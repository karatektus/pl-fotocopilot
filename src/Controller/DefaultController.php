<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Services\MailService;
use App\Services\MessageService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class DefaultController extends AbstractController
{
    /**
     * @param Request              $request
     * @param MessageService       $messageService
     * @param MailService          $mailService
     * @param ManagerRegistry      $doctrine
     * @param RouterInterface      $router
     * @param FormFactoryInterface $formFactory
     *
     * @return array|RedirectResponse
     *
     * @Route("/")
     *
     * @Template()
     *
     * @throws Exception
     */
    public function index(Request $request, MessageService $messageService, MailService $mailService, ManagerRegistry $doctrine, RouterInterface $router, FormFactoryInterface $formFactory, Recaptcha3Validator $recaptcha3Validator)
    {
        $message = new Message();

        $form = $formFactory->create(MessageFormType::class, $message);
        $form->handleRequest($request);

        if (true === $form->isSubmitted() && true === $form->isValid()) {

            $score = $recaptcha3Validator->getLastResponse()->getScore();
            if(0.5 > floatval($score)){
                $messageService->error('bot_error');
                return new RedirectResponse($router->generate('app_default_index'));
            }

            $mailSuccess = $mailService->send($message->getSender(), $message->getSenderEmail(), $message->getSubject(), $message->getMessage());
            if (true === $mailSuccess) {
                $messageService->success('mail_success');
                $message->setSentAt(new DateTime());
            } else {
                $messageService->error('mail_error');
            }

            $doctrine->getManager()->persist($message);
            $doctrine->getManager()->flush();

            return new RedirectResponse($router->generate('app_default_index'));
        }

        return [
            'siteKey' => $_ENV['GOOGLE_RECAPTCHA_SITE_KEY'],
            'form' => $form->createView(),
        ];
    }

    /**
     * @return array
     *
     * @Route("/imprint")
     *
     * @Template()
     */
    public function imprint()
    {
        return [];
    }
}
