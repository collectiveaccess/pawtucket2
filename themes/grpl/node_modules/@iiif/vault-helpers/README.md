# Vault helpers

```
npm i @iiif/vault-helpers
```

```
yarn add @iiif/vault-helpers
```

List of existing, or planned helpers.

- [x] **Thumbnails** - providers methods for resolving thumbnails given a resource and size preferences
- [x] **i18n** - helpers for internationalized values, and integrations with existing tools
- [x] **Styles** - a meta extension for storing CSS styles associated with IIIF content
- [x] **Events** - a meta extension for storing event listeners associated with IIIF content
- [ ] **Getters** - a vault wrapper, abstracting away references with javascript getters
- [ ] **Rendering strategy** - Normalisation of canvas annotations into simple and implementable strategies for rendering
- [ ] **Annotation page manager** - Discovery, loading and management of annotation pages

## i18n
Some useful helpers for parsing language maps.

```ts
import { getValue } from '@iiif/vault-helpers/i18n';

// Simple utility.
const str1 = getValue(manifest.label); // based on browser

// Builder for integration with other libraries
const str2 = buildLocaleString(
  manifest.label,
  'en-GB',
  {
    fallbacks: ['en-US', 'en'],
    defaultText: 'Untitled manifest',
    separator: '<br/>',
    closest: false,
    strictFallback: true,
  }
);
```


## Styles
Styles are a way to store Style information inside of Vault.

```ts
import { createStyleHelper } from '@iiif/vault-helpers/styles';

const vault = new Vault();
const styles = createStyleHelper(vault);

const manifest = { id: 'https://example.org/manifest-1', type: 'Manifest' };

// Apply a style somewhere you in your app
styles.applyStyle(manifest, {
  background: 'red',
}, 'scope-1');

// Somewhere else..
styles.applyStyle(manifest, {
    someCustomStyle: 'foo',
}, 'scope-2');


// Where you render:
const applied = styles.getAppliedStyles(manifest);
// {
//  'scope-1': { background: 'red' },
//  'scope-2': { someCustomStyle: 'foo' }
// }
```

## Events
Events let you bind browser events to IIIF resources, potentially before they are rendered in the DOM. You still have
to bind the events, but those events could come from many sources.

Useful in UI frameworks where an alternative may be to drill down props through layers of components. 

```ts
import { createEventsHelper } from '@iiif/vault-helpers/styles';

const vault = new Vault();
const events = createEventsHelper(vault);

const annotation = { id: 'https://example.org/anno-1', type: 'Annotation' };

events.addEventListener(annotation, 'onClick', () => {
  console.log('Anno clicked');
});

// Where you render:
const props = events.getListenersAsProps();
$el.addEventListener('click', props.onClick);

// In React this might look like: <div className="anno" {...props} />
```

## Thumbnail
Work-in-progress vault-driven thumbnails.

```ts
import { createThumbnailHelper } from '@iiif/vault-helpers/thumbnail';

const vault = new Vault();
const helper = createThumbnailHelper(vault);

const thumbnail = helper.getBestThumbnailAtSize(canvas, { width: 256, height: 256 });
// thumbnail.best.id
```


## New helpers

Custom helpers may opt to use a standard naming (`iiif-vault-[name]-helper`) and a format similar to this:
```ts
function createXYZHelper(vault: Vault, ...dependencies: any[]) {
  return {
    helperA() {
      //..
    }
  };
}
```

PRs always welcome for new community helpers.
