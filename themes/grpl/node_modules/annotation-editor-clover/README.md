# Annotation editor plugin for Clover IIIF

This in an annotation editor plugin for Clover. It uses Annotorious.

## install plugin

```
npm install https://github.com/wykhuh/annotation-editor-clover#dist
```

In your app, add plugins when setting up the Clover viewer

```jsx
import Viewer from "@samvera/clover-iiif/viewer";
import {
  InformationPanel,
  AnnotationEditor,
  EditorProvider,
} from "annotation-editor-clover";

function App() {
  const url = "http://localhost:3000";

  return (
    <>
      <EditorProvider>
        <Viewer
          // manifest for the object
          iiifContent={`${url}/api/newspaper/issue_1`}
          // content search manifest
          iiifContentSearch={`${url}/api/newspaper_search/1?q=Berliner`}
          plugins={[
            {
              id: "AnnotationEditor",
              // add button to menu bar that activates Annotorious
              menu: {
                component: AnnotationEditor,
                componentProps: {
                  annotationServer: `${url}/api/annotationsByCanvas/1`,
                  token: "123abc",
                },
              },
              // displays the clipping in the side information panel
              informationPanel: {
                component: InformationPanel,
                label: { none: ["Clippings"] },
                componentProps: {
                  annotationServer: `${url}/api/annotations/1`,
                  token: "123abc",
                },
              },
            },
          ]}
          options={{
            // don't add red overlays for clippings
            ignoreAnnotationOverlaysLabels: ["Clippings"],
            informationPanel: { open: true, renderAbout: false },
          }}
        />
      </EditorProvider>
    </>
  );
}

export default App;
```
