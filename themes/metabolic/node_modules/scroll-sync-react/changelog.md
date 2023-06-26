## Upgrading from 1.0.x to 1.1.0

You'll have to change `syncable` prop to be `scroll` and it's value either `"two-way" | "synced-only" | "syncer-only"`

### example:

old (1.0.x version)

```
<ScrollSyncNode syncable>
  <CoolScrollableComponent>
</ScrollSyncNode>
```

to new `scroll` prop

```
<ScrollSyncNode scroll="two-way">
  <CoolScrollableComponent>
</ScrollSyncNode>
```

OR

```
<ScrollSyncNode syncable={false}>
  <CoolScrollableComponent>
</ScrollSyncNode>
```

to new `scroll` prop

```
<ScrollSyncNode scroll="syncer-only">
  <CoolScrollableComponent>
</ScrollSyncNode>
```

for more details about this prop go to readme.md file
