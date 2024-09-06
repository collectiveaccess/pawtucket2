/**
 * Swiper Custom Element 9.4.1
 * Most modern mobile touch slider and framework with hardware accelerated transitions
 * https://swiperjs.com
 *
 * Copyright 2014-2023 Vladimir Kharlampidi
 *
 * Released under the MIT License
 *
 * Released on: June 13, 2023
 */

/* eslint-disable spaced-comment */
import Swiper from 'swiper';
import { paramsList } from '../components-shared/params-list.js';
import { getParams } from './get-params.js';
import {
  needsScrollbar,
  needsNavigation,
  needsPagination,
  attrToProp,
} from '../components-shared/utils.js';
import { updateSwiper } from '../components-shared/update-swiper.js';

const SwiperFontCSS = `@font-face{font-family:swiper-icons;src:url('data:application/font-woff;charset=utf-8;base64, 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');font-weight:400;font-style:normal}`; const SwiperCSS = `:root{--swiper-theme-color:#007aff}.swiper,swiper-container{margin-left:auto;margin-right:auto;position:relative;overflow:hidden;list-style:none;padding:0;z-index:1;display:block}:host(.swiper-vertical)>.swiper-wrapper{flex-direction:column}.swiper-wrapper{position:relative;width:100%;height:100%;z-index:1;display:flex;transition-property:transform;transition-timing-function:var(--swiper-wrapper-transition-timing-function,initial);box-sizing:content-box}.swiper-android swiper-slide,.swiper-wrapper{transform:translate3d(0px,0,0)}.swiper-horizontal{touch-action:pan-y}.swiper-vertical{touch-action:pan-x}swiper-slide{flex-shrink:0;width:100%;height:100%;position:relative;transition-property:transform;display:block}.swiper-slide-invisible-blank{visibility:hidden}.swiper-autoheight,.swiper-autoheight swiper-slide{height:auto}:host(.swiper-autoheight) .swiper-wrapper{align-items:flex-start;transition-property:transform,height}.swiper-backface-hidden swiper-slide{transform:translateZ(0);-webkit-backface-visibility:hidden;backface-visibility:hidden}:host(.swiper-3d.swiper-css-mode) .swiper-wrapper{perspective:1200px}:host(.swiper-3d) .swiper-wrapper{transform-style:preserve-3d}.swiper-3d{perspective:1200px}.swiper-3d .swiper-cube-shadow,.swiper-3d .swiper-slide-shadow,.swiper-3d .swiper-slide-shadow-bottom,.swiper-3d .swiper-slide-shadow-left,.swiper-3d .swiper-slide-shadow-right,.swiper-3d .swiper-slide-shadow-top,.swiper-3d swiper-slide{transform-style:preserve-3d}.swiper-3d .swiper-slide-shadow,.swiper-3d .swiper-slide-shadow-bottom,.swiper-3d .swiper-slide-shadow-left,.swiper-3d .swiper-slide-shadow-right,.swiper-3d .swiper-slide-shadow-top{position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:10}.swiper-3d .swiper-slide-shadow{background:rgba(0,0,0,.15)}.swiper-3d .swiper-slide-shadow-left{background-image:linear-gradient(to left,rgba(0,0,0,.5),rgba(0,0,0,0))}.swiper-3d .swiper-slide-shadow-right{background-image:linear-gradient(to right,rgba(0,0,0,.5),rgba(0,0,0,0))}.swiper-3d .swiper-slide-shadow-top{background-image:linear-gradient(to top,rgba(0,0,0,.5),rgba(0,0,0,0))}.swiper-3d .swiper-slide-shadow-bottom{background-image:linear-gradient(to bottom,rgba(0,0,0,.5),rgba(0,0,0,0))}:host(.swiper-css-mode)>.swiper-wrapper{overflow:auto;scrollbar-width:none;-ms-overflow-style:none}:host(.swiper-css-mode)>.swiper-wrapper::-webkit-scrollbar{display:none}.swiper-css-mode>swiper-slide{scroll-snap-align:start start}:host(.swiper-horizontal.swiper-css-mode)>.swiper-wrapper{scroll-snap-type:x mandatory}:host(.swiper-vertical.swiper-css-mode)>.swiper-wrapper{scroll-snap-type:y mandatory}:host(.swiper-css-mode.swiper-free-mode)>.swiper-wrapper{scroll-snap-type:none}.swiper-css-mode.swiper-free-mode>swiper-slide{scroll-snap-align:none}:host(.swiper-centered)>.swiper-wrapper::before{content:'';flex-shrink:0;order:9999}.swiper-centered>swiper-slide{scroll-snap-align:center center;scroll-snap-stop:always}.swiper-centered.swiper-horizontal>swiper-slide:first-child{margin-inline-start:var(--swiper-centered-offset-before)}:host(.swiper-centered.swiper-horizontal)>.swiper-wrapper::before{height:100%;min-height:1px;width:var(--swiper-centered-offset-after)}.swiper-centered.swiper-vertical>swiper-slide:first-child{margin-block-start:var(--swiper-centered-offset-before)}:host(.swiper-centered.swiper-vertical)>.swiper-wrapper::before{width:100%;min-width:1px;height:var(--swiper-centered-offset-after)}.swiper-lazy-preloader{width:42px;height:42px;position:absolute;left:50%;top:50%;margin-left:-21px;margin-top:-21px;z-index:10;transform-origin:50%;box-sizing:border-box;border:4px solid var(--swiper-preloader-color,var(--swiper-theme-color));border-radius:50%;border-top-color:transparent}.swiper-watch-progress .swiper-slide-visible .swiper-lazy-preloader,.swiper:not(.swiper-watch-progress) .swiper-lazy-preloader,swiper-container:not(.swiper-watch-progress) .swiper-lazy-preloader{animation:swiper-preloader-spin 1s infinite linear}.swiper-lazy-preloader-white{--swiper-preloader-color:#fff}.swiper-lazy-preloader-black{--swiper-preloader-color:#000}@keyframes swiper-preloader-spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}`;

