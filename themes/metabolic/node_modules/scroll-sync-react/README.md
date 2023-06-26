# scroll-sync-react

## Overview

We provide you with a React.Context.Provider (`<ScrollSync/>`) Component that you wrap your "context" with, and then wrap each of your scrollable elements with a scroll listner (`<ScrollSyncNode/>`)
And see the magic happen

## Note

I needed this type of functionality on a side project, so I researched and found this library https://github.com/okonet/react-scroll-sync

_I have so much similarity with this library, but it's not maintained anymore, and uses the legacy context api, which introduced unexpected bugs, so I re-implemented it with the new context API and using react-hooks_

## codesandbox

A codesandbox that utilizes the latest of this package
https://codesandbox.io/s/gallant-sky-joiou

## Installation

```
npm i scroll-sync-react --save
```

## Usage

```
import { ScrollSync, ScrollSyncNode } from './build';

const App = () =>
  <ScrollSync>
    <div style={{ display: 'flex', position: 'relative', height: 300 }}>
      <ScrollSyncNode group="a">
        <div style={{ overflow: 'auto' }}>
          <section style={{ height: 1000 }}>
            <h1>This is group `a`</h1>
            Scrollable things
          </section>
        </div>
      </ScrollSyncNode>
      <ScrollSyncNode group="a">
        <div style={{ overflow: 'auto' }}>
          <section style={{ height: 1000 }}>
            <h1>This is group `a`</h1>
            Scrollable things
          </section>
        </div>
      </ScrollSyncNode>
    </div>
  </ScrollSync>
```

## API

### ScrollSync

| prop         | type           | required | default | description                                                                               |
| ------------ | -------------- | -------- | ------- | ----------------------------------------------------------------------------------------- |
| children     | `ReactElement` | true     |         | wrapper of to-be-synced elements                                                          |
| disabled     | `boolean`      | false    | false   | whether syncing is enabled or not                                                         |
| proportional | `boolean`      | false    | true    | In case we want scroll to be proportionally applied regardless of the width and/or height |

### ScrollSyncNode

| prop         | type                                      | required | default   | description                                                    |
| ------------ | ----------------------------------------- | -------- | --------- | -------------------------------------------------------------- |
| children     | `ReactElement`                            | true     |           | scrollable element                                             |
| group        | string                                    | false    | "default" | the group of scollable elements this node will be synced with  |
| scroll       | "two-way", "synced-only" or "syncer-only" | false    | "two-way" | to determine scroll configuration with other `ScrollSyncNode`s |
| selfLockAxis | "X", "Y", "XY" or `null`                  | false    | `null`    | to specifiy current node scroll lock axis                      |
| onScroll     | (event) => void                           | false    | ()=>{}    | on Node Scroll callback                                        |

## gify example!

A photo equals a thousand word, how about a GIF!
![example of syncing](example.gif)

## Todo:

- [x] Vertical scrolling sync
- [x] Providing a codesandbox
- [x] Configure scroll sync via `scroll` prop
- [x] Horizontal scrolling sync
- [x] Lock axis (locking horizontal or vertical of ScrollSyncNode)
- [x] Adding `onScroll` node callback
- [ ] Providing tests
