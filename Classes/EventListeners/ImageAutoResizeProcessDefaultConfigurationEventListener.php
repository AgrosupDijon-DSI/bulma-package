<?php

namespace AgrosupDijon\BulmaPackage\EventListeners;

use Causal\ImageAutoresize\Event\ProcessDefaultConfigurationEvent;

final class ImageAutoResizeProcessDefaultConfigurationEventListener
{
    public function __invoke(ProcessDefaultConfigurationEvent $event): void
    {
        $event->setConfiguration($this->getDefaultConfiguration());
    }

    private function getDefaultConfiguration(): array
    {
        return [
            'directories' => 'fileadmin/,uploads/',
            'file_types' => 'jpg,jpeg,png,gif',
            'threshold' => '400K',
            'max_width' => '1920',
            'max_height' => '1280',
            'max_size' => '10M',
            'auto_orient' => true,
            'conversion_mapping' => implode(',', [
                'ai => jpg',
                'bmp => jpg',
                'pcx => jpg',
                'tga => jpg',
                'tif => jpg',
                'tiff => jpg',
            ]),
        ];
    }
}