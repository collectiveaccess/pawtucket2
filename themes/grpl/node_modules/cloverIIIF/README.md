# Clover IIIF

**Extensible IIIF front-end toolkit and Manifest viewer. Accessible. Composable. Open Source.**

Clover IIIF is a suite of Manifest and Collection components combined with lower-level IIIF Presentation 3.0 API UI components. Designed with a focus on accessibility, customization, and developer experience. You can use Clover IIIF to build your own custom IIIF-fluent web interfaces while still using the full power of the IIIF Presentation 3.0 API.

---

## Documentation

For full documentation, visit [samvera-labs.github.io/clover-iiif](https://samvera-labs.github.io/clover-iiif/).

## Contributing

We welcome all contributions. Please follow our [contributing guidelines](./.github/CONTRIBUTING.md). If you're working on a pull request for this project, create a feature branch off of `main`.

### Development

Clover IIIF front-end development occurs within Next.js based [Nextra](https://nextra.site/) documentation. The default url for the local server is `http://localhost:3000`, unless the `3000` port is in use.

```shell
npm install
npm run dev
```

### Testing

Clover IIIF utilizes [vitest](https://vitest.dev/) for unit testing.

````shell
# Run tests
npm run test

```shell
# Run coverage report on the tests
npm run coverage
````

### Code Quality

Clover IIIF utilizes [ESLint](https://eslint.org/) and [Prettier](https://prettier.io/) for code quality. Files will be automatically formatted and "fixed" to Prettier and ESLint's configurations when making a `commit` as part of `lint-staged` config. The following commands are also directly available:

```shell
# Run ESLint
npm run lint

# Run Prettier check
npm run prettier

# Run Prettier fix
npm run prettier:fix

# Run TypeScript checks
npm run typecheck
```

## Releases

The Clover Suite recently released `v2`. The biggest change from v1.x.x to v2. is that Clover is now more than just a Viewer component. You can still use the Viewer component as you may have previously by following the [Installation and Usage instructions](https://samvera-labs.github.io/clover-iiif/docs/viewer).

## License

This project is available under the [MIT License](https://github.com/samvera-labs/clover-iiif/blob/main/LICENSE).
