<?php
spl_autoload_register(function ($class) {
    include "../models/" . $class . ".php";
});

class MediaController
{
    public $msg2 = array(
        "id" => "",
        "text" => "",
    );

    protected $image;
    protected $imageType;
    protected $imageWidth;
    protected $imageHeight;

    // Bytes equivalences
    public const TB = 1099511627776;
    public const GB = 1073741824;
    public const MB = 1048576;
    public const KB = 1024;


    // Images path
    public const MEDIAPATH = "../views/web/img/media/";
    public const AVATARPATH = "../views/web/img/avatars/";

    // Image functions
    public function load($imageFile)
    {
        $image_info = getimagesize($imageFile['tmp_name']);
        $this->imageType = $image_info[2];

        if ($this->imageType == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($imageFile['tmp_name']);
        } elseif ($this->imageType == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($imageFile['tmp_name']);
        } elseif ($this->imageType == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($imageFile['tmp_name']);
        }
    }
    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 100)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            return imagejpeg($this->image, $filename, $compression);
        } else if ($image_type == IMAGETYPE_GIF) {
            return imagegif($this->image, $filename);
        } else if ($image_type == IMAGETYPE_PNG) {
            return imagepng($this->image, $filename);
        } else return false;
    }
    public function isImageTheSupportedType($imgType)
    {
        if (($imgType == "image/jpeg" ||
            $imgType == "image/jpg"   ||
            $imgType == "image/png"   ||
            $imgType == "image/gif")) {
            return true;
        } else {
            return false;
        }
    }
    // File image format is Bytes
    public function isImageBiggerThan2MB($imageSize)
    {
        if ($imageSize > 2 * self::MB) {
            return true;
        }
        return false;
    }
    // We have to provide the image name in order to get the image dimensions
    public function getImageRatio($imageName)
    {
        $this->imageWidth = $this->getImageWidth($imageName);
        $this->imageHeight = $this->getImageHeight($imageName);

        return $this->imageWidth / $this->imageHeight;
    }

    public function getImageWidth($imageName)
    {
        $imageWidth = getimagesize($imageName)[0]; // Position 0 of the array is the Width
        return $imageWidth;
    }
    public function getImageHeight($imageName)
    {
        $imageHeight = getimagesize($imageName)[1]; // Position 1 of the array is the Height
        return $imageHeight;
    }
    public function scaleImageToPostWidthAndSave($imageFile, &$imgFileName)
    {
        $isImageSaved = false;
        // 1: We create a new image from file
        $this->load($imageFile);
        // 2: We define the new dimensions of the image
        if ($this->imageWidth < 700) { // If the image is equal to 554 or less, but not too big, we don't scale the image
            $width = $this->imageWidth;
        } else { // If the image is bigger, we set a maximim width height
            $width = 700;
        }
        // width we want the new image to have
        $ratio = $width / $this->imageWidth;    // we calculate the ratio to get the proportional height
        $height = $this->imageHeight * $ratio;
        // 3: We create a new true color image
        $new_image = imagecreatetruecolor($width, $height);
        // 4: We Copy and resize part of an image with resampling
        imagecopyresampled(
            $new_image,
            $this->image,
            0,
            0,
            0,
            0,
            $width,
            $height,
            imagesx($this->image),
            imagesy($this->image)
        );
        $this->image = $new_image;
        // 5: We define a unique name
        $prefix = uniqid();
        $imgFileName = $prefix . '_' . strtolower($imageFile['name']);
        // 6: We save the image on the images path folder
        $isImageSaved = $this->save("" . self::MEDIAPATH . $imgFileName . "");
        // 7: We destroy the temporary image
        imagedestroy($new_image);
        return $isImageSaved;
    }
    public function cropScaleAndSaveAvatar($imageFile, &$imgFileName)
    {
        $isImageSaved = false;
        // 1: We create a new image from file
        $this->load($imageFile);
        // 2: we define its width and height
        $width = $this->imageWidth;
        $height = $this->imageHeight;
        $size = min($width, $height); // we take the shortest image side
        // 3: CROPPING - We crop the image in the middle, except if it's a square image
        if ($width == $height) { // square avatar
            $new_avatar = imagecrop($this->image, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
        } else if ($width > $height) {
            $x = ($width / 2) - ($height / 2);
            $new_avatar = imagecrop($this->image, ['x' => $x, 'y' => 0, 'width' => $size, 'height' => $size]);
        } else if ($width < $height) {
            $y = ($height / 2) - ($width / 2);
            $new_avatar = imagecrop($this->image, ['x' => 0, 'y' => $y, 'width' => $size, 'height' => $size]);
        }
        // 4: we save the image in the property
        // We create a new true color image
        $this->image = $new_avatar;

        // 5: RESIZING - we create a copy image 
        $new_image = imagecreatetruecolor(120, 120);
        // 6: We resize the square image to 120x120 px
        imagecopyresampled(
            $new_image,
            $this->image,
            0,
            0,
            0,
            0,
            120,
            120,
            imagesx($this->image),
            imagesy($this->image)
        );
        // 7: We save the result image
        $this->image = $new_image;

        // 8: We define a unique name
        $prefix = uniqid();
        $imgFileName = $prefix . '_' . strtolower($imageFile['name']);
        // 9: We save the image on the images path folder
        $isImageSaved = $this->save("" . self::AVATARPATH . $imgFileName . "");
        // 10: We destroy the temporary images
        imagedestroy($new_avatar);
        imagedestroy($new_image);
        return $isImageSaved;
    }
    public function saveOriginalImage($imageFile, &$imgFileName)
    {
        // We add a unique string as a prefix to the file name
        $prefix = uniqid();
        $imgFileName = $prefix . '_' . strtolower($imageFile['name']);
        $isImageUploaded = move_uploaded_file($imageFile['tmp_name'], self::MEDIAPATH . $imgFileName);
        return $isImageUploaded;
    }
}
