<?php
namespace App\Website\TestGenerator;



use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;



class TestGenerator implements LinkGeneratorInterface
{
 public function generate($object, array $params = []): string
 {
 if (!($object instanceof DataObject\Product)) {
 throw new \InvalidArgumentException('Given object is not a Room');
 }

 $customUrl = $this->generateCustomUrl($object);

 return $customUrl;
 }

 public function generateCustomUrl(DataObject\Product $object): string
 {
 $product = $object->getSku();
 $name = $object->getName();

 $customUrl = '/'.$product.'/'.$name;

 
 return $customUrl;


 }
}