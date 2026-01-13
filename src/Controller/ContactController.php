<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, vous pourriez ajouter la logique d'envoi d'email avec $form->getData()
            // Pour l'instant, on ajoute juste un message flash de succès
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
