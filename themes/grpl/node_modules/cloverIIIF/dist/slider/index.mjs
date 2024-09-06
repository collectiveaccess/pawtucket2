import s, { useRef as O, useEffect as J, useCallback as Qe, createContext as xe, useContext as Xe, useState as K, useLayoutEffect as Ye, forwardRef as Le } from "react";
import { ErrorBoundary as et } from "react-error-boundary";
import { createStitches as tt } from "@stitches/react";
import rt from "sanitize-html";
import X from "hls.js";
import he, { Navigation as nt, A11y as it } from "swiper";
import * as Oe from "@radix-ui/react-aspect-ratio";
const ae = {
  isLoaded: !1,
  options: {
    credentials: "omit"
  }
}, _e = s.createContext(ae), ot = s.createContext(ae);
function at(t, o) {
  switch (o.type) {
    case "updateIsLoaded":
      return {
        ...t,
        isLoaded: o.isLoaded
      };
    default:
      throw new Error(`Unhandled action type: ${o.type}`);
  }
}
const st = ({
  initialState: t = ae,
  children: o
}) => {
  const [n, a] = s.useReducer(at, t);
  return /* @__PURE__ */ s.createElement(_e.Provider, { value: n }, /* @__PURE__ */ s.createElement(
    ot.Provider,
    {
      value: a
    },
    o
  ));
};
function lt() {
  const t = s.useContext(_e);
  if (t === void 0)
    throw new Error(
      "useCollectionState must be used within a CollectionProvider"
    );
  return t;
}
const fe = 209, ct = {
  colors: {
    /*
     * Black and dark grays in a light theme.
     * Must contrast to 4.5 or greater with `secondary`.
     */
    primary: "#1a1d1e",
    primaryMuted: "#26292b",
    primaryAlt: "#151718",
    /*
     * Key brand color(s).
     * Must contrast to 4.5 or greater with `secondary`.
     */
    accent: `hsl(${fe} 100% 38.2%)`,
    accentMuted: `hsl(${fe} 80% 61.8%)`,
    accentAlt: `hsl(${fe} 80% 30%)`,
    /*
     * White and light grays in a light theme.
     * Must contrast to 4.5 or greater with `primary` and  `accent`.
     */
    secondary: "#FFFFFF",
    secondaryMuted: "#e6e8eb",
    secondaryAlt: "#c1c8cd"
  },
  fontSizes: {
    1: "12px",
    2: "13px",
    3: "15px",
    4: "17px",
    5: "19px",
    6: "21px",
    7: "27px",
    8: "35px",
    9: "59px"
  },
  lineHeights: {
    1: "12px",
    2: "13px",
    3: "15px",
    4: "17px",
    5: "19px",
    6: "21px",
    7: "27px",
    8: "35px",
    9: "59px"
  },
  sizes: {
    1: "5px",
    2: "10px",
    3: "15px",
    4: "20px",
    5: "25px",
    6: "35px",
    7: "45px",
    8: "65px",
    9: "80px"
  },
  space: {
    1: "5px",
    2: "10px",
    3: "15px",
    4: "20px",
    5: "25px",
    6: "35px",
    7: "45px",
    8: "65px",
    9: "80px"
  },
  radii: {
    1: "4px",
    2: "6px",
    3: "8px",
    4: "12px",
    round: "50%",
    pill: "9999px"
  },
  transitions: {
    all: "all 300ms cubic-bezier(0.16, 1, 0.3, 1)"
  },
  zIndices: {
    1: "100",
    2: "200",
    3: "300",
    4: "400",
    max: "999"
  }
}, ut = {
  xxs: "(max-width: 349px)",
  xs: "(max-width: 575px)",
  sm: "(max-width: 767px)",
  md: "(max-width: 991px)",
  lg: "(max-width: 90rem)",
  xl: "(min-width: calc(90rem + 1px))"
}, { styled: b, css: gr, keyframes: yr, createTheme: xr } = tt({
  theme: ct,
  media: ut
}), pt = b("div", {
  display: "flex",
  flexDirection: "column",
  alignItems: "center"
}), dt = b("p", {
  fontWeight: "bold"
}), ft = b("span", {}), ht = ({ error: t }) => {
  const { message: o } = t;
  return /* @__PURE__ */ s.createElement(pt, { role: "alert" }, /* @__PURE__ */ s.createElement(dt, { "data-testid": "headline" }, "Something went wrong"), o && /* @__PURE__ */ s.createElement(ft, null, `Error message: ${o}`, " "));
}, oe = b("div", {
  display: "flex",
  background: "none",
  border: "none",
  width: "2rem !important",
  height: "2rem !important",
  padding: "0",
  margin: "0",
  borderRadius: "2rem",
  backgroundColor: "$accent",
  color: "$secondary",
  cursor: "pointer",
  boxSizing: "content-box !important",
  transition: "$all",
  justifyContent: "center",
  alignItems: "center",
  svg: {
    height: "60%",
    width: "60%",
    fill: "$secondary",
    stroke: "$secondary",
    opacity: "1",
    filter: "drop-shadow(5px 5px 5px #000D)",
    transition: "$all"
  }
}), Ae = b("button", {
  zIndex: "1",
  border: "none",
  cursor: "pointer",
  background: "transparent",
  marginLeft: "$2",
  padding: "0",
  "&:disabled": {
    [`> ${oe}`]: {
      backgroundColor: "#6663",
      boxShadow: "none",
      svg: {
        fill: "$secondary",
        stroke: "$secondary",
        filter: "unset"
      }
    }
  },
  "&:hover:enabled": {
    [`> ${oe}`]: {
      backgroundColor: "$accentAlt",
      boxShadow: "3px 3px 11px #0003",
      "&:disabled": {
        boxShadow: "unset"
      }
    }
  }
}), vt = b("div", {
  display: "flex",
  flexDirection: "column"
}), mt = b("div", {
  display: "flex",
  flexDirection: "row",
  alignItems: "center",
  paddingLeft: "$5",
  paddingRight: "$4",
  "@xs": {
    width: "100%",
    justifyContent: "center",
    padding: "$4 $1 0 0"
  }
}), gt = b("div", {
  display: "flex",
  flexDirection: "row",
  justifyContent: "space-between",
  paddingBottom: "$4",
  margin: "0",
  lineHeight: "1.4em",
  alignItems: "flex-end",
  "@xs": {
    flexDirection: "column"
  },
  ".clover-slider-header-homepage": {
    textDecoration: "none"
  },
  ".clover-slider-header-label": {
    fontSize: "1.25rem",
    fontWeight: "400"
  },
  ".clover-slider-header-summary": {
    fontSize: "$4",
    marginTop: "$2"
  }
}), yt = (t, o = "none") => {
  if (!t)
    return null;
  if (typeof t == "string")
    return [t];
  if (!t[o]) {
    const n = Object.getOwnPropertyNames(t);
    if (n.length > 0)
      return t[n[0]];
  }
  return !t[o] || !Array.isArray(t[o]) ? null : t[o];
}, se = (t, o = "none", n = ", ") => {
  const a = yt(t, o);
  return Array.isArray(a) ? a.join(`${n}`) : a;
};
function xt(t) {
  return { __html: bt(t) };
}
function Q(t, o) {
  const n = Object.keys(t).filter(
    (p) => o.includes(p) ? null : p
  ), a = new Object();
  return n.forEach((p) => {
    a[p] = t[p];
  }), a;
}
function bt(t) {
  return rt(t, {
    allowedAttributes: {
      a: ["href"],
      img: ["alt", "src", "height", "width"]
    },
    allowedSchemes: ["http", "https", "mailto"],
    allowedTags: [
      "a",
      "b",
      "br",
      "i",
      "img",
      "p",
      "small",
      "span",
      "sub",
      "sup"
    ]
  });
}
const wt = b("span", {}), ve = (t) => {
  const { as: o, label: n } = t, p = Q(t, ["as", "label"]);
  return /* @__PURE__ */ s.createElement(wt, { as: o, ...p }, se(n, p.lang));
}, St = (t, o = "200,", n = "full") => {
  Array.isArray(t) && (t = t[0]);
  const { id: a, service: p } = t;
  let l;
  if (!p)
    return a;
  if (Array.isArray(t.service) && t.service.length > 0 && (l = p[0]), l) {
    if (l["@id"])
      return `${l["@id"]}/${n}/${o}/0/default.jpg`;
    if (l.id)
      return `${l.id}/${n}/${o}/0/default.jpg`;
  }
}, Re = b("img", { objectFit: "cover" }), Ct = (t) => {
  const o = O(null), { contentResource: n, altAsLabel: a, region: p = "full" } = t;
  let l;
  a && (l = se(a));
  const m = Q(t, ["contentResource", "altAsLabel"]), { type: c, id: d, width: y = 200, height: g = 200, duration: S } = n;
  J(() => {
    if (!d && !o.current || ["Image"].includes(c) || !d.includes("m3u8"))
      return;
    const C = new X();
    return o.current && (C.attachMedia(o.current), C.on(X.Events.MEDIA_ATTACHED, function() {
      C.loadSource(d);
    })), C.on(X.Events.ERROR, function(E, v) {
      if (v.fatal)
        switch (v.type) {
          case X.ErrorTypes.NETWORK_ERROR:
            console.error(
              `fatal ${E} network error encountered, try to recover`
            ), C.startLoad();
            break;
          case X.ErrorTypes.MEDIA_ERROR:
            console.error(
              `fatal ${E} media error encountered, try to recover`
            ), C.recoverMediaError();
            break;
          default:
            C.destroy();
            break;
        }
    }), () => {
      C && (C.detachMedia(), C.destroy());
    };
  }, [d, c]);
  const A = Qe(() => {
    if (!o.current)
      return;
    let C = 0, E = 30;
    if (S && (E = S), !d.split("#t=") && S && (C = S * 0.1), d.split("#t=").pop()) {
      const I = d.split("#t=").pop();
      I && (C = parseInt(I.split(",")[0]));
    }
    const v = o.current;
    v.autoplay = !0, v.currentTime = C, setTimeout(() => A(), E * 1e3);
  }, [S, d]);
  J(() => A(), [A]);
  const _ = St(
    n,
    `${y},${g}`,
    p
  );
  switch (c) {
    case "Image":
      return /* @__PURE__ */ s.createElement(
        Re,
        {
          as: "img",
          alt: l,
          css: { width: y, height: g },
          key: d,
          src: _,
          ...m
        }
      );
    case "Video":
      return /* @__PURE__ */ s.createElement(
        Re,
        {
          as: "video",
          css: { width: y, height: g },
          disablePictureInPicture: !0,
          key: d,
          loop: !0,
          muted: !0,
          onPause: A,
          ref: o,
          src: d
        }
      );
    default:
      return console.warn(
        `Resource type: ${c} is not valid or not yet supported in Primitives.`
      ), /* @__PURE__ */ s.createElement(s.Fragment, null);
  }
}, Et = b("a", {}), je = (t) => {
  const { children: o, homepage: n } = t, p = Q(t, ["children", "homepage"]);
  return /* @__PURE__ */ s.createElement(s.Fragment, null, n && n.map((l) => {
    const f = se(
      l.label,
      p.lang
    );
    return /* @__PURE__ */ s.createElement(
      Et,
      {
        "aria-label": o ? f : void 0,
        href: l.id,
        key: l.id,
        ...p
      },
      o || f
    );
  }));
}, At = {
  delimiter: ", "
}, be = xe(void 0), Rt = () => {
  const t = Xe(be);
  if (t === void 0)
    throw new Error(
      "usePrimitivesContext must be used with a PrimitivesProvider"
    );
  return t;
}, $t = ({
  children: t,
  initialState: o = At
}) => {
  const n = It(o, "delimiter");
  return /* @__PURE__ */ s.createElement(be.Provider, { value: { delimiter: n } }, t);
}, It = (t, o) => Object.hasOwn(t, o) ? t[o].toString() : void 0, Lt = b("span", {}), $e = (t) => {
  const { as: o, markup: n } = t, { delimiter: a } = Rt();
  if (!n)
    return /* @__PURE__ */ s.createElement(s.Fragment, null);
  const l = Q(t, ["as", "markup"]), f = xt(
    se(n, l.lang, a)
  );
  return /* @__PURE__ */ s.createElement(Lt, { as: o, ...l, dangerouslySetInnerHTML: f });
}, Ot = (t) => s.useContext(be) ? /* @__PURE__ */ s.createElement($e, { ...t }) : /* @__PURE__ */ s.createElement($t, null, /* @__PURE__ */ s.createElement($e, { ...t }));
b("span", {});
b("dl", {});
b("li", {});
b("ul", {});
b("li", {});
b("ul", {});
b("dl", {});
b("li", {});
b("ul", {});
const Te = (t) => {
  const { as: o, summary: n } = t, p = Q(t, ["as", "customValueDelimiter", "summary"]);
  return /* @__PURE__ */ s.createElement(Ot, { as: o, markup: n, ...p });
}, _t = (t) => {
  const { thumbnail: o, region: n } = t, p = Q(t, ["thumbnail"]);
  return /* @__PURE__ */ s.createElement(s.Fragment, null, o && o.map((l) => /* @__PURE__ */ s.createElement(
    Ct,
    {
      contentResource: l,
      key: l.id,
      region: n,
      ...p
    }
  )));
}, jt = () => /* @__PURE__ */ s.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ s.createElement("title", null, "Next"), /* @__PURE__ */ s.createElement(
  "path",
  {
    fill: "none",
    stroke: "currentColor",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    strokeMiterlimit: "10",
    strokeWidth: "45",
    d: "M268 112l144 144-144 144M392 256H100"
  }
)), Tt = () => /* @__PURE__ */ s.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ s.createElement("title", null, "Previous"), /* @__PURE__ */ s.createElement(
  "path",
  {
    fill: "none",
    stroke: "currentColor",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    strokeMiterlimit: "10",
    strokeWidth: "45",
    d: "M244 400L100 256l144-144M120 256h292"
  }
)), Mt = b(je, {
  display: "flex",
  backgroundColor: "$accent",
  color: "$secondary",
  height: "2rem !important",
  padding: "0 $3",
  margin: "0 0 0 $3",
  borderRadius: "2rem",
  cursor: "pointer",
  boxSizing: "content-box !important",
  transition: "$all",
  justifyContent: "center",
  alignItems: "center",
  lineBreak: "none",
  whiteSpace: "nowrap",
  textDecoration: "none !important",
  fontSize: "0.8333rem",
  "&:hover": {
    backgroundColor: "$accentAlt",
    boxShadow: "3px 3px 11px #0003",
    "&:disabled": {
      boxShadow: "unset"
    }
  }
}), Pt = (t) => /* @__PURE__ */ s.createElement(Mt, { ...t }, "View All"), Dt = ({
  homepage: t,
  instance: o,
  label: n,
  summary: a
}) => {
  const [p, l] = K(!1);
  return J(() => {
    t && (t == null ? void 0 : t.length) > 0 && l(!0);
  }, [t]), /* @__PURE__ */ s.createElement(gt, { "data-testid": "slider-header" }, /* @__PURE__ */ s.createElement(vt, null, p ? /* @__PURE__ */ s.createElement(
    je,
    {
      homepage: t,
      className: "clover-slider-header-homepage"
    },
    /* @__PURE__ */ s.createElement(
      ve,
      {
        label: n,
        as: "span",
        className: "clover-slider-header-label"
      }
    )
  ) : /* @__PURE__ */ s.createElement(
    ve,
    {
      label: n,
      as: "span",
      className: "clover-slider-header-label"
    }
  ), a && /* @__PURE__ */ s.createElement(
    Te,
    {
      summary: a,
      as: "span",
      className: "clover-slider-header-summary"
    }
  )), /* @__PURE__ */ s.createElement(mt, null, /* @__PURE__ */ s.createElement(
    Ae,
    {
      className: `clover-slider-previous-${o}`,
      "aria-label": "previous"
    },
    /* @__PURE__ */ s.createElement(oe, null, /* @__PURE__ */ s.createElement(Tt, null))
  ), /* @__PURE__ */ s.createElement(
    Ae,
    {
      className: `clover-slider-next-${o}`,
      "aria-label": "next"
    },
    /* @__PURE__ */ s.createElement(oe, null, /* @__PURE__ */ s.createElement(jt, null))
  ), p && /* @__PURE__ */ s.createElement(
    Pt,
    {
      homepage: t,
      className: "clover-slider-header-view-all"
    }
  )));
};
function Z(t) {
  return typeof t == "object" && t !== null && t.constructor && Object.prototype.toString.call(t).slice(8, -1) === "Object";
}
function G(t, o) {
  const n = ["__proto__", "constructor", "prototype"];
  Object.keys(o).filter((a) => n.indexOf(a) < 0).forEach((a) => {
    typeof t[a] > "u" ? t[a] = o[a] : Z(o[a]) && Z(t[a]) && Object.keys(o[a]).length > 0 ? o[a].__swiper__ ? t[a] = o[a] : G(t[a], o[a]) : t[a] = o[a];
  });
}
function Me(t = {}) {
  return t.navigation && typeof t.navigation.nextEl > "u" && typeof t.navigation.prevEl > "u";
}
function Pe(t = {}) {
  return t.pagination && typeof t.pagination.el > "u";
}
function De(t = {}) {
  return t.scrollbar && typeof t.scrollbar.el > "u";
}
function Ne(t = "") {
  const o = t.split(" ").map((a) => a.trim()).filter((a) => !!a), n = [];
  return o.forEach((a) => {
    n.indexOf(a) < 0 && n.push(a);
  }), n.join(" ");
}
function Nt(t = "") {
  return t ? t.includes("swiper-wrapper") ? t : `swiper-wrapper ${t}` : "swiper-wrapper";
}
const ze = [
  "eventsPrefix",
  "injectStyles",
  "injectStylesUrls",
  "modules",
  "init",
  "_direction",
  "oneWayMovement",
  "touchEventsTarget",
  "initialSlide",
  "_speed",
  "cssMode",
  "updateOnWindowResize",
  "resizeObserver",
  "nested",
  "focusableElements",
  "_enabled",
  "_width",
  "_height",
  "preventInteractionOnTransition",
  "userAgent",
  "url",
  "_edgeSwipeDetection",
  "_edgeSwipeThreshold",
  "_freeMode",
  "_autoHeight",
  "setWrapperSize",
  "virtualTranslate",
  "_effect",
  "breakpoints",
  "_spaceBetween",
  "_slidesPerView",
  "maxBackfaceHiddenSlides",
  "_grid",
  "_slidesPerGroup",
  "_slidesPerGroupSkip",
  "_slidesPerGroupAuto",
  "_centeredSlides",
  "_centeredSlidesBounds",
  "_slidesOffsetBefore",
  "_slidesOffsetAfter",
  "normalizeSlideIndex",
  "_centerInsufficientSlides",
  "_watchOverflow",
  "roundLengths",
  "touchRatio",
  "touchAngle",
  "simulateTouch",
  "_shortSwipes",
  "_longSwipes",
  "longSwipesRatio",
  "longSwipesMs",
  "_followFinger",
  "allowTouchMove",
  "_threshold",
  "touchMoveStopPropagation",
  "touchStartPreventDefault",
  "touchStartForcePreventDefault",
  "touchReleaseOnEdges",
  "uniqueNavElements",
  "_resistance",
  "_resistanceRatio",
  "_watchSlidesProgress",
  "_grabCursor",
  "preventClicks",
  "preventClicksPropagation",
  "_slideToClickedSlide",
  "_loop",
  "loopedSlides",
  "loopPreventsSliding",
  "_rewind",
  "_allowSlidePrev",
  "_allowSlideNext",
  "_swipeHandler",
  "_noSwiping",
  "noSwipingClass",
  "noSwipingSelector",
  "passiveListeners",
  "containerModifierClass",
  "slideClass",
  "slideActiveClass",
  "slideVisibleClass",
  "slideNextClass",
  "slidePrevClass",
  "wrapperClass",
  "lazyPreloaderClass",
  "lazyPreloadPrevNext",
  "runCallbacksOnInit",
  "observer",
  "observeParents",
  "observeSlideChildren",
  // modules
  "a11y",
  "_autoplay",
  "_controller",
  "coverflowEffect",
  "cubeEffect",
  "fadeEffect",
  "flipEffect",
  "creativeEffect",
  "cardsEffect",
  "hashNavigation",
  "history",
  "keyboard",
  "mousewheel",
  "_navigation",
  "_pagination",
  "parallax",
  "_scrollbar",
  "_thumbs",
  "virtual",
  "zoom",
  "control"
];
function zt(t = {}, o = !0) {
  const n = {
    on: {}
  }, a = {}, p = {};
  G(n, he.defaults), G(n, he.extendedDefaults), n._emitClasses = !0, n.init = !1;
  const l = {}, f = ze.map((c) => c.replace(/_/, "")), m = Object.assign({}, t);
  return Object.keys(m).forEach((c) => {
    typeof t[c] > "u" || (f.indexOf(c) >= 0 ? Z(t[c]) ? (n[c] = {}, p[c] = {}, G(n[c], t[c]), G(p[c], t[c])) : (n[c] = t[c], p[c] = t[c]) : c.search(/on[A-Z]/) === 0 && typeof t[c] == "function" ? o ? a[`${c[2].toLowerCase()}${c.substr(3)}`] = t[c] : n.on[`${c[2].toLowerCase()}${c.substr(3)}`] = t[c] : l[c] = t[c]);
  }), ["navigation", "pagination", "scrollbar"].forEach((c) => {
    n[c] === !0 && (n[c] = {}), n[c] === !1 && delete n[c];
  }), {
    params: n,
    passedParams: p,
    rest: l,
    events: a
  };
}
function Ft({
  el: t,
  nextEl: o,
  prevEl: n,
  paginationEl: a,
  scrollbarEl: p,
  swiper: l
}, f) {
  Me(f) && o && n && (l.params.navigation.nextEl = o, l.originalParams.navigation.nextEl = o, l.params.navigation.prevEl = n, l.originalParams.navigation.prevEl = n), Pe(f) && a && (l.params.pagination.el = a, l.originalParams.pagination.el = a), De(f) && p && (l.params.scrollbar.el = p, l.originalParams.scrollbar.el = p), l.init(t);
}
function kt(t, o, n, a, p) {
  const l = [];
  if (!o)
    return l;
  const f = (c) => {
    l.indexOf(c) < 0 && l.push(c);
  };
  if (n && a) {
    const c = a.map(p), d = n.map(p);
    c.join("") !== d.join("") && f("children"), a.length !== n.length && f("children");
  }
  return ze.filter((c) => c[0] === "_").map((c) => c.replace(/_/, "")).forEach((c) => {
    if (c in t && c in o)
      if (Z(t[c]) && Z(o[c])) {
        const d = Object.keys(t[c]), y = Object.keys(o[c]);
        d.length !== y.length ? f(c) : (d.forEach((g) => {
          t[c][g] !== o[c][g] && f(c);
        }), y.forEach((g) => {
          t[c][g] !== o[c][g] && f(c);
        }));
      } else
        t[c] !== o[c] && f(c);
  }), l;
}
function Fe(t) {
  return t.type && t.type.displayName && t.type.displayName.includes("SwiperSlide");
}
function ke(t) {
  const o = [];
  return s.Children.toArray(t).forEach((n) => {
    Fe(n) ? o.push(n) : n.props && n.props.children && ke(n.props.children).forEach((a) => o.push(a));
  }), o;
}
function Bt(t) {
  const o = [], n = {
    "container-start": [],
    "container-end": [],
    "wrapper-start": [],
    "wrapper-end": []
  };
  return s.Children.toArray(t).forEach((a) => {
    if (Fe(a))
      o.push(a);
    else if (a.props && a.props.slot && n[a.props.slot])
      n[a.props.slot].push(a);
    else if (a.props && a.props.children) {
      const p = ke(a.props.children);
      p.length > 0 ? p.forEach((l) => o.push(l)) : n["container-end"].push(a);
    } else
      n["container-end"].push(a);
  }), {
    slides: o,
    slots: n
  };
}
function Ht({
  swiper: t,
  slides: o,
  passedParams: n,
  changedParams: a,
  nextEl: p,
  prevEl: l,
  scrollbarEl: f,
  paginationEl: m
}) {
  const c = a.filter((h) => h !== "children" && h !== "direction" && h !== "wrapperClass"), {
    params: d,
    pagination: y,
    navigation: g,
    scrollbar: S,
    virtual: A,
    thumbs: _
  } = t;
  let C, E, v, I, T, M, j, L;
  a.includes("thumbs") && n.thumbs && n.thumbs.swiper && d.thumbs && !d.thumbs.swiper && (C = !0), a.includes("controller") && n.controller && n.controller.control && d.controller && !d.controller.control && (E = !0), a.includes("pagination") && n.pagination && (n.pagination.el || m) && (d.pagination || d.pagination === !1) && y && !y.el && (v = !0), a.includes("scrollbar") && n.scrollbar && (n.scrollbar.el || f) && (d.scrollbar || d.scrollbar === !1) && S && !S.el && (I = !0), a.includes("navigation") && n.navigation && (n.navigation.prevEl || l) && (n.navigation.nextEl || p) && (d.navigation || d.navigation === !1) && g && !g.prevEl && !g.nextEl && (T = !0);
  const z = (h) => {
    t[h] && (t[h].destroy(), h === "navigation" ? (t.isElement && (t[h].prevEl.remove(), t[h].nextEl.remove()), d[h].prevEl = void 0, d[h].nextEl = void 0, t[h].prevEl = void 0, t[h].nextEl = void 0) : (t.isElement && t[h].el.remove(), d[h].el = void 0, t[h].el = void 0));
  };
  a.includes("loop") && t.isElement && (d.loop && !n.loop ? M = !0 : !d.loop && n.loop ? j = !0 : L = !0), c.forEach((h) => {
    if (Z(d[h]) && Z(n[h]))
      G(d[h], n[h]), (h === "navigation" || h === "pagination" || h === "scrollbar") && "enabled" in n[h] && !n[h].enabled && z(h);
    else {
      const P = n[h];
      (P === !0 || P === !1) && (h === "navigation" || h === "pagination" || h === "scrollbar") ? P === !1 && z(h) : d[h] = n[h];
    }
  }), c.includes("controller") && !E && t.controller && t.controller.control && d.controller && d.controller.control && (t.controller.control = d.controller.control), a.includes("children") && o && A && d.virtual.enabled && (A.slides = o, A.update(!0)), a.includes("children") && o && d.loop && (L = !0), C && _.init() && _.update(!0), E && (t.controller.control = d.controller.control), v && (t.isElement && (!m || typeof m == "string") && (m = document.createElement("div"), m.classList.add("swiper-pagination"), t.el.shadowEl.appendChild(m)), m && (d.pagination.el = m), y.init(), y.render(), y.update()), I && (t.isElement && (!f || typeof f == "string") && (f = document.createElement("div"), f.classList.add("swiper-scrollbar"), t.el.shadowEl.appendChild(f)), f && (d.scrollbar.el = f), S.init(), S.updateSize(), S.setTranslate()), T && (t.isElement && ((!p || typeof p == "string") && (p = document.createElement("div"), p.classList.add("swiper-button-next"), t.el.shadowEl.appendChild(p)), (!l || typeof l == "string") && (l = document.createElement("div"), l.classList.add("swiper-button-prev"), t.el.shadowEl.appendChild(l))), p && (d.navigation.nextEl = p), l && (d.navigation.prevEl = l), g.init(), g.update()), a.includes("allowSlideNext") && (t.allowSlideNext = n.allowSlideNext), a.includes("allowSlidePrev") && (t.allowSlidePrev = n.allowSlidePrev), a.includes("direction") && t.changeDirection(n.direction, !1), (M || L) && t.loopDestroy(), (j || L) && t.loopCreate(), t.update();
}
function Wt(t, o, n) {
  if (!n)
    return null;
  const a = (y) => {
    let g = y;
    return y < 0 ? g = o.length + y : g >= o.length && (g = g - o.length), g;
  }, p = t.isHorizontal() ? {
    [t.rtlTranslate ? "right" : "left"]: `${n.offset}px`
  } : {
    top: `${n.offset}px`
  }, {
    from: l,
    to: f
  } = n, m = t.params.loop ? -o.length : 0, c = t.params.loop ? o.length * 2 : o.length, d = [];
  for (let y = m; y < c; y += 1)
    y >= l && y <= f && d.push(o[a(y)]);
  return d.map((y, g) => /* @__PURE__ */ s.cloneElement(y, {
    swiper: t,
    style: p,
    key: `slide-${g}`
  }));
}
const qt = (t) => {
  !t || t.destroyed || !t.params.virtual || t.params.virtual && !t.params.virtual.enabled || (t.updateSlides(), t.updateProgress(), t.updateSlidesClasses(), t.parallax && t.params.parallax && t.params.parallax.enabled && t.parallax.setTranslate());
};
function Y(t, o) {
  return typeof window > "u" ? J(t, o) : Ye(t, o);
}
const Ie = /* @__PURE__ */ xe(null), Vt = /* @__PURE__ */ xe(null);
function me() {
  return me = Object.assign ? Object.assign.bind() : function(t) {
    for (var o = 1; o < arguments.length; o++) {
      var n = arguments[o];
      for (var a in n)
        Object.prototype.hasOwnProperty.call(n, a) && (t[a] = n[a]);
    }
    return t;
  }, me.apply(this, arguments);
}
const Be = /* @__PURE__ */ Le(function(t, o) {
  let {
    className: n,
    tag: a = "div",
    wrapperTag: p = "div",
    children: l,
    onSwiper: f,
    ...m
  } = t === void 0 ? {} : t, c = !1;
  const [d, y] = K("swiper"), [g, S] = K(null), [A, _] = K(!1), C = O(!1), E = O(null), v = O(null), I = O(null), T = O(null), M = O(null), j = O(null), L = O(null), z = O(null), {
    params: h,
    passedParams: P,
    rest: le,
    events: F
  } = zt(m), {
    slides: D,
    slots: q
  } = Bt(l), ee = () => {
    _(!A);
  };
  Object.assign(h.on, {
    _containerClasses(R, N) {
      y(N);
    }
  });
  const te = () => {
    Object.assign(h.on, F), c = !0;
    const R = {
      ...h
    };
    if (delete R.wrapperClass, v.current = new he(R), v.current.virtual && v.current.params.virtual.enabled) {
      v.current.virtual.slides = D;
      const N = {
        cache: !1,
        slides: D,
        renderExternal: S,
        renderExternalUpdate: !1
      };
      G(v.current.params.virtual, N), G(v.current.originalParams.virtual, N);
    }
  };
  E.current || te(), v.current && v.current.on("_beforeBreakpoint", ee);
  const ce = () => {
    c || !F || !v.current || Object.keys(F).forEach((R) => {
      v.current.on(R, F[R]);
    });
  }, k = () => {
    !F || !v.current || Object.keys(F).forEach((R) => {
      v.current.off(R, F[R]);
    });
  };
  J(() => () => {
    v.current && v.current.off("_beforeBreakpoint", ee);
  }), J(() => {
    !C.current && v.current && (v.current.emitSlidesClasses(), C.current = !0);
  }), Y(() => {
    if (o && (o.current = E.current), !!E.current)
      return v.current.destroyed && te(), Ft({
        el: E.current,
        nextEl: M.current,
        prevEl: j.current,
        paginationEl: L.current,
        scrollbarEl: z.current,
        swiper: v.current
      }, h), f && f(v.current), () => {
        v.current && !v.current.destroyed && v.current.destroy(!0, !1);
      };
  }, []), Y(() => {
    ce();
    const R = kt(P, I.current, D, T.current, (N) => N.key);
    return I.current = P, T.current = D, R.length && v.current && !v.current.destroyed && Ht({
      swiper: v.current,
      slides: D,
      passedParams: P,
      changedParams: R,
      nextEl: M.current,
      prevEl: j.current,
      scrollbarEl: z.current,
      paginationEl: L.current
    }), () => {
      k();
    };
  }), Y(() => {
    qt(v.current);
  }, [g]);
  function re() {
    return h.virtual ? Wt(v.current, D, g) : D.map((R, N) => /* @__PURE__ */ s.cloneElement(R, {
      swiper: v.current,
      swiperSlideIndex: N
    }));
  }
  return /* @__PURE__ */ s.createElement(a, me({
    ref: E,
    className: Ne(`${d}${n ? ` ${n}` : ""}`)
  }, le), /* @__PURE__ */ s.createElement(Vt.Provider, {
    value: v.current
  }, q["container-start"], /* @__PURE__ */ s.createElement(p, {
    className: Nt(h.wrapperClass)
  }, q["wrapper-start"], re(), q["wrapper-end"]), Me(h) && /* @__PURE__ */ s.createElement(s.Fragment, null, /* @__PURE__ */ s.createElement("div", {
    ref: j,
    className: "swiper-button-prev"
  }), /* @__PURE__ */ s.createElement("div", {
    ref: M,
    className: "swiper-button-next"
  })), De(h) && /* @__PURE__ */ s.createElement("div", {
    ref: z,
    className: "swiper-scrollbar"
  }), Pe(h) && /* @__PURE__ */ s.createElement("div", {
    ref: L,
    className: "swiper-pagination"
  }), q["container-end"]));
});
Be.displayName = "Swiper";
function ge() {
  return ge = Object.assign ? Object.assign.bind() : function(t) {
    for (var o = 1; o < arguments.length; o++) {
      var n = arguments[o];
      for (var a in n)
        Object.prototype.hasOwnProperty.call(n, a) && (t[a] = n[a]);
    }
    return t;
  }, ge.apply(this, arguments);
}
const He = /* @__PURE__ */ Le(function(t, o) {
  let {
    tag: n = "div",
    children: a,
    className: p = "",
    swiper: l,
    zoom: f,
    lazy: m,
    virtualIndex: c,
    swiperSlideIndex: d,
    ...y
  } = t === void 0 ? {} : t;
  const g = O(null), [S, A] = K("swiper-slide"), [_, C] = K(!1);
  function E(M, j, L) {
    j === g.current && A(L);
  }
  Y(() => {
    if (typeof d < "u" && (g.current.swiperSlideIndex = d), o && (o.current = g.current), !(!g.current || !l)) {
      if (l.destroyed) {
        S !== "swiper-slide" && A("swiper-slide");
        return;
      }
      return l.on("_slideClass", E), () => {
        l && l.off("_slideClass", E);
      };
    }
  }), Y(() => {
    l && g.current && !l.destroyed && A(l.getSlideClasses(g.current));
  }, [l]);
  const v = {
    isActive: S.indexOf("swiper-slide-active") >= 0,
    isVisible: S.indexOf("swiper-slide-visible") >= 0,
    isPrev: S.indexOf("swiper-slide-prev") >= 0,
    isNext: S.indexOf("swiper-slide-next") >= 0
  }, I = () => typeof a == "function" ? a(v) : a, T = () => {
    C(!0);
  };
  return /* @__PURE__ */ s.createElement(n, ge({
    ref: g,
    className: Ne(`${S}${p ? ` ${p}` : ""}`),
    "data-swiper-slide-index": c,
    onLoad: T
  }, y), f && /* @__PURE__ */ s.createElement(Ie.Provider, {
    value: v
  }, /* @__PURE__ */ s.createElement("div", {
    className: "swiper-zoom-container",
    "data-swiper-zoom": typeof f == "number" ? f : void 0
  }, I(), m && !_ && /* @__PURE__ */ s.createElement("div", {
    className: "swiper-lazy-preloader"
  }))), !f && /* @__PURE__ */ s.createElement(Ie.Provider, {
    value: v
  }, I(), m && !_ && /* @__PURE__ */ s.createElement("div", {
    className: "swiper-lazy-preloader"
  })));
});
He.displayName = "SwiperSlide";
const Ut = b("a", {
  textDecoration: "none"
}), Gt = b("div", {
  position: "relative",
  zIndex: "0",
  borderRadius: "3px"
}), Kt = b("div", {
  position: "absolute",
  width: "100%",
  backgroundColor: "green"
}), Jt = b("figure", {
  display: "flex",
  flexDirection: "column",
  margin: "0 0 $2",
  flexGrow: "0",
  flexShrink: "0",
  borderRadius: "3px",
  transition: "$all",
  img: {
    position: "absolute",
    display: "flex",
    flexDirection: "column",
    objectFit: "cover",
    zIndex: "0",
    width: "100%",
    height: "100%",
    color: "transparent"
  },
  video: {
    position: "absolute",
    display: "flex",
    flexDirection: "column",
    objectFit: "cover",
    zIndex: "1",
    width: "100%",
    height: "100%",
    color: "transparent",
    opacity: "0",
    transition: "$load",
    borderRadius: "3px"
  },
  figcaption: {
    display: "flex",
    flexDirection: "column",
    padding: "$2 0",
    transition: "$all"
  },
  variants: {
    isFocused: {
      true: {
        video: {
          opacity: "1"
        },
        figcaption: {
          color: "$accent"
        }
      }
    }
  }
}), Zt = b("span", {
  display: "flex",
  position: "relative",
  width: "100%",
  height: "100%",
  overflow: "hidden",
  borderRadius: "3px",
  boxShadow: "none",
  transition: "$all"
}), Qt = b(ve, {
  fontSize: "$3",
  fontWeight: "700"
}), Xt = b(Te, {
  fontSize: "$2",
  marginTop: "$1"
}), Yt = ({
  isFocused: t,
  label: o,
  summary: n,
  thumbnail: a
}) => {
  const p = O(null);
  return /* @__PURE__ */ s.createElement(Jt, { isFocused: t }, /* @__PURE__ */ s.createElement(Oe.Root, { ratio: 1 / 1 }, /* @__PURE__ */ s.createElement(Kt, { ref: p }), /* @__PURE__ */ s.createElement(Zt, null, /* @__PURE__ */ s.createElement(
    _t,
    {
      altAsLabel: o,
      thumbnail: a,
      "data-testid": "figure-thumbnail"
    }
  ))), /* @__PURE__ */ s.createElement("figcaption", null, /* @__PURE__ */ s.createElement(Qt, { label: o }), n && /* @__PURE__ */ s.createElement(Xt, { summary: n })));
}, er = ({ backgroundImage: t }) => /* @__PURE__ */ s.createElement(rr, { "data-testid": "slider-item-placeholder" }, /* @__PURE__ */ s.createElement(
  tr,
  {
    ratio: 1 / 1,
    css: {
      backgroundImage: `url(${t})`
    }
  }
)), tr = b(Oe.Root, {
  backgroundSize: "cover",
  backgroundRepeat: "no-repeat",
  backgroundPosition: "50% 50%",
  filter: "blur(3em)",
  opacity: "0.7"
}), rr = b("div", {
  position: "absolute",
  width: "100%",
  overflow: "hidden",
  backgroundColor: "#716C6B"
}), nr = ({ handleItemInteraction: t, index: o, item: n }) => {
  var y, g;
  const [a, p] = K(!1);
  let l = [], f = "#";
  n != null && n.thumbnail && ((y = n == null ? void 0 : n.thumbnail) == null ? void 0 : y.length) > 0 && (l = n.thumbnail), n != null && n.homepage && ((g = n.homepage) == null ? void 0 : g.length) > 0 && (f = n.homepage[0].id);
  const m = () => p(!0), c = () => p(!1), d = (S) => {
    t && (S.preventDefault(), t(n));
  };
  return /* @__PURE__ */ s.createElement(Gt, { "data-testid": "slider-item" }, /* @__PURE__ */ s.createElement(
    Ut,
    {
      "data-testid": "slider-item-anchor",
      href: f,
      onClick: d,
      tabIndex: 0,
      onFocus: m,
      onBlur: c,
      onMouseEnter: m,
      onMouseLeave: c
    },
    /* @__PURE__ */ s.createElement(er, { backgroundImage: "" }),
    /* @__PURE__ */ s.createElement(
      Yt,
      {
        "data-testid": "slider-item-figure",
        index: o,
        isFocused: a,
        key: n.id,
        label: n.label,
        summary: n.summary,
        thumbnail: l
      }
    )
  ));
}, ir = b("div", {
  "& .swiper-slide": {}
}), or = {
  640: {
    slidesPerView: 2,
    slidesPerGroup: 2,
    spaceBetween: 20
  },
  768: {
    slidesPerView: 3,
    slidesPerGroup: 3,
    spaceBetween: 30
  },
  1024: {
    slidesPerView: 4,
    slidesPerGroup: 4,
    spaceBetween: 40
  },
  1366: {
    slidesPerView: 5,
    slidesPerGroup: 5,
    spaceBetween: 50
  },
  1920: {
    slidesPerView: 6,
    slidesPerGroup: 6,
    spaceBetween: 60
  }
}, ar = ({
  breakpoints: t = or,
  handleItemInteraction: o,
  instance: n,
  items: a
}) => {
  const p = O(null);
  return /* @__PURE__ */ s.createElement(ir, { ref: p }, /* @__PURE__ */ s.createElement(
    Be,
    {
      a11y: {
        prevSlideMessage: "previous item",
        nextSlideMessage: "next item"
      },
      spaceBetween: 31,
      modules: [nt, it],
      navigation: {
        nextEl: `.clover-slider-next-${n}`,
        prevEl: `.clover-slider-previous-${n}`
      },
      slidesPerView: 2,
      slidesPerGroup: 2,
      breakpoints: t
    },
    a.map((l, f) => /* @__PURE__ */ s.createElement(
      He,
      {
        key: `${l.id}-${f}`,
        "data-index": f,
        "data-type": l == null ? void 0 : l.type.toLowerCase()
      },
      /* @__PURE__ */ s.createElement(
        nr,
        {
          handleItemInteraction: o,
          index: f,
          item: l
        }
      )
    ))
  ));
}, sr = (t) => {
  let o = 0;
  const n = t == null ? void 0 : t.length;
  let a = 0;
  if (n > 0)
    for (; a < n; )
      o = (o << 5) - o + t.charCodeAt(a++) | 0;
  return o;
};
var lr = typeof globalThis < "u" ? globalThis : typeof window < "u" ? window : typeof global < "u" ? global : typeof self < "u" ? self : {}, ye = { exports: {} };
(function(t, o) {
  var n = Object.defineProperty, a = (l, f, m) => f in l ? n(l, f, { enumerable: !0, configurable: !0, writable: !0, value: m }) : l[f] = m, p = (l, f, m) => (a(l, typeof f != "symbol" ? f + "" : f, m), m);
  (function(l, f) {
    f(o);
  })(lr, function(l) {
    const f = "http://library.stanford.edu/iiif/image-api/compliance.html#level1", m = "http://library.stanford.edu/iiif/image-api/compliance.html#level2", c = "http://library.stanford.edu/iiif/image-api/conformance.html#level1", d = "http://library.stanford.edu/iiif/image-api/conformance.html#level2", y = "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level1", g = "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level2", S = "http://library.stanford.edu/iiif/image-api/1.1/conformance.html#level1", A = "http://library.stanford.edu/iiif/image-api/1.1/conformance.html#level2", _ = "http://iiif.io/api/image/1/level1.json", C = "http://iiif.io/api/image/1/profiles/level1.json", E = "http://iiif.io/api/image/1/level2.json", v = "http://iiif.io/api/image/1/profiles/level2.json", I = "http://iiif.io/api/image/2/level1.json", T = "http://iiif.io/api/image/2/profiles/level1.json", M = "http://iiif.io/api/image/2/level2.json", j = "http://iiif.io/api/image/2/profiles/level2.json", L = "level1", z = "level2", h = "http://iiif.io/api/image/2/level1", P = "http://iiif.io/api/image/2/level2", le = [h, P, f, m, c, d, y, g, S, A, _, C, E, v, I, T, M, j, L, z], F = ["http://iiif.io/api/image/2/level0", h, P, "http://library.stanford.edu/iiif/image-api/compliance.html#level0", f, m, "http://library.stanford.edu/iiif/image-api/conformance.html#level0", c, d, "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level0", y, g, "http://library.stanford.edu/iiif/image-api/1.1/conformance.html#level0", S, A, "http://iiif.io/api/image/1/level0.json", "http://iiif.io/api/image/1/profiles/level0.json", _, C, E, v, "http://iiif.io/api/image/2/level0.json", "http://iiif.io/api/image/2/profiles/level0.json", I, T, M, j, "level0", L, z], D = ["sc:Collection", "sc:Manifest", "sc:Canvas", "sc:AnnotationList", "oa:Annotation", "sc:Range", "sc:Layer", "sc:Sequence", "oa:Choice", "Service", "ContentResource"];
    class q {
      constructor(e, i = {}) {
        p(this, "traversals"), p(this, "options"), this.traversals = { collection: [], manifest: [], canvas: [], annotationList: [], sequence: [], annotation: [], contentResource: [], choice: [], range: [], service: [], layer: [], ...e }, this.options = { convertPropsToArray: !0, mergeMemberProperties: !0, allowUndefinedReturn: !1, ...i };
      }
      static all(e) {
        return new q({ collection: [e], manifest: [e], canvas: [e], annotationList: [e], sequence: [e], annotation: [e], contentResource: [e], choice: [e], range: [e], service: [e], layer: [e] });
      }
      traverseCollection(e) {
        return this.traverseType(this.traverseDescriptive(this.traverseLinking(this.traverseCollectionItems(e))), this.traversals.collection);
      }
      traverseCollectionItems(e) {
        if (this.options.mergeMemberProperties) {
          const i = [...(e.manifests || []).map((u) => typeof u == "string" ? { "@id": u, "@type": "sc:Manifest" } : u), ...(e.collections || []).map((u) => typeof u == "string" ? { "@id": u, "@type": "sc:Collection" } : u), ...e.members || []];
          delete e.collections, delete e.manifests, e.members = i;
        }
        return e.manifests && (e.manifests = e.manifests.map((i) => this.traverseManifest(typeof i == "string" ? { "@id": i, "@type": "sc:Manifest" } : i))), e.collections && (e.collections = e.collections.map((i) => this.traverseCollection(typeof i == "string" ? { "@id": i, "@type": "sc:Collection" } : i))), e.members && (e.members = e.members.map((i) => typeof i == "string" ? i : this.traverseUnknown(i))), e;
      }
      traverseManifest(e) {
        return this.traverseType(this.traverseDescriptive(this.traverseLinking(this.traverseManifestItems(e))), this.traversals.manifest);
      }
      traverseManifestItems(e) {
        return e.sequences && (e.sequences = e.sequences.map((i) => this.traverseSequence(i))), e.structures && (e.structures = e.structures.map((i) => this.traverseRange(i))), e;
      }
      traverseSequence(e) {
        return this.traverseType(this.traverseDescriptive(this.traverseLinking(this.traverseSequenceItems(e))), this.traversals.sequence);
      }
      traverseSequenceItems(e) {
        return e.canvases && (e.canvases = e.canvases.map((i) => this.traverseCanvas(i))), e;
      }
      traverseCanvas(e) {
        return this.traverseType(this.traverseDescriptive(this.traverseLinking(this.traverseCanvasItems(e))), this.traversals.canvas);
      }
      traverseCanvasItems(e) {
        return e.images && (e.images = e.images.map((i) => this.traverseAnnotation(i))), e.otherContent && (e.otherContent = e.otherContent.map((i) => this.traverseAnnotationList(i))), e;
      }
      traverseRange(e) {
        return this.traverseType(this.traverseDescriptive(this.traverseLinking(this.traverseRangeItems(e))), this.traversals.range);
      }
      traverseRangeItems(e) {
        if (this.options.mergeMemberProperties) {
          const i = [...(e.ranges || []).map((u) => typeof u == "string" ? { "@id": u, "@type": "sc:Range" } : u), ...(e.canvases || []).map((u) => typeof u == "string" ? { "@id": u, "@type": "sc:Canvas" } : u), ...e.members || []];
          delete e.ranges, delete e.canvases, e.members = i.length ? i.map((u) => this.traverseUnknown(u)) : void 0;
        }
        return e;
      }
      traverseAnnotationList(e) {
        const i = typeof e == "string" ? { "@id": e, "@type": "sc:AnnotationList" } : e;
        return this.traverseType(this.traverseDescriptive(this.traverseAnnotationListItems(i)), this.traversals.annotationList);
      }
      traverseAnnotationListItems(e) {
        return e.resources && (e.resources = e.resources.map((i) => this.traverseAnnotation(i))), e;
      }
      traverseAnnotation(e) {
        return this.traverseType(this.traverseDescriptive(this.traverseLinking(this.traverseAnnotationItems(e))), this.traversals.annotation);
      }
      traverseAnnotationItems(e) {
        return e.resource && (Array.isArray(e.resource) ? e.resource = e.resource.map((i) => this.traverseContentResource(i)) : e.resource = this.traverseContentResource(e.resource)), e.on, e;
      }
      traverseLayer(e) {
        return this.traverseType(this.traverseLinking(this.traverseLayerItems(e)), this.traversals.layer);
      }
      traverseLayerItems(e) {
        return e.otherContent && (e.otherContent = e.otherContent.map((i) => this.traverseAnnotationList(i))), e;
      }
      traverseChoice(e) {
        return this.traverseType(this.traverseChoiceItems(e), this.traversals.choice);
      }
      traverseChoiceItems(e) {
        return e.default && e.default !== "rdf:nil" && (e.default = this.traverseContentResource(e.default)), e.item && e.item !== "rdf:nil" && (e.item = e.item.map((i) => this.traverseContentResource(i))), e;
      }
      traverseService(e) {
        return this.traverseType(this.traverseLinking(e), this.traversals.service);
      }
      traverseContentResource(e) {
        return e["@type"] === "oa:Choice" ? this.traverseChoice(e) : this.traverseType(this.traverseDescriptive(this.traverseLinking(e)), this.traversals.contentResource);
      }
      traverseUnknown(e) {
        if (!e["@type"] || typeof e == "string")
          return e;
        switch (function(i) {
          if (i == null)
            throw new Error("Null or undefined is not a valid entity.");
          if (Array.isArray(i))
            throw new Error("Array is not a valid entity");
          if (typeof i != "object")
            throw new Error(typeof i + " is not a valid entity");
          if (typeof i["@type"] == "string") {
            const u = D.indexOf(i["@type"]);
            if (u !== -1)
              return D[u];
          }
          if (i.profile)
            return "Service";
          if (i.format || i["@type"])
            return "ContentResource";
          throw new Error("Resource type is not known");
        }(e)) {
          case "sc:Collection":
            return this.traverseCollection(e);
          case "sc:Manifest":
            return this.traverseManifest(e);
          case "sc:Canvas":
            return this.traverseCanvas(e);
          case "sc:Sequence":
            return this.traverseSequence(e);
          case "sc:Range":
            return this.traverseRange(e);
          case "oa:Annotation":
            return this.traverseAnnotation(e);
          case "sc:AnnotationList":
            return this.traverseAnnotationList(e);
          case "sc:Layer":
            return this.traverseLayer(e);
          case "Service":
            return this.traverseService(e);
          case "oa:Choice":
            return this.traverseChoice(e);
          case "ContentResource":
            return this.traverseContentResource(e);
        }
        return e.profile ? this.traverseService(e) : e;
      }
      traverseImageResource(e) {
        const i = Array.isArray(e), u = Array.isArray(e) ? e : [e], x = [];
        for (const w of u)
          typeof w == "string" ? x.push(this.traverseContentResource({ "@id": w, "@type": "dctypes:Image" })) : x.push(this.traverseContentResource(w));
        return i || this.options.convertPropsToArray ? x : x[0];
      }
      traverseDescriptive(e) {
        return e.thumbnail && (e.thumbnail = this.traverseImageResource(e.thumbnail)), e.logo && (e.logo = this.traverseImageResource(e.logo)), e;
      }
      traverseOneOrMoreServices(e) {
        const i = Array.isArray(e), u = Array.isArray(e) ? e : [e], x = [];
        for (const w of u)
          x.push(this.traverseService(w));
        return i || this.options.convertPropsToArray ? x : x[0];
      }
      traverseLinking(e) {
        return e.related && (e.related = this.traverseOneOrManyType(e.related, this.traversals.contentResource)), e.rendering && (e.rendering = this.traverseOneOrManyType(e.rendering, this.traversals.contentResource)), e.service && (e.service = this.traverseOneOrMoreServices(e.service)), e.seeAlso && (e.seeAlso = this.traverseOneOrManyType(e.seeAlso, this.traversals.contentResource)), e.within && (typeof e.within == "string" || (e.within = this.traverseOneOrManyType(e.within, this.traversals.contentResource))), e.startCanvas && (typeof e.startCanvas == "string" ? e.startCanvas = this.traverseType({ "@id": e.startCanvas, "@type": "sc:Canvas" }, this.traversals.canvas) : e.startCanvas && this.traverseType(e.startCanvas, this.traversals.canvas)), e.contentLayer && (typeof e.contentLayer == "string" ? e.contentLayer = this.traverseLayer({ "@id": e.contentLayer, "@type": "sc:Layer" }) : e.contentLayer = this.traverseLayer(e.contentLayer)), e;
      }
      traverseOneOrManyType(e, i) {
        if (!Array.isArray(e)) {
          if (!this.options.convertPropsToArray)
            return this.traverseType(e, i);
          e = [e];
        }
        return e.map((u) => this.traverseType(u, i));
      }
      traverseType(e, i) {
        return i.reduce((u, x) => {
          const w = x(u);
          return w !== void 0 || this.options.allowUndefinedReturn ? w : u;
        }, e);
      }
    }
    const ee = "Attribution", te = "http://example.org/provider", ce = "Unknown";
    function k(r, e = "none") {
      if (!r)
        return {};
      const i = Array.isArray(r) ? r : [r], u = {};
      for (const x of i) {
        if (typeof x == "string") {
          u[e] = u[e] ? u[e] : [], u[e].push(x || "");
          continue;
        }
        if (!x["@language"]) {
          u[e] = u[e] ? u[e] : [], u[e].push(x["@value"] || "");
          continue;
        }
        const w = x["@language"];
        u[w] = u[w] ? u[w] : [], u[w].push(x["@value"] || "");
      }
      return u;
    }
    function re(r) {
      return Array.isArray(r) ? re(r.find((e) => typeof e == "string")) : F.indexOf(r) !== -1 ? "level2" : le.indexOf(r) !== -1 ? "level1" : typeof r == "string" ? r : void 0;
    }
    function R(r) {
      for (const e of ["sc", "oa", "dcterms", "dctypes", "iiif"])
        if (r.startsWith(`${e}:`))
          return r.slice(e.length + 1);
      return r;
    }
    const N = ["Collection", "Manifest", "Annotation", "AnnotationPage", "Range", "Service"];
    function ue(r) {
      const e = r["@id"] || r.id;
      let i = r["@type"] || r.type;
      const u = r.profile || void 0, x = r["@context"] || void 0;
      if (u) {
        const w = function($) {
          switch ($) {
            case "http://iiif.io/api/image/2/level0.json":
            case "http://iiif.io/api/image/2/level1.json":
            case "http://iiif.io/api/image/2/level2.json":
              return "ImageService2";
            case "http://iiif.io/api/auth/1/kiosk":
            case "http://iiif.io/api/auth/1/login":
            case "http://iiif.io/api/auth/1/clickthrough":
            case "http://iiif.io/api/auth/1/external":
            case "http://iiif.io/api/auth/0/kiosk":
            case "http://iiif.io/api/auth/0/login":
            case "http://iiif.io/api/auth/0/clickthrough":
            case "http://iiif.io/api/auth/0/external":
              return "AuthCookieService1";
            case "http://iiif.io/api/auth/1/token":
            case "http://iiif.io/api/auth/0/token":
              return "AuthTokenService1";
            case "http://iiif.io/api/auth/1/logout":
            case "http://iiif.io/api/auth/0/logout":
              return "AuthLogoutService1";
            case "http://iiif.io/api/search/1/search":
            case "http://iiif.io/api/search/0/search":
              return "SearchService1";
            case "http://iiif.io/api/search/1/autocomplete":
            case "http://iiif.io/api/search/0/autocomplete":
              return "AutoCompleteService1";
          }
        }(u);
        if (w)
          return w;
      }
      if (x) {
        const w = function($) {
          const ne = Array.isArray($) ? $ : [$];
          for (const ie of ne)
            switch (ie) {
              case "http://iiif.io/api/image/2/context.json":
              case "http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level2":
                return "ImageService2";
              case "http://iiif.io/api/image/1/context.json":
              case "http://library.stanford.edu/iiif/image-api/1.1/context.json":
                return "ImageService1";
              case "http://iiif.io/api/annex/openannotation/context.json":
                return "ImageApiSelector";
            }
        }(x);
        if (w)
          return w;
      }
      if (i) {
        if (Array.isArray(i)) {
          if (i.indexOf("oa:CssStylesheet") !== -1)
            return "CssStylesheet";
          if (i.indexOf("cnt:ContentAsText") !== -1)
            return "TextualBody";
          i = i[0];
        }
        for (const w of ["sc", "oa", "dcterms", "dctypes", "iiif"])
          if (i.startsWith(`${w}:`)) {
            i = i.slice(w.length + 1);
            break;
          }
        switch (i) {
          case "Layer":
            return "AnnotationCollection";
          case "AnnotationList":
            return "AnnotationPage";
          case "cnt:ContentAsText":
            return "TextualBody";
        }
      }
      if (i && N.indexOf(i) !== -1)
        return i;
      if (r.format) {
        if (r.format.startsWith("image/"))
          return "Image";
        if (r.format.startsWith("text/") || r.format === "application/pdf")
          return "Text";
        if (r.format.startsWith("application/"))
          return "Dataset";
      }
      return e && (e.endsWith(".jpg") || e.endsWith(".png") || e.endsWith(".jpeg")) ? "Image" : i || "unknown";
    }
    const We = /http(s)?:\/\/(creativecommons.org|rightsstatements.org)[^"'\\<\n]+/gm;
    function qe(r) {
      const e = r.match(We);
      return e ? e[0] : r;
    }
    const Ve = ["http://iiif.io/api/presentation/2/context.json", "http://iiif.io/api/image/2/context.json", "http://iiif.io/api/image/1/context.json", "http://library.stanford.edu/iiif/image-api/1.1/context.json", "http://iiif.io/api/search/1/context.json", "http://iiif.io/api/search/0/context.json", "http://iiif.io/api/auth/1/context.json", "http://iiif.io/api/auth/0/context.json", "http://iiif.io/api/annex/openannotation/context.json"];
    function Ue(r) {
      if (r) {
        const e = Array.isArray(r) ? r : [r], i = [];
        for (const u of e)
          u === "http://iiif.io/api/presentation/2/context.json" && i.push("http://iiif.io/api/presentation/3/context.json"), Ve.indexOf(u) === -1 && i.push(u);
        if (e.length)
          return i.length === 1 ? i[0] : i;
      }
    }
    function B(r) {
      for (const e in r)
        r[e] !== void 0 && r[e] !== null || delete r[e];
      return r;
    }
    let we = 0;
    function Se(r, e) {
      const i = encodeURI(r.id || r["@id"] || "").trim();
      return i && e ? `${i}/${e}` : i || (we++, `http://example.org/${r["@type"]}${e ? `/${e}` : ""}/${we}`);
    }
    function H(r) {
      const e = [...r.behavior || []];
      let i;
      return r.viewingHint && e.push(r.viewingHint), Array.isArray(r.motivation) ? i = r.motivation.map(R) : r.motivation && (i = R(r.motivation)), { "@context": r["@context"] ? Ue(r["@context"]) : void 0, id: (r["@id"] || Se(r)).trim(), type: ue(r), behavior: e.length ? e : void 0, height: r.height ? r.height : void 0, width: r.width ? r.width : void 0, motivation: i, viewingDirection: r.viewingDirection, profile: r.profile, format: r.format ? r.format : void 0, duration: void 0, timeMode: void 0 };
    }
    function W(r) {
      const [e, i] = function(w, $ = "Rights/License", ne = "none") {
        let ie = null;
        const Ce = [], Ze = Array.isArray(w) ? w : [w];
        for (const Ee of Ze) {
          const U = Ee ? qe(Ee) : void 0;
          !U || U.indexOf("creativecommons.org") === -1 && U.indexOf("rightsstatements.org") === -1 ? U && Ce.push({ label: { [ne]: [$] }, value: { [ne]: [U] } }) : ie = U.startsWith("https://") ? `http://${U.slice(8)}` : U;
        }
        return [ie, Ce];
      }(r.license), u = [...r.metadata ? (x = r.metadata, x ? x.map((w) => ({ label: k(w.label), value: k(w.value) })) : []) : [], ...i];
      var x;
      return { rights: e, metadata: u.length ? u : void 0, label: r.label ? k(r.label) : void 0, requiredStatement: r.attribution ? { label: k(ee), value: k(r.attribution) } : void 0, navDate: r.navDate, summary: r.description ? k(r.description) : void 0, thumbnail: r.thumbnail };
    }
    function Ge(r) {
      if (!r.within)
        return;
      const e = Array.isArray(r.within) ? r.within : [r.within], i = [];
      for (const u of e)
        typeof u == "string" ? u && r["@type"] === "sc:Manifest" && i.push({ id: u, type: "Collection" }) : u["@id"] && i.push({ id: u["@id"], type: ue(u) });
      return i.length ? i : void 0;
    }
    function V(r) {
      const e = r.related ? Array.isArray(r.related) ? r.related : [r.related] : [], i = r.contentLayer;
      return { provider: r.logo || e.length ? [{ id: te, type: "Agent", homepage: e.length ? [e[0]] : void 0, logo: r.logo ? Array.isArray(r.logo) ? r.logo : [r.logo] : void 0, label: k(ce) }] : void 0, partOf: Ge(r), rendering: r.rendering, seeAlso: r.seeAlso, start: r.startCanvas, service: r.service ? (u = r.service, Array.isArray(u) ? u : [u]) : void 0, supplementary: i ? [i] : void 0 };
      var u;
    }
    function pe(r) {
      const e = r;
      return B({ ...H(e), ...W(e), ...V(e), ...(i = e, { chars: i.chars, format: i.format ? i.format : void 0, language: i.language }) });
      var i;
    }
    const Ke = new q({ collection: [function(r) {
      return B({ ...H(r), ...W(r), ...V(r), items: r.members });
    }], manifest: [function(r) {
      const e = [], i = [];
      for (const x of r.sequences || [])
        x.canvases.length && e.push(...x.canvases), x.behavior && i.push(...x.behavior);
      const u = H(r);
      return i.length && (u.behavior ? u.behavior.push(...i) : u.behavior = i), B({ ...u, ...W(r), ...V(r), items: e, structures: r.structures });
    }], canvas: [function(r) {
      return B({ ...H(r), ...W(r), ...V(r), annotations: r.otherContent && r.otherContent.length ? r.otherContent : void 0, items: r.images && r.images.length ? [{ id: Se(r, "annotation-page"), type: "AnnotationPage", items: r.images }] : void 0 });
    }], annotationList: [function(r) {
      return B({ ...H(r), ...W(r), ...V(r), items: r.resources && r.resources.length ? r.resources : void 0 });
    }], sequence: [function(r) {
      return r.canvases && r.canvases.length !== 0 ? { canvases: r.canvases, behavior: r.viewingHint ? [r.viewingHint] : [] } : { canvases: [], behavior: [] };
    }], annotation: [function(r) {
      return B({ ...H(r), ...W(r), ...V(r), target: function e(i) {
        if (Array.isArray(i)) {
          if (i.length > 1)
            return { type: "List", items: i.map(e) };
          i = i[0];
        }
        if (typeof i == "string")
          return encodeURI(i).trim();
        if ("@type" in i) {
          let u;
          if (typeof i.full == "string")
            u = i.full;
          else if (i.full["@type"] === "dctypes:Image")
            u = { id: i.full["@id"], type: "Image" };
          else {
            if (i.full["@type"] !== "sc:Canvas")
              throw new Error(`Unsupported source type on annotation: ${i.full["@type"]}`);
            u = { id: i.full["@id"], type: "Canvas" };
          }
          return { type: "SpecificResource", source: u, selector: de(i.selector) };
        }
        return encodeURI(i["@id"]).trim();
      }(r.on), body: Array.isArray(r.resource) ? r.resource.map(pe) : pe(r.resource) });
    }], contentResource: [pe], choice: [function(r) {
      const e = [];
      return r.default && r.default !== "rdf:nil" && e.push(r.default), r.item && r.item !== "rdf:nil" && e.push(...r.item), { ...H(r), ...W(r), items: e };
    }], range: [function(r) {
      return B({ ...H(r), ...W(r), ...V(r), items: r.members });
    }], service: [function(r) {
      const { "@id": e, "@type": i, "@context": u, profile: x, ...w } = r, $ = {};
      return e && ($["@id"] = e), $["@type"] = ue(r), $["@type"] === "unknown" && (u && u.length && ($["@context"] = u), $["@type"] = "Service"), x && ($.profile = re(x)), B({ ...$, ...w });
    }], layer: [function(r) {
      return B({ ...H(r), ...W(r), ...V(r) });
    }] });
    function de(r) {
      if ((Array.isArray(r["@type"]) && r["@type"].includes("oa:SvgSelector") || r["@type"] == "oa:SvgSelector") && ("chars" in r || "value" in r))
        return { type: "SvgSelector", value: "chars" in r ? r.chars : r.value };
      if (r["@type"] === "oa:FragmentSelector")
        return { type: "FragmentSelector", value: r.value };
      if (r["@type"] === "oa:Choice")
        return [de(r.default), ...(Array.isArray(r.item) ? r.item : [r.item]).map(de)];
      if (r["@type"] == "iiif:ImageApiSelector")
        return { type: "ImageApiSelector", region: "region" in r ? r.region : void 0, rotation: "rotation" in r ? r.rotation : void 0 };
      throw new Error(`Unsupported selector type: ${r["@type"]}`);
    }
    const Je = function(r) {
      return r && r["@context"] && (r["@context"] === "http://iiif.io/api/presentation/2/context.json" || r["@context"].indexOf("http://iiif.io/api/presentation/2/context.json") !== -1 || r["@context"] === "http://www.shared-canvas.org/ns/context.json") || r["@context"] === "http://iiif.io/api/image/2/context.json" ? Ke.traverseUnknown(r) : r;
    };
    l.upgrade = Je, Object.defineProperties(l, { __esModule: { value: !0 }, [Symbol.toStringTag]: { value: "Module" } });
  });
})(ye, ye.exports);
var cr = ye.exports;
const br = (t) => /* @__PURE__ */ s.createElement(
  st,
  {
    initialState: {
      ...ae,
      options: { ...t.options }
    }
  },
  /* @__PURE__ */ s.createElement(ur, { ...t })
), ur = ({
  collectionId: t,
  iiifContent: o,
  onItemInteraction: n
}) => {
  const a = lt(), { options: p } = a, [l, f] = K();
  let m = o;
  if (t && (m = t), J(() => {
    m && fetch(m).then((d) => d.json()).then(cr.upgrade).then((d) => f(d)).catch((d) => {
      console.error(
        `The IIIF Collection ${m} failed to load: ${d}`
      );
    });
  }, [m]), (l == null ? void 0 : l.items.length) === 0)
    return console.log(`The IIIF Collection ${m} does not contain items.`), /* @__PURE__ */ s.createElement(s.Fragment, null);
  const c = sr(m);
  return l ? /* @__PURE__ */ s.createElement("div", null, /* @__PURE__ */ s.createElement(et, { FallbackComponent: ht }, /* @__PURE__ */ s.createElement(
    Dt,
    {
      label: l.label,
      summary: l && l.summary ? l.summary : { none: [""] },
      homepage: l.homepage,
      instance: c
    }
  ), /* @__PURE__ */ s.createElement(
    ar,
    {
      items: l.items,
      handleItemInteraction: n,
      instance: c,
      breakpoints: p.breakpoints
    }
  ))) : /* @__PURE__ */ s.createElement(s.Fragment, null);
};
export {
  br as default
};
//# sourceMappingURL=index.mjs.map
