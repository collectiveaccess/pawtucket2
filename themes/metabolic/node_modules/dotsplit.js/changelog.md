# Change Log
All notable changes to this project will be documented in this file (keepachangelog.com).

## 1.1.0 - 2017-02-07
### Removed
- Removed all external dependencies.

## 1.0.3 - 2016-01-24
### Fixed
- Fixed bug where passing non-string values was throwing a TypeError.

## 1.0.2 - 2016-01-24
### Changed
- Updated dev dependencies.

## 1.0.1 - 2016-01-24
### Fixed
- Fixed bug where empty strings or falsey values result in an error being thrown.

## 1.0.0 - 2016-01-24
### Removed
- Dropped support for `component` and `volo` package managers.
- Dropped `makefile` in favor of `npm run …` scripts.

### Added
- Add `.{editorconfig,gitattributes,npmignore}`.
- Add `{changelog,contributing}.md`.
- Add `npm run …` scripts.

### Changed
- Changed `.map` to `map` via (`npm install arraymap`).
- Changed tests from `mocha` + `chai` to `tape`.
- Updated `.travis.yml` and `.gitignore`.

## 0.2.0 - 2013-11-20
### Added
- Initial Version.
