<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MapServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request,
        MailerInterface $mailer,
        MapServiceInterface $mapService,
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var array{email: string, name: string, message: string, subject: string} $datas */
            $datas = $form->getData();
            $from = 'contact@brumedencre-tattoo.fr'; // $datas['email'];
            $to = 'contact@brumedencre-tattoo.fr';
            $name = $datas['name'];
            $content = $datas['message'];
            $attach = $form->get('attachment')->getData();
            $file = null;
            if ($attach instanceof UploadedFile) {
                $file = file_get_contents($attach->getPathname());
            }
            $subject = $datas['subject'];

            $email = (new Email())
                ->from($from)
                ->to($to)
                ->subject($subject.' '.$datas['email'].' '.$name)
                ->text($content)
            ;
            if (is_string($file)) {
                $email->attach($file);
            }

            $mailer->send($email);
            $this->addFlash('success', 'Merci ! Votre message a bien été envoyé. Je reviendrai vers vous dès que possible.');

            return $this->redirectToRoute('app_contact');
        }

        $map = $mapService->generateMap();

        return $this->render('contact/index.html.twig', [
            'map' => $map,
            'contactForm' => $form->createView(),
        ]);
    }
}
