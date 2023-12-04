# IIIF Image API
A series of helpers for working with the IIIF Image API.

## Compatibility

#### IIIF Specifications
- [IIIF Image 3.0](https://iiif.io/api/image/3.0/) - full compatibility
- [IIIF Image 2.0](https://iiif.io/api/image/2.0/) - full compatibility
- [IIIF Image 1.0](https://iiif.io/api/image/1.0/) - unsupported

#### IIIF Profile levels
Check out the [Compliance version](https://iiif.io/api/image/3.0/compliance/) for more information. This library supports detection of levels 0 to 2 up to IIIF Image API 3.0.

## Documentation
This library is a toolbox to be used as a part of a larger application or library. The documentation is still in progress, but there are typescript definitions shipped so
you can explore the API in your IDE or editor.

### Image service loader
This is the primary part of the library. It uses all the components to create a single image service loading library.
```js
import { ImageServiceLoader } from '@atlas-viewer/iiif-image-api';

const loader = new ImageServiceLoader();

loader.loadService({
  id: 'http://some-service/some-path',
  width: 1000,
  height: 1000,
}).then(service => {
  // full image service available
  // service
});

loader.getThumbnailFromResource(
  // Content resource.
  {
    id: 'http://some-service/some-image/default.jpg',
    width: 1000,
    height: 2000,
    service: [
      {
       id: 'http://some-service/some-path',
        type: 'Service',
        profile: 'level0',
      }
    ]
  }, 
  // Thumbnail options.
  {
    maxWidth: 200,
    maxHeight: 200,
    preferFixedSize: true,
  }, 
  // Dereference image service.
  true
);
```

### Service profiles
The following profiles will be matched and mapped to the conformance level in IIIF:

- http://iiif.io/api/image/2/level0
- http://iiif.io/api/image/2/level1
- http://iiif.io/api/image/2/level2
- http://library.stanford.edu/iiif/image-api/compliance.html#level0
- http://library.stanford.edu/iiif/image-api/compliance.html#level1
- http://library.stanford.edu/iiif/image-api/compliance.html#level2
- http://library.stanford.edu/iiif/image-api/conformance.html#level0
- http://library.stanford.edu/iiif/image-api/conformance.html#level1
- http://library.stanford.edu/iiif/image-api/conformance.html#level2
- http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level0
- http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level1
- http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level2
- http://library.stanford.edu/iiif/image-api/1.1/conformance.html#level0
- http://library.stanford.edu/iiif/image-api/1.1/conformance.html#level1
- http://library.stanford.edu/iiif/image-api/1.1/conformance.html#level2
- http://iiif.io/api/image/1/level0.json
- http://iiif.io/api/image/1/profiles/level0.json
- http://iiif.io/api/image/1/level1.json
- http://iiif.io/api/image/1/profiles/level1.json
- http://iiif.io/api/image/1/level2.json
- http://iiif.io/api/image/1/profiles/level2.json
- http://iiif.io/api/image/2/level0.json
- http://iiif.io/api/image/2/profiles/level0.json
- http://iiif.io/api/image/2/level1.json
- http://iiif.io/api/image/2/profiles/level1.json
- http://iiif.io/api/image/2/level2.json
- http://iiif.io/api/image/2/profiles/level2.json
- level0
- level1
- level2

### isImageService
Takes in an image service object and returns true if it is a supported image service.
```js
import { isImageService } from '@atlas-viewer/iiif-image-api';

isImageService({
  id: 'http://some-service/some-path',
  type: 'Service',
  profile: 'level0',
}); // true

```

### canonicalServiceUrl

Normalises an image service endpoint to ensure it has the `info.json` appended.

```js
import { canonicalServiceUrl } from '@atlas-viewer/iiif-image-api';

canonicalServiceUrl('http://some-service/some-path'); // http://some-service/some-path/info.json

```

### extractFixedSizeScales

Given a list of image sizes and a height and width, this returns the scale of each size in the same order as the input.

```js
import { extractFixedSizeScales } from '@atlas-viewer/iiif-image-api';

extractFixedSizeScales(1000, 2000, [
  { width: 100, height: 200 },
  { width: 500, height: 1000 }
]); // [ 10, 2 ]

```

### fixedSizesFromScales

The opposite operation to `extractFixedSizeScales` returning a list of sizes from a list of scales.
```js
import { extractFixedSizeScales } from '@atlas-viewer/iiif-image-api';

extractFixedSizeScales(1000, 2000, [10, 2]);
// returns:
// [ { width: 100, height: 200 }, { width: 500, height: 1000 } ]
```

### getCustomSizeFromService

Given a service, this will return an object giving the constraints for generating images from the service using the 
profile and the max width and max height properties if they are available. If the service contains tiles, it will use
the definition of the tiles.

The return value used across this library is for describing an image candidate that can be used to create a real image.

```js
import { getCustomSizeFromService } from '@atlas-viewer/iiif-image-api';

getCustomSizeFromService({
  id: 'http://some-service/some-path',
  profile: 'image2',
  tiles: [
    { width: 256, height: 256 },
    { width: 512, height: 512 },
  ]
});

const returns = [
  {
    id: 'http://some-service/some-path',
    type: 'variable',
    minHeight: 0,
    minWidth: 0,
    maxHeight: 256,
    maxWidth: 256,
  },
  {
    id: 'http://some-service/some-path',
    type: 'variable',
    minHeight: 0,
    minWidth: 0,
    maxHeight: 512,
    maxWidth: 512,
  }
];
```

### getFixedSizeFromImage

This takes in a content resource – usually in the body of an annotation or thumbnail property in IIIF Presentation manifest – 
and tries to find the size of that resource. This is only an indication of the size of a resource and shouldn't be used as 
a source of truth. Internally this is used to detect potentially very large images and avoid rendering them. 

```js
import { getFixedSizeFromImage } from '@atlas-viewer/iiif-image-api';

// Normal image resources.
getFixedSizeFromImage({
  id: 'http://some-service/some-path/image.jpg',
  type: 'Image',
  width: 100,
  height: 200,
});

const returns = {
  id: 'http://some-service/some-path/image.jpg',
  type: 'fixed',
  width: 100,
  height: 200,
};

// Unknown size.
getFixedSizeFromImage('http://some-service/some-path/image.jpg');

const returns = {
  id: 'http://some-service/some-path/image.jpg',
  type: 'unknown',
};

```

### getFixedSizesFromService
### getImageCandidates
### getImageCandidatesFromService
### getImageFromTileSource
### getImageServerFromId
### getImageServices
### getSmallestScaleFactorAsSingleImage
### inferSizeFromUrl
### isBestMatch
### isImageService
### pickBestFromCandidates
### sampledTilesToTiles
### sizesMatch
### supportsCustomSizes
