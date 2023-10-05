<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\Block;
use Pimcore\Model\DataObject\Service;

use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject;
use Pimcore\Model\Document;

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

   #[Route('/testblock')]
    public function BlogAction(Request $request): Response
    {

        // echo '<pre>';
        // print_r($object);
        // echo '</pre>';
        // die;


        $dataToPass = [];
        $fieldToPass = [];
        $brickToPass = [];

       //setting DATA OF OBJECT BRICK using API
        $object = Block::getById(6);
        $object->getVehic()->getVehicledef()->setColor("Grey");
        $object->save();

//LISTING BRICKS WITH CONDITION
//        $listcondition = $object::getList([
//            /* add here all Objectbricks you need in the condition */
//            "objectbricks" => ["Vehic"],
//            /* in the condition access Objectbrick attributes with OBJECTBRICKNAME.ATTRIBUTENAME */
//            "condition" => "Vehic.color!=='blue'"
//        ]);

//         echo '<pre>';
//        print_r($listcondition);
//         echo '</pre>';
//        die;

        $fieldCollection = $object->getTestContents();

        foreach ($fieldCollection as $item) {

            // Retrieve data from the field collection item
            $data = [
                'inputField' => $item->getInputField(),
                'numberField' => $item->getNumberField(),
                'video' => $item->getVideo(),

            ];

            $fieldToPass[] = $data;
        }

        $classificationStore = $object->getvehicleClass();
        foreach ($classificationStore->getGroups() as $group) {
            $groupData = [];
            $groupData['configurationName'] = $group->getConfiguration()->getName();

            $keysData = [];

            foreach ($group->getKeys() as $key) {
                $keyConfiguration = $key->getConfiguration();

                $value = $key->getValue();
                if ($value instanceof \Pimcore\Model\DataObject\Data\QuantityValue) {
                    $value = (string)$value;
                }

                $keyData = [
                    'title' => $keyConfiguration->getTitle(),
                    'value' => $value,

                ];

                $keysData[] = $keyData;
            }

                $groupData['keys'] = $keysData;
                $dataToPass[] = $groupData;
            }
            $blockData = $object->getBlock();



        return $this->render('content/block.html.twig', [
            'blockData' => $blockData,'dataToPass' => $dataToPass , 'fieldToPass' => $fieldToPass , 'object'  => $object,
        ]);
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
