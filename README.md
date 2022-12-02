# Imager Service

Image processor interface for PHP applications using [Intervention Image](https://github.com/Intervention/image) as default processor.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Basic Usage](#basic-usage)
        - [Create Imager](#create-imager)
        - [Image Processing](#image-processing)
    - [Resource](#resource)
        - [Base64 Resource](#base64-resource)
        - [Binary Resource](#binary-resource)
        - [Data Url Resource](#data-url-resource)
        - [File Resource](#file-resource)
        - [Stream Resource](#stream-resource)
        - [Url Resource](#url-resource)
    - [Action](#action)
        - [Background](#background)
        - [Blur](#blur)
        - [Brightness](#brightness)
        - [Colorize](#colorize)
        - [Contrast](#contrast)
        - [Crop](#crop)
        - [Encode](#encode)
        - [Fit](#fit)
        - [Flip](#flip)
        - [Gamma](#gamma)
        - [Greyscale](#greyscale)
        - [Orientate](#orientate)
        - [Pixelate](#pixelate)
        - [Resize](#resize)
        - [Rotate](#rotate)
        - [Sepia](#sepia)
        - [Save](#save)
        - [Sharpen](#sharpen)
    - [Response](#response)
        - [Encoded Response](#encoded-response)
        - [File Response](#file-response)
    - [Advanced Usage](#advanced-usage)
        - [Grouping Actions](#grouping-actions)
        - [Creating New Action](#creating-new-action)
        - [Actions To Messages](#actions-to-messages)
    - [Interfaces](#interfaces)
        - [Imager Factory Interface](#imager-factory-interface)
        - [Imager Interface](#imager-interface)
        - [Processor Factory Interface](#processor-factory-interface)
        - [Processor Interface](#processor-interface)
        - [Resource Interface](#resource-interface)
        - [Action Interface](#action-interface)
        - [Actions Interface](#actions-interface)
        - [Response Interface](#response-interface)
    - [Intervention Image](#intervention-image)
        - [Intervention Imager Factory](#intervention-imager-factory)
        - [Intervention Processor Factory](#intervention-processor-factory)
- [Credits](#credits)
___

# Getting started

Add the latest version of the imager service project running this command.

```
composer require tobento/service-imager
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

# Documentation

## Basic Usage

### Create Imager

```php
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\ImagerInterface;

$imager = (new ImagerFactory())->createImager();

var_dump($imager instanceof ImagerInterface);
// bool(true)
```

Check out the [Imager Interface](#imager-interface) to learn more about the interface.

### Image Processing

```php
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\Resource\File;
use Tobento\Service\Imager\Action;

$response = $imager
    ->resource(new File('path/image.jpg'))
    ->action(new Action\Crop(width: 200, height: 200))
    ->action(new Action\Save('path/image.webp'));
    
var_dump($response instanceof ResponseInterface);
// bool(true)
```

Check out the [Resource](#resource) section for available resources.

Check out the [Action](#action) section for available actions and its response type.

Check out the [Response](#response) section for response details.

**You might be using the corresponding methods instead**

```php
$response = $imager
    ->file('path/image.jpg')
    ->crop(width: 200, height: 200)
    ->save('path/image.webp');
```

## Resource

### Base64 Resource

```php
use Tobento\Service\Imager\Resource\Base64;
use Tobento\Service\Imager\ResourceInterface;

$resource = new Base64(
    data: 'Base64 encoded image data'
);

var_dump($resource instanceof ResourceInterface);
// bool(true)

var_dump($resource->data());
// string(25) "Base64 encoded image data"
```

### Binary Resource

```php
use Tobento\Service\Imager\Resource\Binary;
use Tobento\Service\Imager\ResourceInterface;

$resource = new Binary(
    data: 'Binary image data'
);

var_dump($resource instanceof ResourceInterface);
// bool(true)

var_dump($resource->data());
// string(17) "Binary image data"
```

### Data Url Resource

```php
use Tobento\Service\Imager\Resource\DataUrl;
use Tobento\Service\Imager\ResourceInterface;

$resource = new DataUrl(
    data: 'Data-URL encoded image data'
);

var_dump($resource instanceof ResourceInterface);
// bool(true)

var_dump($resource->data());
// string(27) "Data-URL encoded image data"
```

### File Resource

```php
use Tobento\Service\Imager\Resource\File;
use Tobento\Service\Filesystem\File as BaseFile;
use Tobento\Service\Imager\ResourceInterface;

$resource = new File(
    file: 'path/image.jpg' // string|BaseFile
);

var_dump($resource instanceof ResourceInterface);
// bool(true)

var_dump($resource->file() instanceof BaseFile);
// bool(true)
```

You may check out the [Filesystem Service - File](https://github.com/tobento-ch/service-filesystem#file) to learn more about it.

### Stream Resource

```php
use Tobento\Service\Imager\Resource\Stream;
use Tobento\Service\Imager\ResourceInterface;
use Psr\Http\Message\StreamInterface;

$resource = new Stream(
    stream: $stream // StreamInterface
);

var_dump($resource instanceof ResourceInterface);
// bool(true)

var_dump($resource->stream() instanceof StreamInterface);
// bool(true)
```

### Url Resource

```php
use Tobento\Service\Imager\Resource\Url;
use Tobento\Service\Imager\ResourceInterface;

$resource = new Url(
    url: 'https://www.example.com/image.jpg'
);

var_dump($resource instanceof ResourceInterface);
// bool(true)

var_dump($resource->url());
// string(33) "https://www.example.com/image.jpg"
```

## Action

### Background

Applies the specified background color for transparent images.

```php
use Tobento\Service\Imager\Action\Background;

$action = new Background(
    color: '#333333' // string
);

$imager->action($action);

// or using method:
$imager->background(color: '#333333');
```

### Blur

Blurs the image.

```php
use Tobento\Service\Imager\Action\Blur;

$action = new Blur(
    blur: 20 // int, between 0 and 100.
);

$imager->action($action);

// or using method:
$imager->blur(20);
```

### Brightness

Adjusts the brightness of the image.

```php
use Tobento\Service\Imager\Action\Brightness;

$action = new Brightness(
    brightness: 20 // int, between -100 and 100.
);

$imager->action($action);

// or using method:
$imager->brightness(20);
```

### Colorize

Colorizes the image.

```php
use Tobento\Service\Imager\Action\Colorize;

$action = new Colorize(
    red: 20 // int, between -100 and 100.
    green: 5 // int, between -100 and 100.
    blue: 45 // int, between -100 and 100.
);

$imager->action($action);

// or using method:
$imager->colorize(red: 20, green: 5, blue: 45);
```

### Contrast

Adjusts the contrast of the image.

```php
use Tobento\Service\Imager\Action\Contrast;

$action = new Contrast(
    contrast: 20 // int, between -100 and 100.
);

$imager->action($action);

// or using method:
$imager->contrast(20);
```

### Crop

Crops the image with the specified parameters.

```php
use Tobento\Service\Imager\Action\Crop;

$action = new Crop(width: 200, height: 200, x: 10, y: 10);

$imager->action($action);

// or using method:
$imager->crop(width: 200, height: 200, x: 10, y: 10);
```

### Encode

Encodes image to the specified mime type.

```php
use Tobento\Service\Imager\Action\Encode;
use Tobento\Service\Imager\Response\Encoded;

$action = new Encode(
    mimeType: 'image/webp',
    quality: 90, // null|int
);

$response = $imager->action($action);

// or using method:
$response = $imager->encode(mimeType: 'image/webp');

// return type:
var_dump($response instanceof Encoded);
// bool(true)
```

Check out the [Encoded Response](#encoded-response) to learn more about it.

**mimeType**

Supported mime types:

* ```image/jpeg``` or just ```jpeg```, ```jpg```
* ```image/pjpeg``` or just ```pjpeg```
* ```image/png``` or just ```png```
* ```image/gif``` or just ```gif```
* ```image/webp``` or just ```webp```
* ```image/tiff``` or just ```tiff```, ```tif```, if processor supports it
* ```image/svg+xml``` or just ```svg```, if processor supports it
* ```image/psd``` or just ```psd```, if processor supports it
* ```image/bmp``` or just ```bmp```, if processor supports it
* ```image/x-icon``` or just ```ico```, if processor supports it
* ```image/avif``` or just ```avif```, if processor supports it

**quality**

The quality for the image ranging from 0 to 100.

### Fit

Fits image to the specified width and height.

```php
use Tobento\Service\Imager\Action\Fit;

$action = new Fit(
    width: 200,
    height: 200,
    position: Fit::CENTER, // is default
    upsize: null // is default
);

$imager->action($action);

// or using method:
$imager->fit(width: 200, height: 200);
```

**position**

* ```Fit::TOP_LEFT```
* ```Fit::TOP```
* ```Fit::TOP_RIGHT```
* ```Fit::LEFT```
* ```Fit::CENTER``` is default
* ```Fit::RIGHT```
* ```Fit::BOTTOM_LEFT```
* ```Fit::BOTTOM```
* ```Fit::BOTTOM_RIGHT```

**Examples**

```php
// with upsize limit: (image width is 200)
$imager->fit(width: 300, height: 150, upsize: 1.5); // limits to 250

$imager->fit(width: 300, height: 150, upsize: 1); // limits to 200

$imager->fit(width: 300, height: 150, upsize: 0.5); // limits to 150
```

### Flip

Mirrors image horizontally or vertically.

```php
use Tobento\Service\Imager\Action\Flip;

$action = new Flip(
    flip: Flip::HORIZONTAL, // is default
);

$imager->action($action);

// or using method:
$imager->flip(flip: Flip::HORIZONTAL);
```

**flip**

* ```Flip::HORIZONTAL```
* ```Flip::VERTICAL```

### Gamma

Adjusts the gamma of the image.

```php
use Tobento\Service\Imager\Action\Gamma;

$action = new Gamma(
    gamma: 2.3 // float, between 0.01 and 9.99.
);

$imager->action($action);

// or using method:
$imager->gamma(2.3);
```

### Greyscale

Greyscales the image.

```php
use Tobento\Service\Imager\Action\Greyscale;

$action = new Greyscale();

$imager->action($action);

// or using method:
$imager->greyscale();
```

### Orientate

Auto orientates image by EXIF data to display the image correctly.

```php
use Tobento\Service\Imager\Action\Orientate;

$action = new Orientate();

$imager->action($action);

// or using method:
$imager->orientate();
```

### Pixelate

Pixelates the image.

```php
use Tobento\Service\Imager\Action\Pixelate;

$action = new Pixelate(
    pixelate: 10 // int, between 0 and 1000.
);

$imager->action($action);

// or using method:
$imager->pixelate(10);
```

### Resize

Resizes image by the specified parameters.

```php
use Tobento\Service\Imager\Action\Resize;

$action = new Resize(
    width: 200, // null|int
    height: null, // null|int
    keepRatio: true, // bool (true is default)
    upsize: null, // null|float
);

$imager->action($action);

// or using method:
$imager->resize(width: 200);
```

**Examples**

```php
// resize the image to a width of 200: (will keep aspect ratio)
$imager->resize(width: 200);

// resize the image to a height of 200: (will keep aspect ratio)
$imager->resize(height: 200);

// resize image to a fixed size:
$imager->resize(width: 200, height: 100, keepRatio: false);

// resize only the width of the image:
$imager->resize(width: 200, keepRatio: false);

// resize only the height of the image:
$imager->resize(height: 200, keepRatio: false);

// with upsize limit: (image width is 200)
$imager->resize(width: 300, upsize: 1.5); // limits to 250

$imager->resize(width: 300, upsize: 1); // limits to 200

$imager->resize(width: 300, upsize: 0.5); // limits to 150
```

### Rotate

Rotates image by the specified number of degrees clockwise and fills empty triangles left overs with the specified background color.

```php
use Tobento\Service\Imager\Action\Rotate;

$action = new Rotate(
    degrees: 20 // float, between -360 and 360.
    bgcolor: '#ffffff' // string, is default
);

$imager->action($action);

// or using method:
$imager->rotate(degrees: 20);
```

### Sepia

Adds a sepia filter to the image.

```php
use Tobento\Service\Imager\Action\Sepia;

$action = new Sepia();

$imager->action($action);

// or using method:
$imager->sepia();
```

### Save

Saves the current processed state of the image to the specified filename.

```php
use Tobento\Service\Imager\Action\Save;
use Tobento\Service\Imager\Response\File;

$action = new Save(
    filename: 'path/image.jpg',
    
    // The prioritized mimeType for the filename to save.
    mimeType: 'image/webp', // null|string
    
    quality: 90, // null|int
    
    overwrite: Save::OVERWRITE, // is default
    
    modeDir: 0755 // is default
);

$response = $imager->action($action);

// or using method:
$response = $imager->save(filename: 'path/image.jpg');

// return type:
var_dump($response instanceof File);
// bool(true)
```

Check out the [File Response](#file-response) to learn more about it.

**filename**

The filename to save the processed image.

**mimeType**

The prioritized mimeType for the filename to save. If specified the filename will change its file extension to the corresponding format.

Supported mime types:

* ```image/jpeg``` or just ```jpeg```, ```jpg```
* ```image/pjpeg``` or just ```pjpeg```
* ```image/png``` or just ```png```
* ```image/gif``` or just ```gif```
* ```image/webp``` or just ```webp```
* ```image/tiff``` or just ```tiff```, ```tif```, if processor supports it
* ```image/svg+xml``` or just ```svg```, if processor supports it
* ```image/psd``` or just ```psd```, if processor supports it
* ```image/bmp``` or just ```bmp```, if processor supports it
* ```image/x-icon``` or just ```ico```, if processor supports it
* ```image/avif``` or just ```avif```, if processor supports it

**quality**

The quality for the image ranging from 0 to 100.

**overwrite**

```php
use Tobento\Service\Imager\Action\Save;
use Tobento\Service\Imager\ActionException;
```

| Option | Description |
| --- | --- |
| ```Save::OVERWRITE``` | Allows overwriting image which is the default. |
| ```Save::OVERWRITE_UNIQUE``` | Creates unique image if exists. |
| ```Save::OVERWRITE_THROW``` | Throws ActionException if image exists. |

**modeDir**

The directory mode to create the folders from the filename if they do not exist.

### Sharpen

Sharpens the image.

```php
use Tobento\Service\Imager\Action\Sharpen;

$action = new Sharpen(
    sharpen: 20 // int, between 0 and 100.
);

$imager->action($action);

// or using method:
$imager->sharpen(20);
```

## Response

### Encoded Response

```php
use Tobento\Service\Imager\Response\Encoded;
use Tobento\Service\Imager\ResponseInterface;

$response = $imager->encode(mimeType: 'image/png');

var_dump($response instanceof ResponseInterface);
// bool(true)

var_dump($response instanceof Encoded);
// bool(true)

// returns the encoded image data:
$encodedImage = $response->encoded();
$encodedImage = (string)$response;

// Returns the base 64 encoded image data:
$base64encodedImage = $response->base64();

// Returns the data url:
$base64encodedImageDataUrl = $response->dataUrl();

// Info data:
$mimeType = $response->mimeType(); // string
$imageWidth = $response->width(); // int
$imageHeight = $response->height(); // int
$imageSize = $response->size(); // null|int
```

### File Response

The file response holds the processed image file.

```php
use Tobento\Service\Imager\Response\File;
use Tobento\Service\Filesystem\File as BaseFile;
use Tobento\Service\Imager\ResponseInterface;

$response = $imager->save(filename: 'path/image.jpg');

var_dump($response instanceof ResponseInterface);
// bool(true)

var_dump($response instanceof File);
// bool(true)

var_dump($response->file() instanceof BaseFile);
// bool(true)

// returns the width of the image:
var_dump($response->width());
// int(200)

// returns the height of the image:
var_dump($response->height());
// int(100)
```

Check out the [Response Interface](#response-interface) to learn more about it.

You may check out the [Filesystem Service - File](https://github.com/tobento-ch/service-filesystem#file) to learn more about it.

## Advanced Usage

### Grouping Actions

For reusage, you might create a group of actions to be processed.

```php
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\Action\Action;
use Tobento\Service\Imager\Action\Processable;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionException;

class SomeActions extends Action implements Processable
{
    /**
     * Create a new instance of SomeActions.
     *
     * @param int $width
     */
    public function __construct(
        private int $width
    ) {}
    
    /**
     * Process the action.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight     
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function process(
        ImagerInterface $imager,
        int $srcWidth,
        int $srcHeight
    ): ImagerInterface|ResponseInterface {
        return $imager
            ->greyscale()
            ->resize(width: $this->width);
    }

    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'width' => $this->width,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Greyscaled and resized image to width :width.';
    }
}

$imager = (new ImagerFactory())->createImager();

$response = $imager
    ->file('path/image.jpg')
    ->action(new SomeActions(width: 200))
    ->save('path/image.webp');
```

### Creating New Action

If you want to create a new action, you would need to handle each processor individually.

```php
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\InterventionImage\Processor;
use Tobento\Service\Imager\Action\Action;
use Tobento\Service\Imager\Action\Processable;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionException;

class SomeNewAction extends Action implements Processable
{
    /**
     * Create a new instance of SomeAction.
     *
     * @param int $foo
     */
    public function __construct(
        private int $foo
    ) {}
    
    /**
     * Process the action.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight     
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function process(
        ImagerInterface $imager,
        int $srcWidth,
        int $srcHeight
    ): ImagerInterface|ResponseInterface {

        if ($imager->getProcessor() instanceof InterventionImage\Processor) {            
            $image = $imager->processor()->image();
            // do something with the intervention image.
            
            return $imager;
        }
        
        // handle other processor or throw ActionException
        
        return $imager;
    }

    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return ['foo' => $this->foo];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Some new action with foo :foo processed.';
    }
}

$imager = (new ImagerFactory())->createImager();

$response = $imager
    ->file('path/image.jpg')
    ->action(new SomeNewAction(foo: 200))
    ->save('path/image.webp');
```

### Actions To Messages

You might render the descriptions of the processed actions using the messages factory.

```php
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\Message;
use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Message\MessagesFactoryInterface;

$imager = (new ImagerFactory())->createImager();

$response = $imager
    ->file('path/image.jpg')
    ->crop(width: 200, height: 200, x: 0, y: 0)
    ->save('path/image.webp');

$messagesFactory = new Message\MessagesFactory();

var_dump($messagesFactory instanceof MessagesFactoryInterface);
// bool(true)

// You may filter out actions:
$actions = $response->actions()->withoutProcessedBy();

$messages = $messagesFactory->createMessagesFromActions(
    actions: $actions // ActionsInterface
);

foreach($messages as $message) {
    var_dump((string)$message);
}

// string(52) "Cropped image to width 200, height 200, x 0 and y 0."
// string(56) "Saved image path/image.webp with quality "90"."
```

You may check out the [Message Service](https://github.com/tobento-ch/service-message) to learn more about it.

You may check out the [Actions Interface](#actions-interface) to learn more about it.

## Interfaces

### Imager Factory Interface

```php
use Tobento\Service\Imager\ImagerFactoryInterface;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;

$imagerFactory = new ImagerFactory();

var_dump($imagerFactory instanceof ImagerFactoryInterface);
// bool(true)
```

**createImager**

Creates a new imager.

```php
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\ImagerInterface;

$imagerFactory = new ImagerFactory();

$imager = $imagerFactory->createImager();

var_dump($imager instanceof ImagerInterface);
// bool(true)
```

### Imager Interface

```php
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;

$imager = (new ImagerFactory())->createImager();

var_dump($imager instanceof ImagerInterface);
// bool(true)
```

**resource**

Sets the image resource to perform the actions.

```php
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Resource\File;

$resource = new File('path/image.jpg');

var_dump($resource instanceof ResourceInterface);
// bool(true)

$imager = $imager->resource(resource: $resource);
```

Check out the [Resource](#resource) section for available resources.

**getResource**

Returns the image resource or null if not set.

```php
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Resource\File;

$imager->resource(resource: new File('path/image.jpg'));

$resource = $imager->getResource();

var_dump($resource instanceof ResourceInterface);
// bool(true)
```

**getProcessor**

Returns the processor or null if not yet available.

```php
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\Resource\File;

$imager->resource(resource: new File('path/image.jpg'));

$processor = $imager->getProcessor();

var_dump($processor instanceof ProcessorInterface);
// bool(true)
```

**file**

Sets the image resource as file.

```php
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Resource\File;

$imager->file(file: 'path/image.jpg');

var_dump($imager->getResource() instanceof File);
// bool(true)
```

**action**

Adds an action to be processed.

```php
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Action\Save;

$action = new Save(filename: 'path/image.jpg');

var_dump($action instanceof ActionInterface);
// bool(true)

$imager->action(action: $action);
```

Check out the [Action](#action) section for available actions and its response type.

### Processor Factory Interface

```php
use Tobento\Service\Imager\ProcessorFactoryInterface;
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;

$processorFactory = new ProcessorFactory();

var_dump($processorFactory instanceof ProcessorFactoryInterface);
// bool(true)
```

**createProcessor**

Creates a new processor for the specified resource.

```php
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Resource\File;
use Tobento\Service\Imager\ProcessorCreateException;

$processorFactory = new ProcessorFactory();

$processor = $processorFactory->createProcessor(
    resource: new File('path/image.jpg'), // ResourceInterface
);

var_dump($processor instanceof ProcessorInterface);
// bool(true)

// throws ProcessorCreateException if processor could not get created.
```

### Processor Interface

```php
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Imager\Resource\File;

$processor = (new ProcessorFactory())->createProcessor(
    resource: new File('path/image.jpg'),
);

var_dump($processor instanceof ProcessorInterface);
// bool(true)
```

**processAction**

Processes the action specified.

```php
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\Resource\File;
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Action;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionProcessException;

$processor = (new ProcessorFactory())->createProcessor(
    resource: new File('path/image.jpg'),
);

$imager = (new ImagerFactory())->createImager();

$processed = $processor->processAction(
    action: new Action\Crop(200, 200), // ActionInterface
    imager: $imager, // ImagerInterface
);

// $processed might be:
var_dump($processed instanceof ImagerInterface);
// bool(true)

// or depending on the action:
var_dump($processed instanceof ResponseInterface);
// bool(false)

// throws ActionProcessException if action could not get processed.
```

### Resource Interface

```php
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Resource\File;

$resource = new File('path/image.jpg');

var_dump($resource instanceof ResourceInterface);
// bool(true)
```

### Action Interface

```php
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Action\Crop;

$action = new Crop(width: 200, height: 200);

var_dump($action instanceof ActionInterface);
// bool(true)
```

**parameters**

Returns the action parameters.

```php
use Tobento\Service\Imager\Action\Crop;

$action = new Crop(width: 200, height: 200);

var_dump($action->parameters());
// array(4) { ["width"]=> int(200) ["height"]=> int(200) ["x"]=> NULL ["y"]=> NULL } 
```

**description**

Returns a description of the action.

```php
use Tobento\Service\Imager\Action\Crop;

$action = new Crop(width: 200, height: 200);

var_dump($action->description());
// string(61) "Cropped image to width :width, height :height, x x: and y :y."
```

**processedBy**

The action by which the action was processed.

```php
use Tobento\Service\Imager\Action\Crop;

$action = new Crop(width: 200, height: 200);

$action->setProcessedBy(action: 'ClassName');

var_dump($action->processedBy());
// string(9) "ClassName"
```

### Actions Interface

```php
use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action\Crop;

$actions = new Actions(
    new Crop(width: 200, height: 200), // ActionInterface
);

var_dump($actions instanceof ActionsInterface);
// bool(true)
```

**add**

Adds an action.

```php
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action\Crop;

$actions = new Actions();

$actions->add(new Crop(width: 200, height: 200)); // ActionInterface
```

**empty**

If has any actions.

```php
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action\Crop;

$actions = new Actions();

var_dump($actions->empty());
// bool(true)

$actions = new Actions(
    new Crop(width: 200, height: 200),
);

var_dump($actions->empty());
// bool(false)
```

**filter**

Returns a new instance with the filtered actions.

```php
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action;

$actions = new Actions(
    new Action\Crop(width: 200, height: 200),
    new Action\Resize(width: 200),
);

$actions = $actions->filter(
    fn(ActionInterface $a): bool => in_array($a::class, [Action\Crop::class])
);
```

**only**

Returns a new instance with the specified action(s) only.

```php
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action;

$actions = new Actions(
    new Action\Crop(width: 200, height: 200),
    new Action\Resize(width: 200),
    new Action\Save(filename: 'image.jpg'),
);

$actions = $actions->only(Action\Crop::class, Action\Resize::class);
```

**except**

Returns a new instance except the specified action(s).

```php
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action;

$actions = new Actions(
    new Action\Crop(width: 200, height: 200),
    new Action\Resize(width: 200),
    new Action\Save(filename: 'image.jpg'),
);

$actions = $actions->except(Action\Save::class, Action\Resize::class);
```

**withoutProcessedBy**

Returns a new instance without actions processed by another.

```php
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action;

$actions = new Actions(
    new Action\Sepia(),
    (new Action\Greyscale())->setProcessedBy(Action\Sepia::class),
    new Action\Save(filename: 'image.jpg'),
);

$actions = $actions->withoutProcessedBy();
```

**all**

Returns all actions.

```php
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action;

$actions = new Actions(
    new Action\Crop(width: 200, height: 200),
    new Action\Resize(width: 200),
);

foreach($actions->all() as $action) {
    var_dump($action instanceof ActionInterface);
    // bool(true)
}

// or just
foreach($actions as $action) {}
```

### Response Interface

```php
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\Response\File;
use Tobento\Service\Imager\Actions;

$response = new File(
    file: 'path/image.jpg',
    actions: new Actions()
);

var_dump($response instanceof ResponseInterface);
// bool(true)
```

**actions**

Returns the actions processed.

```php
use Tobento\Service\Imager\Response\File;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\ActionsInterface;

$response = new File(
    file: 'path/image.jpg',
    actions: new Actions()
);

var_dump($response->actions() instanceof ActionsInterface);
// bool(true)
```

## Intervention Image

[Intervention Image](https://github.com/Intervention/image) imager implementation.

### Intervention Imager Factory

```php
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\ImagerFactoryInterface;

$imagerFactory = new ImagerFactory(
    config: ['driver' => 'gd'], // is default
);

var_dump($imagerFactory  instanceof ImagerFactoryInterface);
// bool(true)
```

Check out the [Imager Factory Interface](#imager-factory-interface) for its available methods.

Check out the [Intervention Image Configuration](https://image.intervention.io/v2/introduction/configuration) for the config available parameters.

### Intervention Processor Factory

```php
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Imager\ProcessorFactoryInterface;

$processorFactory = new ProcessorFactory(
    config: ['driver' => 'gd'], // is default
);

var_dump($processorFactory  instanceof ProcessorFactoryInterface);
// bool(true)
```

Check out the [Processor Factory Interface](#processor-factory-interface) for its available methods.

Check out the [Intervention Image Configuration](https://image.intervention.io/v2/introduction/configuration) for the config available parameters.

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)
- [Intervention Image](https://image.intervention.io)
