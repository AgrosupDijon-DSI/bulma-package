<?php

/*
 * This file is part of the package agrosup-dijon/bulma-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace AgrosupDijon\BulmaPackage\ViewHelpers;


use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * InlineSvgViewHelper
 */
class InlineSvgViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('image', 'object', 'a FAL object');
        $this->registerArgument('src', 'string', 'a path to a file');
        $this->registerArgument('class', 'string', 'Css class for the svg');
        $this->registerArgument('width', 'string', 'Width of the svg.', false);
        $this->registerArgument('height', 'string', 'Height of the svg.', false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \Exception
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )
    {
        $src = (string)$arguments['src'];
        $image = $arguments['image'];

        if (($src === '' && $image === null) || ($src !== '' && $image !== null)) {
            throw new \Exception('You must either specify a string src or a File object.', 1530601100);
        }

        try {
            $imageService = self::getImageService();
            $image = $imageService->getImage($src, $image, false);
            if ($image->getProperty('extension') !== 'svg') {
                return '';
            }

            $svgContent = $image->getContents();
            $svgContent = trim(preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/i', '', $svgContent));

            // Exit if file does not contain content
            if (empty($svgContent)) {
                return '';
            }

            // Disables the functionality to allow external entities to be loaded when parsing the XML, must be kept
            $previousValueOfEntityLoader = libxml_disable_entity_loader(true);
            $svgElement = simplexml_load_string($svgContent);
            libxml_disable_entity_loader($previousValueOfEntityLoader);

            // Override css class
            $svgElement = self::setAttribute($svgElement, 'class', filter_var(trim((string)$arguments['class']), FILTER_SANITIZE_STRING));
            $svgElement = self::setAttribute($svgElement, 'width', (int)$arguments['width']);
            $svgElement = self::setAttribute($svgElement, 'height', (int)$arguments['height']);

            // remove xml version tag
            $domXml = dom_import_simplexml($svgElement);
            return $domXml->ownerDocument->saveXML($domXml->ownerDocument->documentElement);
        } catch (ResourceDoesNotExistException $e) {
            // thrown if file does not exist
            throw new \Exception($e->getMessage(), 1530601100, $e);
        } catch (\UnexpectedValueException $e) {
            // thrown if a file has been replaced with a folder
            throw new \Exception($e->getMessage(), 1530601101, $e);
        } catch (\RuntimeException $e) {
            // RuntimeException thrown if a file is outside of a storage
            throw new \Exception($e->getMessage(), 1530601102, $e);
        } catch (\InvalidArgumentException $e) {
            // thrown if file storage does not exist
            throw new \Exception($e->getMessage(), 1530601103, $e);
        }
    }

    /**
     * @param \SimpleXMLElement $element
     * @param string $attribute
     * @param mixed $value
     */
    protected static function setAttribute(\SimpleXMLElement $element, $attribute, $value): \SimpleXMLElement
    {
        if ($value) {
            if (isset($element->attributes()->$attribute)) {
                $element->attributes()->$attribute = $value;
            } else {
                $element->addAttribute($attribute, $value);
            }
        }

        return $element;
    }

    /**
     * Return an instance of ImageService using object manager
     *
     * @return ImageService
     */
    protected static function getImageService()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        return $objectManager->get(ImageService::class);
    }
}