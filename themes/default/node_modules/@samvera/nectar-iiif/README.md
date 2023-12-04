# Nectar IIIF

React.js UI component library of IIIF Presentation API 3.0 property fluent primitives.

[**Demo**](https://samvera-labs.github.io/nectar-iiif) | [**Code**](https://github.com/samvera-labs/nectar-iiif)

---

## Documentation

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Primitives](#primitives)
  - [Label](#label)
  - [Homepage](#homepage)
  - [Metadata](#metadata)
  - [PartOf](#partof)
  - [RequiredStatement](#requiredstatement)
  - [SeeAlso](#seealso)
  - [Summary](#summary)
  - [Thumbnail](#thumbnail)
- [Attributes](#attributes)
- [Language](#language-internationalization)

---

<h2 id="installation">Installation</h2>

Install the component from your command line using `npm install`,

```shell
npm install @samvera/nectar-iiif
```

**OR** if you prefer Yarn, use `yarn add`.

```shell
yarn add @samvera/nectar-iiif
```

---

<h2 id="basic-usage">Basic Usage</h2>

Add the Nectar component(s) to your `jsx` or `tsx` code.

```jsx
import { Label, Summary } from "@samvera/nectar-iiif";
```

```jsx
/**
 * Some logic may be required to retrieve the IIIF Manifest.
 */
const manifest = {...};

return (
  <>
    <Label label={manifest.label} as="h1" />
    <Summary summary={manifest.summary} as="p" />
  </>
);
```

---

## Primitives

Primitives aim to cover most of the noted [Descriptive](https://iiif.io/api/presentation/3.0/#31-descriptive-properties) and [Linking](https://iiif.io/api/presentation/3.0/#31-descriptive-properties) properties noted in the IIIF Presentation API 3.0 specification. Some of these, specifically `Provider` may have a more complex component structure.

Completed (initial release) and proposed primitives include:

**Descriptive Properties**

- [x] Label
- [x] Metadata
- [x] Summary
- [x] RequiredStatement
- [ ] Rights
- [ ] Provider
- [x] Thumbnail

**Linking Properties**

- [x] Homepage
- [ ] Logo
- [ ] Rendering
- [x] SeeAlso
- [x] PartOf

---

### Label

#### Reference

| Prop    | Type                                                                  | Default | Required |
| ------- | --------------------------------------------------------------------- | ------- | -------- |
| `as`    | ` span`, `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `p`, `label`, `dt`, `dd` | `span`  | --       |
| `label` | [label](https://iiif.io/api/presentation/3.0/#label)                  | --      | **Yes**  |

#### Usage

```jsx
import { Label } from "@samvera/nectar-iiif";
```

```jsx
return <Label label={manifest.label} as="h1" lang="en" />;
```

---

### Homepage

```jsx
import { Homepage } from "@samvera/nectar-iiif";
```

Wrap resource label with homepage id.

```jsx
return <Homepage homepage={manifest.homepage} />;
```

Wrap React children with homepage id.

```jsx
return (
  <Homepage homepage={manifest.homepage}>
    <figure>...</figure>
  </Homepage>
);
```

---

### Metadata

Metadata is rendered am HTML `dl` with corresponding `dt` and `dd` elements for they respective `label` and `value` pairs. By default `value` entries are rendered as a string, with `, ` interspersed to seperate multiple entries. A consuming application using can optionally update the `value` output for each entry.

#### Reference

| Prop                 | Type                                                       | Default | Required |
| -------------------- | ---------------------------------------------------------- | ------- | -------- |
| `as`                 | `dl`                                                       | `dl`    |          |
| `metadata`           | [metadata](https://iiif.io/api/presentation/3.0/#metadata) | --      | **Yes**  |
| `customValueContent` | NectarCustomValueContent[]                                 | --      | --       |

```jsx
import { Metadata } from "@samvera/nectar-iiif";
```

```jsx
return <Metadata metadata={manifest.metadata} />;
```

#### Custom Value Content

If a consumign application required rendering specific `metadata` item `values` in a custom pattern, the `customValueContent` prop can be set for the `<Metadata>` component. The pattern requires `matchingLabel` as following https://iiif.io/api/presentation/3.0/#label and `Content` asa ReactElement carrying `props`. The element set for `Content` must map `props.value` to the appropriate code in the custom pattern.

In the example below, the value of **Pantaloon** with a matching `label` of `{ none: ["Subject"] }` would be rendered as `<dd><a href="https://example.org/?subject=Pantaloon">Pantaloon</a><dd>`, while the `value` entry of **comic masks** would render simply as `<dd>comic masks</dd>`.

```jsx
const metadata = [
  {
    label: { none: ["Genre"] },
    value: { none: ["comic masks"] },
  },
  {
    label: { none: ["Subject"] },
    value: { none: ["Pantaloon"] },
  },
];

const CustomValueSubject = (props) => (
  <a href={encodeURI(`https://example.org/?subject=${props.value}`)}>
    {props.value}
  </a>
);

const customValueContent = [
  {
    matchingLabel: { none: ["Subject"] },
    Content: <CustomValueSubject />,
  },
];

return <Metadata metadata={metadata} customValueContent={customValueContent} />;
```

---

### RequiredStatement

```jsx
import { RequiredStatement } from "@samvera/nectar-iiif";
```

```jsx
return <RequiredStatement requiredStatement={manifest.requiredStatement} />;
```

---

### PartOf

#### Reference

| Prop     | Type                                                   | Default | Required |
| -------- | ------------------------------------------------------ | ------- | -------- |
| `as`     | ` ol`, `ul`                                            | `ul`    | --       |
| `partOf` | [partOf](https://iiif.io/api/presentation/3.0/#partOf) | --      | **Yes**  |

```jsx
import { PartOf } from "@samvera/nectar-iiif";
```

```jsx
return <PartOf partOf={manifest.partOf} as="li" />;
```

---

### SeeAlso

#### Reference

| Prop      | Type                                                     | Default | Required |
| --------- | -------------------------------------------------------- | ------- | -------- |
| `as`      | ` ol`, `ul`                                              | `ul`    | --       |
| `seeAlso` | [seeAlso](https://iiif.io/api/presentation/3.0/#seealso) | --      | **Yes**  |

```jsx
import { SeeAlso } from "@samvera/nectar-iiif";
```

```jsx
return <SeeAlso seeAlso={manifest.seeAlso} as="li" />;
```

---

### Summary

#### Reference

| Prop      | Type                                                     | Default | Required |
| --------- | -------------------------------------------------------- | ------- | -------- |
| `as`      | ` span`, `h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `p`         | `span`  | --       |
| `summary` | [summary](https://iiif.io/api/presentation/3.0/#summary) | --      | **Yes**  |

#### Usage

```jsx
import { Summary } from "@samvera/nectar-iiif";
```

```jsx
return <Summary summary={manifest.summary} as="p" />;
```

---

### Thumbnail

Thumbnails are rendered to a relative HTML `<img>` or `<video>` element dependendent on the type of the resource in the thumbnail entry. Currently, only `type` **Image** and **Video** are supported.

<img width="300" alt="image" src="https://github.com/mathewjordan/fet/blob/main/nectar-thumb-trimmed.gif?raw=true">

#### Reference

| Prop         | Type                                                         | Default | Required |
| ------------ | ------------------------------------------------------------ | ------- | -------- |
| `thumbnail`  | [thumbnail](https://iiif.io/api/presentation/3.0/#thumbnail) | --      | **Yes**  |
| `altAsLabel` | [label](https://iiif.io/api/presentation/3.0/#label)         | --      | --       |

```jsx
import { Thumbnail } from "@samvera/nectar-iiif";
```

```jsx
return <Thumbnail thumbnail={manifest.thumbnail} altAsLabel={manifest.label} />;
```

## Attributes

All primitives accept common HTMLElement attributes.

| Prop        | Type                          | Default     |
| ----------- | ----------------------------- | ----------- |
| `className` | `string`, `undefined`         | `undefined` |
| `style`     | `CSSProperties`, `undefined`  | `undefined` |
| `lang`      | `string`, `undefined`         | `undefined` |
| `title`     | `string`, `undefined`         | `undefined` |
| `data-*`    | `string`, `undefined`         | `undefined` |
| `aria-*`    | `AriaAttributes`, `undefined` | `undefined` |

## Language (Internationalization)

The value of `lang` will couple with [InternationalString](https://github.com/IIIF-Commons/presentation-3-types/blob/main/iiif/descriptive.d.ts#L6-L8) props to output the denoted `label`, `value`, `summary` entries. If `lang` is undefined, entries will default to the first entry in the array index.
