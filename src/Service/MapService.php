<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

class MapService implements MapServiceInterface
{
    public function generateMap(): Map
    {
        $point = new Point(43.68551114513038, 3.5850781187172367);

        return (new Map('default'))
            ->center($point)
            ->zoom(12)
            ->addMarker(new Marker(
                position: $point,
                title: "Brume d'Encre Tattoo",
                infoWindow: new InfoWindow(
                    content: 'Proche de la Poste. Grand parking disponible à proximité',
                )
            ));
    }
}