let globalInjectStyles = true;

const addGlobalStyles = (preInit, swiper) => {
  let globalStyles = document.querySelector('style#swiper-element-styles');
  const shouldOverwrite = globalStyles && globalStyles.preInit && !preInit;
  if (!preInit && swiper) {
    swiper.cssLinks().forEach((url) => {
      const linkEl = document.createElement('link');
      linkEl.rel = 'stylesheet';
      linkEl.href = url;
      document.head.prepend(linkEl);
    });
  }
  if (!globalStyles || shouldOverwrite) {
    globalStyles = globalStyles || document.createElement('style');
    globalStyles.textContent = [SwiperFontCSS, swiper ? swiper.cssStyles() : ''].join('\n'); // eslint-disable-line
    globalStyles.id = 'swiper-element-styles';
    globalStyles.preInit = preInit;
    document.head.prepend(globalStyles);
  }
};

class DummyHTMLElement {}

const ClassToExtend =
  typeof window === 'undefined' || typeof HTMLElement === 'undefined'
    ? DummyHTMLElement
    : HTMLElement;

class SwiperContainer extends ClassToExtend {
  constructor() {
    super();

    this.tempDiv = document.createElement('div');
    this.shadowEl = this.attachShadow({ mode: 'open' });
  }

  cssStyles() {
    return [
      globalInjectStyles ? SwiperCSS : '', // eslint-disable-line
      ...(this.injectStyles && Array.isArray(this.injectStyles) ? this.injectStyles : []),
    ].join('\n');
  }

  cssLinks() {
    return this.injectStylesUrls || [];
  }

  render() {
    if (this.rendered) return;
    if (globalInjectStyles) {
      // global styles
      addGlobalStyles(false, this);
    }

    // local styles
    const localStyles = this.cssStyles();
    if (localStyles.length) {
      this.stylesEl = document.createElement('style');
      this.stylesEl.textContent = localStyles;
      this.shadowEl.appendChild(this.stylesEl);
    }

    this.cssLinks().forEach((url) => {
      const linkExists = this.shadowEl.querySelector(`link[href="${url}"]`);
      if (linkExists) return;
      const linkEl = document.createElement('link');
      linkEl.rel = 'stylesheet';
      linkEl.href = url;
      this.shadowEl.appendChild(linkEl);
    });
    // prettier-ignore
    this.tempDiv.innerHTML = `
      <slot name="container-start"></slot>
      <div class="swiper-wrapper">
        <slot></slot>
      </div>
      <slot name="container-end"></slot>
      ${needsNavigation(this.passedParams) ? `
        <div part="button-prev" class="swiper-button-prev"></div>
        <div part="button-next" class="swiper-button-next"></div>
      ` : ''}
      ${needsPagination(this.passedParams) ? `
        <div part="pagination" class="swiper-pagination"></div>
      ` : '' }
      ${needsScrollbar(this.passedParams) ? `
        <div part="scrollbar" class="swiper-scrollbar"></div>
      ` : '' }
    `;
    [...this.tempDiv.children].forEach((el) => {
      this.shadowEl.appendChild(el);
    });
    this.rendered = true;
  }

