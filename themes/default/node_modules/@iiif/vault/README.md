# Vault

**Current v0.9 waiting for feedback before 1.0**

[Docs to be written]

### Entry points
- `@iiif/vault` -> default vault class
- `@iiif/vault/actions` -> Actions for interacting with vault (tree-shaken out of vault)
- `@iiif/vault/store` -> redux createStore and reducers
- `@iiif/vault/utility` -> set of utilities

### Dependencies

This package depends on both the presentation 2 and 3 parsers. The Vault requires `redux` and `typesafe-actions`, it bundles `mitt`. For the UMD package, it comes in two flavours. The first (and default) includes everything (`dist/index.umd.js`) and there is a
standalone package that does not contain the parser (`dist/index.standalone.umd.js`). This expects `IIIFParser` to be defined and point to `@iiif/parser`. The way this is intended to be used is for both UMD bundles to be added to a page.

### Vault helpers

List of existing, or planned helpers.

- **Thumbnails** - providers methods for resolving thumbnails given a resource and size preferences
- **i18n** - helpers for internationalized values, and integrations with existing tools
- **Styles** - a meta extension for storing CSS styles associated with IIIF content
- **Events** - a meta extension for storing event listeners associated with IIIF content
- **Getters** - a vault wrapper, abstracting away references with javascript getters
- **Rendering strategy** - Normalisation of canvas annotations into simple and implementable strategies for rendering
- **Annotation page manager** - Discovery, loading and management of annotation pages

Custom helpers may opt to use a standard naming (`iiif-vault-[name]-helper`) and a format similar to this:
```ts
function createHelper(vault: Vault, ...dependencies: any[]) {
  return {
    helperA() {
      //..
    }
  };
}
```

### Changes to Hyperion vault

- `state.hyperion` -> `state.iiif`
- Import entities can accept partial resources
- `vault.getThumbnai()` removed
- New `state.meta` for storing non-data linked to IIIF
- Prefix for action type `@hyperion/*` to `@iiif/*`
- `vault.fromRef()` and `vault.allFromRef()` combined into `vault.get()`
