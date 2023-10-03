# Handlefile Class Readme

The `handlefile` class in this PHP code provides a set of methods to perform various operations on files, including obtaining file information, resizing images, adding watermarks, and cropping images. This README file is intended to provide an overview of the class, its methods, and how to use them.

- **Author:** Hanif Zekri Astaneh
- **Author URI:** [https://hanifzekri.com](https://hanifzekri.com)
- **Author Email:** hanif.zekri@gmail.com
- **License:** [GPLv3 or later](http://www.gnu.org/licenses/gpl-3.0.html)

## Table of Contents

1. [Introduction](#introduction)
2. [Methods](#methods)
    - [getFile](#getfile)
    - [size](#size)
    - [mime](#mime)
    - [isAnimate](#isanimate)
    - [upload](#upload)
    - [resize](#resize)
    - [watermark](#watermark)
    - [crop](#crop)
3. [Usage](#usage)
4. [License](#license)

---

## Introduction

The `handlefile` class is designed to handle various file operations, particularly for image files. It allows you to retrieve file information such as file size and MIME type, perform resizing, add watermarks, and crop images.

## Methods

### getFile

```php
getFile($file)
```

This method accepts a file path as a parameter and sets the internal `$file` property to the provided path if the file exists. It returns the file path if successful or `false` if the file does not exist.

### size

```php
size($format='k', $round=0)
```

The `size` method calculates the file size and provides it in different formats, such as kilobytes (k), megabytes (m), or gigabytes (g). You can specify the desired format and the number of decimal places to round the result to. It returns the file size in the specified format.

### mime

```php
mime($filename)
```

The `mime` method determines the MIME type of the file based on its content. It utilizes a predefined list of MIME type associations and various methods to identify the MIME type. It returns the detected MIME type if successful or `false` if it cannot determine the MIME type.

### isAnimate

```php
isAnimate()
```

The `isAnimate` method checks whether an image is an animated GIF by analyzing its frames. It returns `true` if the image is animated or `false` if it's not animated.

### upload

```php
upload($locat, $newName='')
```

The `upload` method allows you to copy the file to a new location and optionally rename it. You can specify the target directory (`$locat`) and the new name for the file (`$newName`). If `$newName` is not provided, a unique name will be generated. It returns the new file path if successful or `false` if the operation fails.

### resize

```php
resize($newWidth, $copySuffix='', $compress=90)
```

The `resize` method resizes image files to a specified width while maintaining the aspect ratio. You can specify the target width (`$newWidth`), an optional suffix to add to the copied file (`$copySuffix`), and a compression quality value (`$compress`). It returns the path of the resized image if successful or `false` if the operation fails.

### watermark

```php
watermark($watermark, $sizeRate=30, $compress=90, $positionX='left', $positionY='bottom')
```

The `watermark` method adds a watermark image to another image. You can specify the watermark image file (`$watermark`), the size rate as a percentage of the target image size (`$sizeRate`), the compression quality (`$compress`), and the position for the watermark (`$positionX` and `$positionY`). It returns the path of the watermarked image if successful or `false` if the operation fails.

### crop

```php
crop($targetWidth, $targetHeight, $from='center')
```

The `crop` method allows you to crop an image to a specified width and height. You can also specify the cropping position (`$from`) relative to the original image. It returns the path of the cropped image if successful or `false` if the operation fails.

## Usage

To use the `handlefile` class, you should include it in your PHP script and create an instance of the class. You can then call the various methods to perform file operations on the specified file.

Here's a basic example of how to use the `handlefile` class:

```php
// Include the handlefile class
require_once('handlefile.php');

// Create an instance of the class
$fileHandler = new handlefile();

// Set the file to be processed
$fileHandler->getFile('path/to/your/file.jpg');

// Get file information
$fileSize = $fileHandler->size();
$fileMime = $fileHandler->mime();
$isAnimated = $fileHandler->isAnimate();

// Perform other operations like resizing or watermarking
// $fileHandler->resize(200);
// $fileHandler->watermark('watermark.png');
```

Please note that you should replace `'path/to/your/file.jpg'` with the actual file path you want to work with and adapt the usage to your specific needs.

## License

This code is provided under an open-source license. You can find the licensing details in the code file itself or in the accompanying license file.

---

Feel free to explore and use the `handlefile` class to manage and manipulate files, especially images, in your PHP projects. If you encounter any issues or have questions, refer to the code comments or the documentation for further guidance.