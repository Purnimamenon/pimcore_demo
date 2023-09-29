<?php
namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;

class Testbrick extends AbstractTemplateAreabrick
{
    public function getName(): string
    {
        return 'Test-brick';
    }

   
}

?>