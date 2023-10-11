<?php
namespace App\Website;

use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\Product;;

class TestGenerator implements LinkGeneratorInterface {
    public function generate(object $object, array $params = []): string
    {
    if (!$object instanceof Product) {
    throw new \InvalidArgumentException('Invalid object type. Expected Product.');
    }
   
    // Use the SKU and name of the product to generate a URL.
    $sku = $object->getSku();
    $name = $object->getName();
   
    $slug = $this->generateSlug($sku, $name);
   
    // Return the generated URL.
    return '/products/' . $slug;
    }
   
    protected function generateSlug($sku, $name)
    {
  
    return strtolower('watch/' . $sku . '/'. $name);
    
    }
}