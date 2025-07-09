<?php
class resize
{
    private $image;
    private $width;
    private $height;
    private $imageResized;

    public function __construct($fileName)
    {
        $this->image = $this->openImage($fileName);

        if (!$this->image) {
            throw new Exception("❌ No se pudo cargar la imagen.");
        }

        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function openImage($file)
    {
        if (!file_exists($file)) {
            throw new Exception("❌ El archivo no existe: $file");
        }

        if (!getimagesize($file)) {
            throw new Exception("❌ El archivo no es una imagen válida: $file");
        }

        $extension = strtolower(strrchr($file, '.'));
        $img = false;

        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($file);
                break;
            case '.gif':
                $img = @imagecreatefromgif($file);
                break;
            case '.png':
                $img = @imagecreatefrompng($file);
                break;
            default:
                throw new Exception("❌ Formato de imagen no soportado: $extension");
        }

        if (!$img) {
            throw new Exception("❌ Error al procesar la imagen con GD.");
        }

        return $img;
    }

    public function resizeImage($newWidth, $newHeight, $option = "auto")
    {
        $optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));
        $optimalWidth = $optionArray['optimalWidth'];
        $optimalHeight = $optionArray['optimalHeight'];

        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);

        imagecopyresampled(
            $this->imageResized,
            $this->image,
            0, 0, 0, 0,
            $optimalWidth, $optimalHeight,
            $this->width, $this->height
        );

        if ($option === 'crop') {
            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }
    }

    private function getDimensions($newWidth, $newHeight, $option)
    {
        switch ($option) {
            case 'exact':
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
                break;
            case 'landscape':
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            default:
                throw new Exception("❌ Opción de redimensionamiento no válida: $option");
        }

        return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
    }

    private function getSizeByFixedHeight($newHeight)
    {
        $ratio = $this->width / $this->height;
        return $newHeight * $ratio;
    }

    private function getSizeByFixedWidth($newWidth)
    {
        $ratio = $this->height / $this->width;
        return $newWidth * $ratio;
    }

    private function getSizeByAuto($newWidth, $newHeight)
    {
        if ($this->height < $this->width) {
            $optimalWidth = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
        } elseif ($this->height > $this->width) {
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
        } else {
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } elseif ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
            }
        }

        return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
    }

    private function getOptimalCrop($newWidth, $newHeight)
    {
        $heightRatio = $this->height / $newHeight;
        $widthRatio = $this->width / $newWidth;

        $optimalRatio = min($heightRatio, $widthRatio);

        return [
            'optimalWidth' => $this->width / $optimalRatio,
            'optimalHeight' => $this->height / $optimalRatio
        ];
    }

    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
    {
        $cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
        $cropStartY = ($optimalHeight / 2) - ($newHeight / 2);

        $crop = $this->imageResized;
        $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled(
            $this->imageResized,
            $crop,
            0, 0,
            $cropStartX, $cropStartY,
            $newWidth, $newHeight,
            $newWidth, $newHeight
        );
    }

    public function saveImage($savePath, $imageQuality = "100")
    {
        $extension = strtolower(strrchr($savePath, '.'));

        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;
            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;
            case '.png':
                $scaleQuality = round(($imageQuality / 100) * 9);
                $invertScaleQuality = 9 - $scaleQuality;
                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $savePath, $invertScaleQuality);
                }
                break;
            default:
                throw new Exception("❌ No se pudo guardar la imagen: formato no soportado.");
        }

        imagedestroy($this->imageResized);
    }
}
?>