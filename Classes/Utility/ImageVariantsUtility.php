<?php

declare(strict_types=1);

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\Utility;

/**
 * Calculate image variants
 */
class ImageVariantsUtility
{
    /**
     * @var array
     */
    protected static $allowedVariantProperties = [
        'breakpoint',
        'width',
        'sizes',
    ];

    /**
     * @var array
     */
    protected static $defaultVariants = [
        'default' => [
            'breakpoint' => 1408,
            'width' => 1920,
        ],
        'widescreen' => [
            'breakpoint' => 1216,
            'width' => 1407,
        ],
        'desktop' => [
            'breakpoint' => 1024,
            'width' => 1215,
        ],
        'tablet' => [
            'breakpoint' => 769,
            'width' => 1023,
        ],
        'mobile' => [
            'breakpoint' => 577,
            'width' => 768,
        ],
        'mobile-small' => [
            'width' => 576,
        ],
    ];

    /**
     * @param array|null $variants
     * @param array|null $multiplier
     * @param array|null $gutters
     * @param array|null $corrections
     * @return array
     */
    public static function getImageVariants(?array $variants = null, ?array $multiplier = null, ?array $gutters = null, ?array $corrections = null): array
    {
        $variants = $variants !== null ? $variants : [];
        $variants = self::processVariants($variants);
        $variants = self::processResolutions($variants);
        if ($gutters !== null) {
            $variants = self::removeGutters($variants, $gutters);
        }
        if ($multiplier !== null) {
            $variants = self::processMultiplier($variants, $multiplier);
        }
        if ($corrections !== null) {
            $variants = self::processCorrections($variants, $corrections);
        }
        return $variants;
    }

    /**
     * @param array $variants
     * @return array
     */
    protected static function processResolutions($variants): array
    {
        foreach ($variants as $variant => $properties) {
            if (!array_key_exists('sizes', $properties)) {
                $properties['sizes'] = [];
            }
            $properties['sizes'] = self::processSizes($properties['sizes']);
            $variants[$variant] = $properties;
        }
        return $variants;
    }

    /**
     * @param array $sizes
     * @return array
     */
    protected static function processSizes(array $sizes): array
    {
        $resultSizes = [];
        $workingSizes = [];
        if (!isset($sizes['1x'])) {
            $sizes['1x'] = ['multiplier' => 1];
        }
        foreach ($sizes as $key => $settings) {
            if (!array_key_exists('multiplier', $settings) ||
                !is_numeric($settings['multiplier']) ||
                $settings['multiplier'] < 1 ||
                !self::isValidSizeKey($key)
            ) {
                continue;
            }
            $workingSizes[substr($key, 0, -1) . ''] = [
                'multiplier' => 1 * $settings['multiplier'],
            ];
        }
        ksort($workingSizes);
        foreach ($workingSizes as $workingKey => $workingSettings) {
            $resultSizes[$workingKey . 'x'] = $workingSettings;
        }
        return $resultSizes;
    }

    /**
     * @param array $variants
     * @return array
     */
    protected static function processVariants($variants): array
    {
        $variants = is_array($variants) && !empty($variants) ? $variants : self::$defaultVariants;
        foreach ($variants as $variant => $properties) {
            if (!is_array($properties)) {
                unset($variants[$variant]);
                continue;
            }
            foreach ($properties as $key => $value) {
                if (!in_array($key, self::$allowedVariantProperties, true)) {
                    unset($variants[$variant][$key]);
                    continue;
                }
                if ($key === 'sizes') {
                    continue;
                }
                if (is_numeric($value) && $value > 0) {
                    $variants[$variant][$key] = (int)$value;
                } else {
                    unset($variants[$variant][$key]);
                }
            }
            if (empty($variants[$variant]) || !isset($variants[$variant]['width'])) {
                unset($variants[$variant]);
            }
        }
        return $variants;
    }

    /**
     * @param array $variants
     * @param array $gutters
     * @return array
     */
    protected static function removeGutters(array $variants, array $gutters): array
    {
        foreach ($gutters as $variant => $value) {
            if (is_numeric($value) && $value > 0 && isset($variants[$variant]['width'])) {
                $variants[$variant]['width'] = (int)ceil($variants[$variant]['width'] - $value);
            }
        }
        return $variants;
    }
    /**
     * @param array $variants
     * @param array $multiplier
     * @return array
     */
    protected static function processMultiplier(array $variants, array $multiplier): array
    {
        foreach ($multiplier as $variant => $value) {
            if (is_numeric($value) && $value > 0 && isset($variants[$variant]['width'])) {
                $variants[$variant]['width'] = (int)ceil($variants[$variant]['width'] * $value);
            }
        }
        return $variants;
    }
    /**
     * @param array $variants
     * @param array $corrections
     * @return array
     */
    protected static function processCorrections(array $variants, array $corrections): array
    {
        foreach ($corrections as $variant => $value) {
            if (is_numeric($value) && $value > 0 && isset($variants[$variant]['width'])) {
                $variants[$variant]['width'] -= $value;
            }
        }
        return $variants;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public static function isValidSizeKey($key): bool
    {
        return !(
            !is_string($key) ||
            substr($key, -1, 1) !== 'x' ||
            !is_numeric(substr($key, 0, -1)) ||
            (float)substr($key, 0, -1) < 1 ||
            (float)substr($key, 0, -1) !== round((float)substr($key, 0, -1), 1)
        );
    }
}
