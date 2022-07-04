<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mime\MimeTypes;

class ImageUploadService
{
    private $params;
    private $filename;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @param string $base64_image
     * @return string absolute path of converted file
     */
    public function storeBase64Image(string $base64_image, $prefix = 'image_'): string
    {
        $this->filename = uniqid($prefix, true);

        $filePath = $this->uploadPath();

        $file = fopen($filePath, 'wb');

        $data = explode(',', $base64_image);

        fwrite($file, base64_decode($data[1]));
        fclose($file);

        $extension = $this->findExtension($filePath);

        rename($filePath, $filePath.'.'.$extension);

        return $this->webPath();
    }

    /**
     * @param string $url
     * @return string absolute path of converted file
     */
    public function storeRemoteImage(string $url, $prefix = 'image_'): string
    {
        $content = file_get_contents($url);
        return $this->storeImage($content);
    }

    public function storeImage($content, $prefix = 'image_') {
        $this->filename = uniqid($prefix, true);

        $filePath = $this->uploadPath();

        $file = fopen($filePath, 'wb');
        fwrite($file, $content);
        fclose($file);

        $extension = $this->findExtension($filePath);

        rename($filePath, $filePath.'.'.$extension);

        return $this->webPath();
    }

    /**
     * @return string
     */
    private function uploadPath(): string
    {
        return $this->params->get('uploads_base_path').'/'.$this->filename;
    }

    /**
     * @param string $filePath
     * @return string
     */
    private function findExtension(string $filePath): string
    {
        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($filePath);
        $extensions = $mimeTypes->getExtensions($mimeType);

        return reset($extensions);
    }

    /**
     * @return string
     */
    private function webPath(): string
    {
        return $this->params->get('uploads_base_url').'/'.$this->filename;
    }

}
