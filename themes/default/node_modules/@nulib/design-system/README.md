# Design System for Northwestern University Libraries

[https://nulib.github.io/design-system/](https://nulib.github.io/design-system/)

A global design system for NUL ReactJS UI components, intended for all front end applications, NPM modules, and user interfaces.

Built using:

- React
- TypeScript
- [Radix Primitives](https://www.radix-ui.com/docs/primitives) to be "accessibility-first",
- [Stitches](https://stitches.dev/) package for styling
- [NextJS](https://nextjs.org/) for dev environment
- [Rollup](https://rollupjs.org/) for package bundling

## Usage

### Install the package

```bash
npm install @nulib/design-system
```

### Import individual components

```jsx
import { Button, Section, Tag } from "@nulib/design-system"

...

<Button
  isPrimary
  onClick={() => console.log("Ive been clicked")}
>
  Click Me
</Button>
```

## Development

```bash
// Clone the repo
git clone git@github.com:nulib/design-system.git

// Install dependencies
npm install

// Run the local dev environment
npm run dev
```

Open [http://localhost:3000](http://localhost:3000) with your browser to see the result.

## Packaging

### Build for NPM

```bash
npm run build
```

### Build static reference site for Github Docs

```bash
npm run build:static
```

Per NextJS convention, this will output to the `/out` directory. To view a local static build via a quick local server, run:

```bash
npm run build:static
npx serve out
```

## CI

A static version of the site is automated and pushed to the `gh-pages` branch via Github Actions commits to the `main` branch. View the static site at: [https://nulib.github.io/design-system/](https://nulib.github.io/design-system/)
