<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\Asset;

class ContentController extends FrontendController
{
    #[Template('content/default.html.twig')]
    public function defaultAction(Request $request): array
    {
        return [];
    }

    public function productAction(Request $request): Response
    {
        return $this->render('content/product.html.twig');
    }

    public function TrafficAction(Request $request): Response
    {
        return $this->render('content/traffic.html.twig');
    }

    public function ContactAction(Request $request): Response
    {
        return $this->render('content/contact.html.twig');
    }

    public function myGalleryAction(Request $request): array
   {
    if ('asset' === $request->get('type')) {
        $asset = Asset::getById((int) $request->get('id'));
        if ('folder' === $asset->getType()) {
            return [
                'assets' => $asset->getChildren()
            ];
        }
    }

    return [];
   }

}