<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailServiceInterface;
use App\Service\MapServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request,
        EmailServiceInterface $emailService,
        MapServiceInterface $mapService,
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var array{email: string, name: string, message: string, subject: string} $datas */
            $datas = $form->getData();

            $attach = $form->get('attachment')->getData();
            $fileContent = null;
            if ($attach instanceof UploadedFile) {
                $fileContent = file_get_contents($attach->getPathname()) ?: null;
            }

            $emailService->sendContactEmail($datas, $fileContent);

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
