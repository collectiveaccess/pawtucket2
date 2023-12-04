# IIIF Parser

```
npm i @iiif/parser
```

### 2->3 Converter

This is available as a standalone bundle. (~4kb gzipped)

```js
import { convertPresentation2 } from '@iiif/parser/presentation-2';

const p3Manifest = convertPresentation2(p2Manifest);
```


### Basic usage
```js
import { Traverse } from '@iiif/parser';

// Or for presentation 2 resources
// import { Traverse } from '@iiif/parser/presentation-2'; 

const ids = [];
const extractCanvasLabsl = new Traverse({
  Canvas: [(canvas) => {
    ids.push(canvas.id); // string
  }],
});

extractCanvasLabsl.traverseUnknown(loadSomeManifest());

console.log(ids); // all canvas ids.
```
