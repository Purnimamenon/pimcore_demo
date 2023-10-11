<?php

namespace App\Controller;

// use App\Website\TestGenerator;
use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\Asset;
use Pimcore\Model;
use Pimcore\Model\DataObject\Block;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\Incident;
use Pimcore\Model\DataObject\Location;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject;


class ContentController extends FrontendController
{
    #[Template('content/default.html.twig')]
    public function defaultAction(Request $request): array
    {
        return [];
    }

    
    public function productAction(Request $request): Response
    {
      
        // $linkid = Link::getById(13);
      
        // $link = $linkid->getHref();
        
     
        return $this->render('content/product.html.twig');
    }

    #[Route('/products/watch/{sku}/{name}')]
    public function productLink(Request $request, string $sku, string $name ): Response
    {
     
        return $this->render('content/link.html.twig', [
            'sku' => $sku,
            'name' => $name,
           
            ]);
    }

    public function TrafficAction(Request $request): Response
    {
        $locale = $request->getLocale(); 
        $language = $this->document->getProperty("language");
        $doc = \Pimcore\Model\Document::getById(1);
        $language = $doc->getProperty("language");
        // echo '<pre>';
        // print_r($language);
        // echo '</pre>';
        // die;
        return $this->render('content/traffic.html.twig');
    }

    public function ContactAction(Request $request): Response
    {
        return $this->render('content/contact.html.twig');
    }

    public function IncidentAction(Request $request): Response
    {
        $image = Asset::getById(11);

        // var_dump($image);
        // die;
        $class = DataObject\ClassDefinition::getById('incident');
        $fields = $class->getFieldDefinitions();

        foreach ($fields as $field) {
            $field->setLocked(true);
        }

        $class->save();

        $getrelation = Incident::getById(7);
        $getlocation = Location::getById(8);
        $getrelation->setPlaceid($getlocation);
//         echo '<pre>';
//         print_r($getrelation);
//         echo '</pre>';
//         die;
        return $this->render('content/incidents.html.twig',['getrelation' => $getrelation]);
    }

    #[Route('/testblock',name:'test_render')]
    public function BlogAction(Request $request): Response
    {
       
        //TO FETCH THE TRANSLATED LANGUAGE
        $locale = $request->getLocale(); 
 
        $language = $this->document->getProperty("language");
        
        $doc = \Pimcore\Model\Document::getById(10);
       
        $language = $doc->getProperty("language");


        //echo '<pre>';
        // print_r($language);
        // echo '</pre>';
        // die;

        $dataToPass = [];
        $fieldToPass = [];
        //setting DATA OF OBJECT BRICK using API
        $object = Block::getById(6);

        // echo '<pre>';
        // print_r($object);
        // echo '</pre>';
        // die;
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
//            $item->setLocked(true);
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
            'blockData' => $blockData,'dataToPass' => $dataToPass , 'fieldToPass' => $fieldToPass , 'object'  => $object , 'language' => $language]);
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


 public function ImageGalleryAction(Request $request, TranslatorInterface $translator): Response
 {
    $videoAsset = Asset::getById(39);
    // echo "<pre>";
    // print_r($video);
    // echo "</pre>";
    // die;
     $translatedLegalNotice = $translator->trans("legal_notice");
        $siteName = "Demo"; // or get dynamically
        // variable interpolation, 'about' translates to 'About {{siteName}}'
        $translatedAbout = $translator->trans("about", ['siteName' => $siteName]);
    return $this->render('content/gallery.html.twig',['videoAsset' => $videoAsset]);

 }

}
