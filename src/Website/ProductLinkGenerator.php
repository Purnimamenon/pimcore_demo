<?php

namespace App\Website\LinkGenerator;

//use App\Model\Product\AccessoryPart;
//use App\Model\Product\Car;
//use App\Website\Tool\Text;
//use Pimcore\Bundle\EcommerceFrameworkBundle\Model\ProductInterface;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
//use Pimcore\Bundle\EcommerceFrameworkBundle\Model\DefaultMockup;

class ProductLinkGenerator extends AbstractProductLinkGenerator implements LinkGeneratorInterface
{
    public function generate(Concrete $object, array $params = []): string
    {
        if (!($object instanceof Car || $object instanceof AccessoryPart)) {
            throw new \InvalidArgumentException('Given object is no Car');
        }

        return $this->doGenerate($object, $params);
    }

    public function generateWithMockup(ProductInterface $object, array $params = []): string
    {
        return $this->doGenerate($object, $params);
    }

    protected function doGenerate(ProductInterface $object, array $params): string
    {
        return DataObject\Service::useInheritedValues(true, function () use ($object, $params) {
            return $this->pimcoreUrl->__invoke(
                [
                    'productname' => Text::toUrl($object->getOSName() ? $object->getOSName() : 'product'),
                    'product' => $object->getId(),
                    'path' => $this->getNavigationPath($object->getMainCategory(), $params['rootCategory'] ?? null),
                    'page' => null
                ],
                'shop-detail',
                true
            );
        });
    }
}
