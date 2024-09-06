# recogito-client-core

Core functions, classes and components for [RecogitoJS](https://github.com/recogito/recogito-js), 
[Annotorious](https://github.com/recogito/annotorious) and [Annotorious OpenSeadragon](https://github.com/recogito/annotorious-openseadragon).

To install `npm install @recogito/recogito-client-core`

## Contributing UI Translations

If you want to contribute UI translations to Annotorious or RecogitoJS, you've come to the right place!
In [this folder](https://github.com/recogito/recogito-client-core/tree/main/src/i18n) 
you will find `messages` files, one file for each translation. 

Each `messages` file is a dictionary of the English labels and their translations. For example, 
here's the German translation file `messages_de.json`.

```json
{
  "Add a comment...": "Kommentar schreiben...",
  "Add a reply...": "Antwort schreiben...",
  "Add tag...": "Tag...",
  "Cancel": "Abbrechen",
  "Close": "Schliessen",
  "Edit": "Bearbeiten",
  "Delete": "Löschen",
  "Ok": "Ok"
}
``` 

### To add a new translation

- Fork this repository
- Add a message file to the [src/i18n folder](https://github.com/recogito/recogito-client-core/tree/main/src/i18n) 
  named `messages_{iso}.json`, where {iso} is the 2-character ISO code of the language.
- Copy the dictionary above, and replace the translations accordingly.
- [Send a pull request](https://www.freecodecamp.org/news/how-to-make-your-first-pull-request-on-github-3/)

Many thanks in advance! If you have questions, do get in touch via the [Annotorious](https://gitter.im/recogito/annotorious) or 
[RecogitoJS](https://gitter.im/recogito/recogito-js) chat on Gitter. 


