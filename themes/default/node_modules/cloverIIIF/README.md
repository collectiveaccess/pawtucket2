<!-- ![image](https://user-images.githubusercontent.com/7376450/190425863-89c42386-4e59-4a4f-b0bd-6bd5ee9dba5f.png) -->
<img src="https://user-images.githubusercontent.com/7376450/190425863-89c42386-4e59-4a4f-b0bd-6bd5ee9dba5f.png" class="clover-screenshot" alt="Clover screenshot" />

# Clover IIIF

**A flexible IIIF Manifest viewer for Image, Audio, and Video canvases built with React.js**

[**Demo**](https://samvera-labs.github.io/clover-iiif/) | [**Code**](https://github.com/samvera-labs/clover-iiif)

Clover IIIF is a UI component that renders a multicanvas IIIF item viewer for `Video` and `Sound` content resources with pan-zoom support for `Image` via OpenSeadragon. Provide a [IIIF Presentation](https://iiif.io/api/presentation/3.0/) manifest and the component:

- Renders a multi-canvas _Video_, _Sound_, and _Image_ viewer
- Renders thumbnails as navigation between canvases
- Renders annotations with the [motivation](https://iiif.io/api/presentation/3.0/#values-for-motivation) of `supplementing` with a content resource having the format of `text/vtt` for _Video_ and _Sound_
- _Video_ and _Sound_ are rendered within a HTML5 `<video>` element
- _Image_ canvases are renderered with [OpenSeadragon](https://openseadragon.github.io/)
- Supports HLS streaming for **.m3u8** extensions
- Supports IIIF Collections and toggling between child Manifests
- Supports `placeholderCanvas` for _Image_ canvases.

<img src="https://user-images.githubusercontent.com/7376450/191546194-a84cee9f-ad54-4729-a6a6-81b88ac3c0e4.png" alt="Clover video-support" />

_Example showing Clover IIIF rendering Video with a supplementing VTT cues for navigation._

---

## Documentation

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Active Canvas](#active-canvas)
- [Configuring Captions](#configuring-captions)
- [Custom Theme](#custom-theme)
- [Reference](#reference)
- [Manifest Requirements](#manifest-requirements)
- [Development](#development)

---

<h2 id="installation">Installation</h2>

Install the component from your command line using `npm install`,

```shell
npm install @samvera/clover-iiif
```

**OR** if you prefer Yarn, use `yarn add`.

```shell
yarn add @samvera/clover-iiif
```

---

<h2 id="basic-usage">Basic Usage</h2>

Add the CloverIIIF component to your `jsx` or `tsx` code.

```jsx
import CloverIIIF from "@samvera/clover-iiif";
```

Minimal usage providing the `<CloverIIIF/>` component with an external manifest.

```jsx
const id =
  "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/iiif/manifests/sample.json";

return <CloverIIIF id={id} />;
```

[See Example](https://codesandbox.io/s/samvera-clover-iiif-i0huq)

<h3>Usage with Next.js</h3>

Usage with Next.js requires a [dynamic import](https://nextjs.org/docs/advanced-features/dynamic-import) using `next/dynamic` due to a dependency of OpenSeadragon.

```jsx
import dynamic from "next/dynamic";

const CloverIIIF = dynamic(() => import("@samvera/clover-iiif"), {
  ssr: false,
});

const id = "https://digital.lib.utk.edu/assemble/manifest/heilman/1187";

return <CloverIIIF id={id} />;
```

---

<h2 id="active-canvas">Active Canvas</h2>

Example on using `canvasIdCallback` to return to your consuming application the active canvas ID. This will return as a string.

```jsx
const id =
  "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/iiif/manifests/sample.json";

const handlCanvasIdCallback = (activeCanvasId) => {
  if (activeCanvasId) console.log(activeCanvasId);
};

return <CloverIIIF id={id} canvasIdCallback={handlCanvasIdCallback} />;
```

[See Example](https://codesandbox.io/s/samvera-clover-iiif-i0huq)

---

<h2 id="configuring-captions">Configuring Captions</h2>

WebVTT content resources are the source for both content mapped closed captioning `<track/>` elements in the HTML 5 video player and to the navigator panel adjacent to it. You may ignore these resources as tracks if they are not intended for closed captioning or subtitling by string values matching the label of the content resource. This is a manual option within the viewer as there is no defined way for a manifest to prescribe motivation for these resources beyond `supplementing`.

#### Supplementing Annotation to Ignore

```json
{
  "id": "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/iiif/manifests/captions.json/canvas/1/page/annotation_page/1/annotation/2",
  "type": "Annotation",
  "motivation": "supplementing",
  "body": {
    "id": "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/vtt/around_the_corner_chapters.vtt",
    "type": "Text",
    "format": "text/vtt",
    "label": {
      "en": ["Chapters"]
    },
    "language": "en"
  },
  "target": "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/iiif/manifests/captions.json/canvas/1"
}
```

#### Configuration Option Implementation

```jsx
export default function App() {
  const id =
    "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/iiif/manifests/captions.json";

  const options = {
    ignoreCaptionLabels: ["Chapters"],
  };

  return <CloverIIIF id={id} options={options} />;
}
```

[See Example](https://codesandbox.io/s/hunhf)

---

<h2 id="custom-theme">Custom Theme</h2>

You may choose to override the base theme by setting optional colors and fonts. Naming conventions for colors are limited to those shown in the config example below.

```jsx
const id =
  "https://raw.githubusercontent.com/samvera-labs/clover-iiif/main/public/fixtures/iiif/manifests/sample.json";

const customTheme = {
  colors: {
    /**
     * Black and dark grays in a light theme.
     * All must contrast to 4.5 or greater with `secondary`.
     */
    primary: "#37474F",
    primaryMuted: "#546E7A",
    primaryAlt: "#263238",

    /**
     * Key brand color(s).
     * `accent` must contrast to 4.5 or greater with `secondary`.
     */
    accent: "#C62828",
    accentMuted: "#E57373",
    accentAlt: "#B71C1C",

    /**
     * White and light grays in a light theme.
     * All must must contrast to 4.5 or greater with `primary` and  `accent`.
     */
    secondary: "#FFFFFF",
    secondaryMuted: "#ECEFF1",
    secondaryAlt: "#CFD8DC",
  },
  fonts: {
    sans: "'Avenir', 'Helvetica Neue', sans-serif",
    display: "Optima, Georgia, Arial, sans-serif",
  },
};

return <CloverIIIF id={id} customTheme={customTheme} />;
```

[See Example](https://codesandbox.io/s/custom-theme-g6m5v)

---

<h2 id="reference">Reference</h2>

| Prop                            | Type                    | Required | Default   |
| ------------------------------- | ----------------------- | -------- | --------- |
| `id`                            | `string`                | Yes      |           |
| `manifestId` _(deprecated)_     | `string`                | No       |           |
| `canvasIdCallback`              | `function`              | No       |           |
| `customTheme`                   | `object`                | No       |           |
| `options`                       | `object`                | No       |           |
| `options.canvasBackgroundColor` | `string`                | No       | `#1a1d1e` |
| `options.canvasHeight`          | `string`                | No       | `500px`   |
| `options.ignoreCaptionLabels`   | `string[]`              | No       | []        |
| `options.openSeadragon`         | `OpenSeadragon.Options` | No       |           |
| `options.renderAbout`           | `boolean`               | No       | true      |
| `options.showIIIFBadge`         | `boolean`               | No       | true      |
| `options.showInformationToggle` | `boolean`               | No       | true      |
| `options.showTitle`             | `boolean`               | No       | true      |
| `options.withCredentials`       | `boolean`               | No       | false     |

Clover can configured through an `options` prop, which will serve as a object for common options.

- Options `canvasBackgroundColor` and `canvasHeight` will apply to both `<video>` elements and the OpenseaDragon canvas.
- Options `renderAbout` and `showInformationToggle` relate to rendering Manifest content in an `<aside>` and providing user ability to close that panel.
- The Option `withCredentials` being set as `true` will inform IIIF resource requests to be made [using credentials](https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/withCredentials) such as cookies, authorization headers or TLS client certificates.

You can override the [OpenSeadragon default options](https://openseadragon.github.io/docs/OpenSeadragon.html#.Options) set within Clover to adjust touch and mouse gesture settings and various other configurations.

```jsx
import CloverIIIF from "@samvera/clover-iiif";

...

// Supported options
const options = {
  // Primary title (Manifest label) for top level canvas.  Defaults to true
  showTitle: false,

  // IIIF Badge and popover containing options.  Defaults to true
  showIIIFBadge: false,

  // Ignore supplementing canvases by label value that are not for captioning
  ignoreCaptionLabels: ['Chapters'],

  // Override canvas background color, defaults to #1a1d1e
  canvasBackgroundColor: "#000",

  // Set canvas zooming onScoll (this defaults to false)
  openSeadragon: {
    gestureSettingsMouse: {
      scrollToZoom: true;
    }
  }
}
...

<CloverIIIF id={...} options={options} />
```

---

<h2 id="manifest-requirements">IIIF Presentation API Requirements</h2>

The Manifest or Collection provided to `id`:

- MUST be a [IIIF Presentation API](https://iiif.io/api/presentation/3.0/) valid manifest,
- MUST have at least one canvas with an annotation of the **motivation** of `painting` and content resource with the **type** of `Video`, `Sound`, or `Image`
- MAY have canvases with annotations of the **motivation** of `supplementing` and content resource with the **format** of `text/vtt`
- MAY have HLS streaming media, however, the file extension MUST be `.m3u8` for `Sound` and `Video`

---

<h2 id="development">Development</h2>

Clover IIIF is built with:

- TypeScript
- [ESBuild](https://esbuild.github.io/)
- [Vault](https://github.com/IIIF-Commons/vault/)
- [OpenSeadragon](https://openseadragon.github.io/)
- [Radix UI](https://www.radix-ui.com/)
- [Stitches](https://stitches.dev/)

### Environment

This will open up a local dev server with live reloading.

```shell
npm install
npm run dev
```

### Build

This will build and package the component

```shell
npm run build
```

This will create a static version of the site to the `/static` directory

```shell
npm run build:static
```

#### Notes

- ESBuild compiles TypeScript to JavaScript, but does not do type checking. To view type checking errors (in addtion to what your IDE will be complaining about), run:

```shell
tsc
```

<h2 id="license">License</h2>

This project is available under the [MIT License](https://github.com/samvera-labs/clover-iiif/blob/main/LICENSE).
