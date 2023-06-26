# React IIIF Viewer

A React component library built on [OpenSeadragon](https://openseadragon.github.io/) for displaying high resolution images with deep zooming capabilities on mobile and desktop. Check out the interactive [Demo](https://eslawski.github.io/react-iiif-viewer/)!




![example](mask_example.gif)

### What is IIIF?

[IIIF](https://iiif.io/) (pronounced “Triple-Eye-Eff”) is an open set of technical specifications that aim to provide uniformity to the way image-based resources are presented and delivered to end users.

IIIF images are delivered via a IIIF compatible image server. This server is responsible for breaking down large images into small tiles. The browser then makes requests for these tiles as the user zooms/pans around the image. As the user zooms in deeper, high resolution tiles are requested in order to maintain quality and performance. Fetched tiles are stitched together in real-time resulting in seamless user experience.

#### Where do I get these IIIF compatible images?
[The Getty](https://www.getty.edu/) hosts thousands of images available for free use via their [Open Content Program](http://www.getty.edu/about/whatwedo/opencontent.html). Or, if you would like to create your own IIIF images, you can host a small number for free at [iiifhosting.com](https://www.iiifhosting.com/).

### Installation

Install via `npm`:

```
$ npm install react-iiif-viewer --save
```

### Components

#### Viewer
A basic viewer that displays one image at a time.

```
import { Viewer } from "react-iiif-viewer"

<Viewer iiifUrl="https://data.getty.edu/museum/api/iiif/635494/info.json" />
```


| prop      | required | type   | default | description                                                      |
|-----------|----------|--------|---------|------------------------------------------------------------------|
| `iiifUrl` | yes      | string | N/A     | The IIIF image url to display. Changes to this prop will also update the currently displayed image.                    |
| `width`   | no       | string | 800px   | A css dimension for the width of the viewer (500px, 100%, etc.)  |
| `height`  | no       | string | 500px   | A css dimension for the height of the viewer (500px, 100%, etc.) |


#### MultiViewer
A viewer that displays a collection of IIIF images via an expandable/collapsable thumbnail drawer.

```
import { MultiViewer } from "react-iiif-viewer"

<MultiViewer iiifUrls={[
    "https://data.getty.edu/museum/api/iiif/635494/info.json",
    "https://data.getty.edu/museum/api/iiif/671108/info.json",
    "https://data.getty.edu/museum/api/iiif/194801/info.json",
    "https://data.getty.edu/museum/api/iiif/268179/info.json"
]}/>
```

| prop       | required | type     | default | description                                                      |
|------------|----------|----------|---------|------------------------------------------------------------------|
| `iiifUrls` | yes      | [string] | N/A     | An array of IIIF image urls to display                           |
| `width`    | no       | string   | 800px   | A css dimension for the width of the viewer (500px, 100%, etc.)  |
| `height`   | no       | string   | 500px   | A css dimension for the height of the viewer (500px, 100%, etc.) |

### Development

After cloning the repo, install its dependencies:

```
$ cd react-iiif-viewer
$ npm install
```

This project uses [Parcel](https://parceljs.org/) for bundling and running of a development server.

To run the demo application with hot reloading:

```
$ npm run start-demo
```

The unit tests are written using [react-testing-library](https://github.com/testing-library/react-testing-library).

To run them:

```
$ npm test
```

### Future Improvements

1. Implement custom full screen experience for iPhones since they don't yet support the [Full Screen API](https://developer.mozilla.org/en-US/docs/Web/API/Fullscreen_API)
1. CI pipeline with automatic publishing to Github pages
1. Error states when image fails to load
1. Error states when unable to fetch certain thumbnails
1. Performance considerations when dealing with lots of images
1. Ability to provide extra OpenSeadragon configs
1. Add `prettier` code formatter
1. Provide ability to render with thumbnail drawer open initially
