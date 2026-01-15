<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

final class ContactController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            $from = $datas['email'];
            $name = $datas['name'];
            $content = $datas['message'];
            $attach = $form['attachment']->getData();
            if(isset($attach))
                $file = file_get_contents($attach);
            $subject = $datas['subject'];

            $email = (new Email())
                ->from($from)
                ->subject($subject . ' ' . $name)
                ->text($content)
            ;
            if(isset($file)){
                $email->attach($file);
            }

            $mailer->send($email);
            $this->addFlash('success', 'Merci ! Votre message a bien été envoyé. Je reviendrai vers vous dès que possible.');

            return $this->redirectToRoute('app_contact');
        }

        $point = new Point(43.68551114513038, 3.5850781187172367);
        $map = (new Map('default'))
        ->center($point)
        ->zoom(12)

        ->addMarker(new Marker(
            position: $point,
            title: "Brume d'Encre Tattoo",
            infoWindow: new InfoWindow(
                content: 'Proche de la Poste. Grand parking disponible à proximité',
                )
        ));

        return $this->render('contact/index.html.twig', [
            'map' => $map,
            'contactForm' => $form->createView(),
        ]);
    }
}
