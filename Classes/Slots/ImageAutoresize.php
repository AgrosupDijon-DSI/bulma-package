<?php
declare(strict_types = 1);

namespace AgrosupDijon\BulmaPackage\Slots;

class ImageAutoresize
{
    public function postProcessConfiguration(array &$configuration)
    {
        $configuration['file_types'] = 'jpg,jpeg,png,gif';
        $configuration['max_width'] = '1920';
        $configuration['max_height'] = '1080';
        $configuration['max_size'] = '10M';
    }
}