  initialize() {
    if (this.initialized) return;
    this.initialized = true;
    const { params: swiperParams, passedParams } = getParams(this);
    this.swiperParams = swiperParams;
    this.passedParams = passedParams;
    delete this.swiperParams.init;

    this.render();
    // eslint-disable-next-line
    this.swiper = new Swiper(this, {
      ...swiperParams,
      touchEventsTarget: 'container',
      ...(swiperParams.virtual ? {} : { observer: true }),
      onAny: (name, ...args) => {
        const eventName = swiperParams.eventsPrefix
          ? `${swiperParams.eventsPrefix}${name.toLowerCase()}`
          : name.toLowerCase();
        const event = new CustomEvent(eventName, {
          detail: args,
          bubbles: true,
          cancelable: true,
        });
        this.dispatchEvent(event);
      },
    });
  }

  connectedCallback() {
    if (
      this.initialized &&
      this.nested &&
      this.closest('swiper-slide') &&
      this.closest('swiper-slide').swiperLoopMoveDOM
    ) {
      return;
    }
    if (this.init === false || this.getAttribute('init') === 'false') {
      addGlobalStyles(true, this);
      return;
    }
    this.initialize();
  }

  disconnectedCallback() {
    if (
      this.nested &&
      this.closest('swiper-slide') &&
      this.closest('swiper-slide').swiperLoopMoveDOM
    ) {
      return;
    }
    if (this.swiper && this.swiper.destroy) {
      this.swiper.destroy();
    }
    this.initialized = false;
  }

  updateSwiperOnPropChange(propName, propValue) {
    const { params: swiperParams, passedParams } = getParams(this, propName, propValue);
    this.passedParams = passedParams;
    this.swiperParams = swiperParams;

    updateSwiper({
      swiper: this.swiper,
      passedParams: this.passedParams,
      changedParams: [attrToProp(propName)],
      ...(propName === 'navigation' && passedParams[propName]
        ? {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next',
          }
        : {}),
      ...(propName === 'pagination' && passedParams[propName]
        ? {
            paginationEl: '.swiper-pagination',
          }
        : {}),
      ...(propName === 'scrollbar' && passedParams[propName]
        ? {
            scrollbarEl: '.swiper-scrollbar',
          }
        : {}),
    });
  }

  attributeChangedCallback(attr, prevValue, newValue) {
    if (!this.initialized) return;
    if (prevValue === 'true' && newValue === null) {
      newValue = false;
    }
    this.updateSwiperOnPropChange(attr, newValue);
  }

  static get observedAttributes() {
    const attrs = paramsList
      .filter((param) => param.includes('_'))
      .map((param) =>
        param
          .replace(/[A-Z]/g, (v) => `-${v}`)
          .replace('_', '')
          .toLowerCase(),
      );
    return attrs;
  }
}

paramsList.forEach((paramName) => {
  if (paramName === 'init') return;
  paramName = paramName.replace('_', '');
  Object.defineProperty(SwiperContainer.prototype, paramName, {
    configurable: true,
    get() {
      return (this.passedParams || {})[paramName];
    },
    set(value) {
      if (!this.passedParams) this.passedParams = {};
      this.passedParams[paramName] = value;
      if (!this.initialized) return;
      this.updateSwiperOnPropChange(paramName);
    },
  });
});

class SwiperSlide extends ClassToExtend {
  constructor() {
    super();

    this.tempDiv = document.createElement('div');
    this.shadowEl = this.attachShadow({ mode: 'open' });
  }

  render() {
    const lazy =
      this.lazy || this.getAttribute('lazy') === '' || this.getAttribute('lazy') === 'true';

    this.tempDiv.innerHTML = `<slot />`;

    [...this.tempDiv.children].forEach((el) => {
      this.shadowEl.appendChild(el);
    });

    if (lazy) {
      const lazyDiv = document.createElement('div');
      lazyDiv.classList.add('swiper-lazy-preloader');
      this.appendChild(lazyDiv);
    }
  }

  initialize() {
    this.render();
  }

  connectedCallback() {
    this.initialize();
  }
}

// eslint-disable-next-line
const register = (injectStyles = true) => {
  if (typeof window === 'undefined') return;
  if (!injectStyles) {
    globalInjectStyles = false;
  }
  if (globalInjectStyles) {
    addGlobalStyles(true);
  }
  if (!window.customElements.get('swiper-container'))
    window.customElements.define('swiper-container', SwiperContainer);
  if (!window.customElements.get('swiper-slide'))
    window.customElements.define('swiper-slide', SwiperSlide);
};

if (typeof window !== 'undefined') {
  window.SwiperElementRegisterParams = (params) => {
    paramsList.push(...params);
  };
}

//BROWSER_REGISTER

export { SwiperContainer, SwiperSlide, register };
