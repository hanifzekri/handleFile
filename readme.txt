# handleFile PHP Class

**handleFile** is a PHP class designed to handle various file operations including file validation, size conversion, mime type detection, animation detection, image resizing, watermarking, and cropping. This class simplifies the process of handling files, making it easier to work with different file types in PHP applications.

- **Author:** Hanif Zekri Astaneh
- **Author URI:** [https://hanifzekri.com](https://hanifzekri.com)
- **Author Email:** hanif.zekri@gmail.com
- **License:** [GPLv3 or later](http://www.gnu.org/licenses/gpl-3.0.html)

## Usage

To use the `handleFile` class, include the class in your PHP file and create an instance of the class.

```php
include 'handleFile.php';

$fileHandler = new handleFile();
```

## Methods

### 1. `getFile($file)`

This method takes a file path as a parameter and validates if the file exists. If the file exists, it returns the sanitized file path. If not, it returns `false`.

### 2. `size($format = 'k', $round = 0)`

This method returns the file size in the specified format ('k' for kilobytes, 'm' for megabytes, 'g' for gigabytes). By default, it returns the size in kilobytes. The `$round` parameter specifies the number of decimal places to round the size.

### 3. `mime()`

This method detects the mime type of the file using finfo or mime_content_type functions. It returns the detected mime type if successful, otherwise, it returns `false`.

### 4. `isAnimate()`

This method detects if a GIF file is an animated GIF. It returns `true` if the GIF is animated, otherwise, it returns `false`.

### 5. `upload($locat = '', $newName = '')`

This method uploads the file to the specified location. If no location is provided, the file is uploaded to the current directory. It also accepts an optional parameter for the new file name. If successful, it returns the new file path. If not, it returns `false`.

### 6. `resize($newWidth, $copySuffix = '', $compress = 90)`

This method resizes an image to the specified width while maintaining its aspect ratio. It accepts an optional parameter for a suffix to add to the copied file. It also accepts a compression level parameter for JPEG files (default is 90). It returns the path of the resized image if successful, otherwise, it returns `false`.

### 7. `watermark($watermark, $sizeRate = 30, $compress = 90, $positionX = 'left', $positionY = 'bottom')`

This method adds a watermark to the image. It accepts the path to the watermark image, a size rate (default is 30%), compression level (default is 90), and optional parameters for the watermark position (default is 'left' and 'bottom'). It returns the path of the watermarked image if successful, otherwise, it returns `false`.

### 8. `crop($targetWidth, $targetHeight, $copySuffix = '', $from = 'center', $compress = 90)`

This method crops the image to the specified width and height. It also accepts optional parameters for a suffix to add to the copied file, crop position (default is 'center'), and compression level (default is 90). It returns the path of the cropped image if successful, otherwise, it returns `false`.

## Example Usage

```php
$fileHandler = new handleFile();
$fileHandler->getFile('example.jpg');
$fileHandler->size('m');
$fileHandler->mime();
$fileHandler->isAnimate();
$fileHandler->upload('uploads/');
$fileHandler->resize(300, '_resized');
$fileHandler->watermark('watermark.png', 50);
$fileHandler->crop(200, 200, '_cropped', 'center');
```

For detailed usage examples, please refer to the provided code samples and comments within the `handleFile` class file.
