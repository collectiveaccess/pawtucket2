import t, { useReducer as Rt, useState as k, useRef as ye, useEffect as E, useCallback as oe, createContext as Mt, useContext as zt, cloneElement as Pt, Fragment as Ft, useLayoutEffect as Vt } from "react";
import { Vault as he } from "@iiif/vault";
import { v4 as ae } from "uuid";
import * as we from "@radix-ui/react-collapsible";
import ie from "openseadragon";
import { decodeContentState as Ht } from "@iiif/vault-helpers";
import { ErrorBoundary as Ue } from "react-error-boundary";
import { createStitches as Bt, createTheme as Nt } from "@stitches/react";
import * as le from "@radix-ui/react-tabs";
import * as se from "@radix-ui/react-radio-group";
import { parse as Ot } from "node-webvtt";
import * as ee from "@radix-ui/react-form";
import Dt from "sanitize-html";
import D from "hls.js";
import * as K from "@radix-ui/react-popover";
import * as Q from "@radix-ui/react-select";
import { SelectValue as Wt, SelectIcon as _t, SelectPortal as jt, SelectScrollUpButton as Gt, SelectViewport as Ut, SelectGroup as qt, SelectScrollDownButton as Zt, SelectItemText as Xt, SelectItemIndicator as Yt } from "@radix-ui/react-select";
import * as ce from "@radix-ui/react-switch";
const Jt = (e) => {
  const n = e.toString().split(":"), r = Math.ceil(parseInt(n[0])), a = Math.ceil(parseInt(n[1])), o = Qt(Math.ceil(parseInt(n[2])), 2);
  let l = `${r !== 0 && a < 10 ? (a + "").padStart(2, "0") : a}:${o}`;
  return r !== 0 && (l = `${r}:${l}`), l;
}, qe = (e) => {
  const n = new Date(e * 1e3).toISOString().substr(11, 8);
  return Jt(n);
}, Ze = (e, n) => {
  if (typeof e != "object" || e === null)
    return n;
  for (const r in n)
    typeof n[r] == "object" && n[r] !== null && !Array.isArray(n[r]) ? (e[r] || (e[r] = {}), e[r] = Ze(e[r], n[r])) : e[r] = n[r];
  return e;
}, Kt = (e) => e.split("").reduce(function(n, r) {
  return n = (n << 5) - n + r.charCodeAt(0), n & n;
}, 0), Xe = (e, n) => Object.hasOwn(e, n) ? e[n].toString() : void 0, Qt = (e, n) => String(e).padStart(n, "0"), en = {
  behavior: "smooth",
  block: "center"
}, V = {
  annotationOverlays: {
    backgroundColor: "#6666ff",
    borderColor: "#000099",
    borderType: "solid",
    borderWidth: "1px",
    opacity: "0.5",
    renderOverlays: !0,
    zoomLevel: 2
  },
  background: "transparent",
  canvasBackgroundColor: "#6662",
  canvasHeight: "500px",
  contentSearch: {
    searchResultsLimit: 20,
    zoomToFirst: !1,
    overlays: {
      backgroundColor: "#ff6666",
      borderColor: "#990000",
      borderType: "solid",
      borderWidth: "1px",
      opacity: "0.5",
      renderOverlays: !0,
      zoomLevel: 4
    }
  },
  ignoreCaptionLabels: [],
  pages: {
    show: !0,
    toggleLabel: "Pages"
  },
  informationPanel: {
    vtt: {
      autoScroll: {
        enabled: !0,
        settings: en
      }
    },
    open: !0,
    renderAbout: !0,
    renderSupplementing: !0,
    renderToggle: !0,
    renderAnnotation: !0,
    renderContentSearch: !0
  },
  openSeadragon: {},
  requestHeaders: { "Content-Type": "application/json" },
  showDownload: !0,
  showIIIFBadge: !0,
  showTitle: !0,
  withCredentials: !1,
  localeText: {
    contentSearch: {
      tabLabel: "Search Results",
      formPlaceholder: "Enter search words",
      noSearchResults: "No search results",
      loading: "Loading...",
      moreResults: "more results"
    }
  }
};
function Ye(e) {
  let n = {
    ...V.informationPanel.vtt.autoScroll
  };
  return typeof e == "object" && (n = "enabled" in e ? e : { enabled: !0, settings: e }), e === !1 && (n.enabled = !1), tn(n.settings), n;
}
function tn({ behavior: e, block: n }) {
  const r = ["auto", "instant", "smooth"], a = ["center", "end", "nearest", "start"];
  if (!r.includes(e))
    throw TypeError(`'${e}' not in ${r.join(" | ")}`);
  if (!a.includes(n))
    throw TypeError(`'${n}' not in ${a.join(" | ")}`);
}
var We, _e;
const nn = Ye(
  (_e = (We = V == null ? void 0 : V.informationPanel) == null ? void 0 : We.vtt) == null ? void 0 : _e.autoScroll
);
var je, Ge;
const de = {
  activeCanvas: "",
  activeManifest: "",
  OSDImageLoaded: !1,
  collection: {},
  configOptions: V,
  customDisplays: [],
  plugins: [],
  isAutoScrollEnabled: nn.enabled,
  isAutoScrolling: !1,
  isInformationOpen: (je = V == null ? void 0 : V.informationPanel) == null ? void 0 : je.open,
  showPageNavigation: (Ge = V == null ? void 0 : V.pages) == null ? void 0 : Ge.show,
  isLoaded: !1,
  isUserScrolling: void 0,
  vault: new he(),
  contentSearchVault: new he(),
  openSeadragonViewer: null,
  viewerId: ae(),
  informationPanelCounts: {}
}, Je = t.createContext(de), Ke = t.createContext(de);
function rn(e, n) {
  switch (n.type) {
    case "updateActiveCanvas":
      return n.canvasId || (n.canvasId = ""), {
        ...e,
        activeCanvas: n.canvasId
      };
    case "updateActiveManifest":
      return {
        ...e,
        activeManifest: n.manifestId
      };
    case "updateOSDImageLoaded":
      return {
        ...e,
        OSDImageLoaded: n.OSDImageLoaded
      };
    case "updateAutoScrollAnnotationEnabled":
      return {
        ...e,
        isAutoScrollEnabled: n.isAutoScrollEnabled
      };
    case "updateAutoScrolling":
      return {
        ...e,
        isAutoScrolling: n.isAutoScrolling
      };
    case "updateCollection":
      return {
        ...e,
        collection: n.collection
      };
    case "updateConfigOptions":
      return {
        ...e,
        configOptions: Ze(e.configOptions, n.configOptions)
      };
    case "updateInformationOpen":
      return {
        ...e,
        isInformationOpen: n.isInformationOpen
      };
    case "updateShowPageNavigation":
      return {
        ...e,
        showPageNavigation: n.showPageNavigation
      };
    case "updateIsLoaded":
      return {
        ...e,
        isLoaded: n.isLoaded
      };
    case "updateUserScrolling":
      return {
        ...e,
        isUserScrolling: n.isUserScrolling
      };
    case "updateOpenSeadragonViewer":
      return {
        ...e,
        openSeadragonViewer: n.openSeadragonViewer
      };
    case "updateViewerId":
      return {
        ...e,
        viewerId: n.viewerId
      };
    case "updateInformationPanelCount": {
      const r = e.informationPanelCounts ?? {};
      return r[n.panel] = n.count, {
        ...e,
        informationPanelCounts: r
      };
    }
    default:
      throw new Error(`Unhandled action type: ${n.type}`);
  }
}
const on = ({
  initialState: e = de,
  children: n
}) => {
  const [r, a] = Rt(rn, e);
  return /* @__PURE__ */ t.createElement(Je.Provider, { value: r }, /* @__PURE__ */ t.createElement(
    Ke.Provider,
    {
      value: a
    },
    n
  ));
};
function $() {
  const e = t.useContext(Je);
  if (e === void 0)
    throw new Error("useViewerState must be used within a ViewerProvider");
  return e;
}
function z() {
  const e = t.useContext(Ke);
  if (e === void 0)
    throw new Error("useViewerDispatch must be used within a ViewerProvider");
  return e;
}
const an = (e, n) => {
  const r = e.get({
    id: n,
    type: "Canvas"
  });
  return !(r != null && r.annotations) || !r.annotations[0] ? [] : e.get(r.annotations).filter((o) => !o.items || !o.items.length ? !1 : o).map((o) => {
    const i = o.label || { none: ["Annotations"] };
    return { ...o, label: i };
  });
}, Qe = async (e, n, r, a) => {
  if (a == null || a.q == null)
    return { label: { none: [r] } };
  const o = `${n}?q=${a.q.trim()}`;
  let i;
  try {
    i = await e.load(o);
  } catch {
    return console.log("Could not load content search."), {};
  }
  return i.label == null && (i.label = { none: [r] }), i;
}, et = (e, n, r, a) => {
  var l, c;
  const o = {
    canvas: void 0,
    accompanyingCanvas: void 0,
    annotationPage: void 0,
    annotations: []
  }, i = (s) => {
    if (s) {
      if (!s.body || !s.motivation) {
        console.error(
          "Invalid annotation after Hyperion parsing: missing either 'body' or 'motivation'",
          s
        );
        return;
      }
      let d = s.body;
      Array.isArray(d) && (d = d[0]);
      const g = e.get(d.id);
      if (!g)
        return;
      switch (r) {
        case "painting":
          return s.target === n.id && s.motivation && s.motivation[0] === "painting" && a.includes(g.type) && (s.body = g), !!s;
        case "supplementing":
          return;
        default:
          throw new Error("Invalid annotation motivation.");
      }
    }
  };
  if (o.canvas = e.get(n), o.canvas && (o.annotationPage = e.get(o.canvas.items[0]), o.accompanyingCanvas = (l = o.canvas) != null && l.accompanyingCanvas ? e.get((c = o.canvas) == null ? void 0 : c.accompanyingCanvas) : void 0), o.annotationPage) {
    const s = e.get(o.annotationPage.items).map((g) => ({
      body: e.get(g.body[0].id),
      motivation: g.motivation,
      type: "Annotation"
    })), d = [];
    s.forEach((g) => {
      g.body.type === "Choice" ? g.body.items.forEach(
        (m) => d.push({
          ...g,
          id: m.id,
          body: e.get(m.id)
        })
      ) : d.push(g);
    }), o.annotations = d.filter(i);
  }
  return o;
}, X = (e, n = "en") => {
  if (!e)
    return "";
  if (!e[n]) {
    const r = Object.getOwnPropertyNames(e);
    if (r.length > 0)
      return e[r[0]];
  }
  return e[n];
}, re = (e, n) => {
  const r = et(
    e,
    { id: n, type: "Canvas" },
    "painting",
    ["Image", "Sound", "Video"]
  );
  if (r.annotations.length !== 0 && r.annotations && r.annotations)
    return r.annotations.map(
      (a) => a == null ? void 0 : a.body
    );
}, ln = (e, n, r, a) => {
  const o = [];
  if (n.canvas && n.canvas.thumbnail.length > 0) {
    const c = e.get(
      n.canvas.thumbnail[0]
    );
    o.push(c);
  }
  if (n.annotations[0]) {
    if (n.annotations[0].thumbnail && n.annotations[0].thumbnail.length > 0) {
      const s = e.get(
        n.annotations[0].thumbnail[0]
      );
      o.push(s);
    }
    if (!n.annotations[0].body)
      return;
    const c = n.annotations[0].body;
    c.type === "Image" && o.push(c);
  }
  return o.length === 0 ? void 0 : {
    id: o[0].id,
    format: o[0].format,
    type: o[0].type,
    width: r,
    height: a
  };
};
let U = window.OpenSeadragon;
if (!U && (U = ie, !U))
  throw new Error("OpenSeadragon is missing.");
const Te = "http://www.w3.org/2000/svg";
U.Viewer && (U.Viewer.prototype.svgOverlay = function() {
  return this._svgOverlayInfo ? this._svgOverlayInfo : (this._svgOverlayInfo = new xe(this), this._svgOverlayInfo);
});
const xe = function(e) {
  const n = this;
  this._viewer = e, this._containerWidth = 0, this._containerHeight = 0, this._svg = document.createElementNS(Te, "svg"), this._svg.style.position = "absolute", this._svg.style.left = 0, this._svg.style.top = 0, this._svg.style.width = "100%", this._svg.style.height = "100%", this._viewer.canvas.appendChild(this._svg), this._node = document.createElementNS(Te, "g"), this._svg.appendChild(this._node), this._viewer.addHandler("animation", function() {
    n.resize();
  }), this._viewer.addHandler("open", function() {
    n.resize();
  }), this._viewer.addHandler("rotate", function() {
    n.resize();
  }), this._viewer.addHandler("flip", function() {
    n.resize();
  }), this._viewer.addHandler("resize", function() {
    n.resize();
  }), this.resize();
};
xe.prototype = {
  // ----------
  node: function() {
    return this._node;
  },
  // ----------
  resize: function() {
    this._containerWidth !== this._viewer.container.clientWidth && (this._containerWidth = this._viewer.container.clientWidth, this._svg.setAttribute("width", this._containerWidth)), this._containerHeight !== this._viewer.container.clientHeight && (this._containerHeight = this._viewer.container.clientHeight, this._svg.setAttribute("height", this._containerHeight));
    const e = this._viewer.viewport.pixelFromPoint(new U.Point(0, 0), !0), n = this._viewer.viewport.getZoom(!0), r = this._viewer.viewport.getRotation(), a = this._viewer.viewport.getFlip(), o = this._viewer.viewport._containerInnerSize.x;
    let i = o * n;
    const l = i;
    a && (i = -i, e.x = -e.x + o), this._node.setAttribute(
      "transform",
      "translate(" + e.x + "," + e.y + ") scale(" + i + "," + l + ") rotate(" + r + ")"
    );
  },
  // ----------
  onClick: function(e, n) {
    new U.MouseTracker({
      element: e,
      clickHandler: n
    }).setTracking(!0);
  }
};
const sn = (e) => new xe(e), tt = (e) => {
  var r, a;
  let n = {
    id: typeof e == "string" ? e : e.source
  };
  if (typeof e == "string") {
    if (e.includes("#xywh=")) {
      const o = e.split("#xywh=");
      if (o && o[1]) {
        const [i, l, c, s] = o[1].split(",").map((d) => Number(d));
        n = {
          id: o[0],
          rect: {
            x: i,
            y: l,
            w: c,
            h: s
          }
        };
      }
    } else if (e.includes("#t=")) {
      const o = e.split("#t=");
      o && o[1] && (n = {
        id: o[0],
        t: o[1]
      });
    }
  } else
    typeof e == "object" && (((r = e.selector) == null ? void 0 : r.type) === "PointSelector" ? n = {
      id: e.source,
      point: {
        x: e.selector.x,
        y: e.selector.y
      }
    } : ((a = e.selector) == null ? void 0 : a.type) === "SvgSelector" && (n = {
      id: e.source,
      svg: e.selector.value
    }));
  return n;
}, cn = (e) => fetch(`${e.replace(/\/$/, "")}/info.json`).then((n) => n.json()).then((n) => n).catch((n) => {
  console.error(
    `The IIIF tilesource ${e.replace(
      /\/$/,
      ""
    )}/info.json failed to load: ${n}`
  );
}), dn = (e) => {
  let n, r;
  if (Array.isArray(e) && (n = e[0], n)) {
    let a;
    "@id" in n ? a = n["@id"] : a = n.id, r = a;
  }
  return r;
}, Ee = (e) => {
  var a;
  let n, r;
  if (hn(e))
    n = e, r = {};
  else {
    const o = JSON.parse(Ht(e));
    switch (o == null ? void 0 : o.type) {
      case "SpecificResource":
      case "Range":
      case "Annotation":
        n = o == null ? void 0 : o.target.partOf[0].id, r = {
          manifest: n,
          canvas: o == null ? void 0 : o.target.id
        };
        break;
      case "Canvas":
        n = o == null ? void 0 : o.partOf[0].id, r = {
          manifest: n,
          canvas: o == null ? void 0 : o.id
        };
        break;
      case "Manifest":
        n = o == null ? void 0 : o.id, r = {
          collection: (a = o == null ? void 0 : o.partOf[0]) == null ? void 0 : a.id,
          manifest: o == null ? void 0 : o.id
        };
        break;
      case "Collection":
        n = o == null ? void 0 : o.id, r = {
          collection: n
        };
        break;
    }
  }
  return { resourceId: n, active: r };
}, mn = (e) => {
  const { resourceId: n, active: r } = Ee(e);
  return r.collection || r.manifest || n;
}, un = (e, n) => {
  const r = n.items.map((i) => i.id), { active: a } = Ee(e), o = a.canvas;
  return r.includes(o) ? o : r[0];
}, pn = (e, n) => {
  const { active: r } = Ee(e), a = r.manifest, o = n.items.filter((i) => i.type === "Manifest").map((i) => i.id);
  return o.length == 0 ? null : o.includes(a) ? a : o[0];
}, hn = (e) => {
  try {
    new URL(e);
  } catch {
    return !1;
  }
  return !0;
};
var J = /* @__PURE__ */ ((e) => (e.TiledImage = "tiledImage", e.SimpleImage = "simpleImage", e))(J || {});
function nt(e, n, r, a, o) {
  if (!e)
    return;
  const i = 1 / n.width;
  a.forEach((l) => {
    if (!l.target)
      return;
    const c = tt(l.target), { point: s, rect: d, svg: g } = c;
    if (d) {
      const { x: m, y, w: h, h: b } = d;
      fn(
        e,
        m * i,
        y * i,
        h * i,
        b * i,
        r,
        o
      );
    }
    if (s) {
      const { x: m, y } = s, h = `
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
          <circle cx="${m}" cy="${y}" r="20" />
        </svg>
      `;
      Le(e, h, r, i, o);
    }
    g && Le(e, g, r, i, o);
  });
}
function gn(e, n, r) {
  let a, o, i = 40, l = 40;
  n.rect && (a = n.rect.x, o = n.rect.y, i = n.rect.w, l = n.rect.h), n.point && (a = n.point.x, o = n.point.y);
  const c = 1 / e.width;
  return new ie.Rect(
    a * c - i * c / 2 * (r - 1),
    o * c - l * c / 2 * (r - 1),
    i * c * r,
    l * c * r
  );
}
function fn(e, n, r, a, o, i, l) {
  const c = new ie.Rect(n, r, a, o), s = document.createElement("div");
  if (i) {
    const { backgroundColor: d, opacity: g, borderType: m, borderColor: y, borderWidth: h } = i;
    s.style.backgroundColor = d, s.style.opacity = g, s.style.border = `${m} ${h} ${y}`, s.className = l;
  }
  e.addOverlay(s, c);
}
function vn(e) {
  if (!e)
    return null;
  const n = document.createElement("template");
  return n.innerHTML = e.trim(), n.content.children[0];
}
function Le(e, n, r, a, o) {
  const i = vn(n);
  if (i)
    for (const l of i.children)
      rt(e, l, r, a, o);
}
function rt(e, n, r, a, o) {
  var i;
  if (n.nodeName === "#text")
    yn(n);
  else {
    const l = bn(n, r, a), c = sn(e);
    c.node().append(l), (i = c._svg) == null || i.setAttribute("class", o), n.childNodes.forEach((s) => {
      rt(e, s, r, a, o);
    });
  }
}
function bn(e, n, r) {
  let a = !1, o = !1, i = !1, l = !1;
  const c = document.createElementNS(
    "http://www.w3.org/2000/svg",
    e.nodeName
  );
  if (e.attributes.length > 0)
    for (let s = 0; s < e.attributes.length; s++) {
      const d = e.attributes[s];
      switch (d.name) {
        case "fill":
          i = !0;
          break;
        case "stroke":
          a = !0;
          break;
        case "stroke-width":
          o = !0;
          break;
        case "fill-opacity":
          l = !0;
          break;
      }
      c.setAttribute(d.name, d.textContent);
    }
  return a || (c.style.stroke = n == null ? void 0 : n.borderColor), o || (c.style.strokeWidth = n == null ? void 0 : n.borderWidth), i || (c.style.fill = n == null ? void 0 : n.backgroundColor), l || (c.style.fillOpacity = n == null ? void 0 : n.opacity), c.setAttribute("transform", `scale(${r})`), c;
}
function yn(e) {
  e.textContent && (e.textContent.includes(`
`) || console.log(
    "nodeName:",
    e.nodeName,
    ", textContent:",
    e.textContent,
    ", childNodes.length",
    e.childNodes.length
  ));
}
const wn = (e) => {
  const n = Array.isArray(e == null ? void 0 : e.service) && (e == null ? void 0 : e.service.length) > 0, r = n ? dn(e == null ? void 0 : e.service) : e == null ? void 0 : e.id, a = n ? J.TiledImage : J.SimpleImage;
  return {
    uri: r,
    imageType: a
  };
}, xn = (e, n) => {
  const r = n ? J.TiledImage : J.SimpleImage;
  return {
    uri: e,
    imageType: r
  };
};
function ot(e, n) {
  if (!e)
    return;
  n.startsWith(".") || (n = "." + n);
  const r = document.querySelectorAll(n);
  r && r.forEach((a) => e.removeOverlay(a));
}
function ge(e, n, r, a) {
  const o = tt(r), { point: i, rect: l, svg: c } = o;
  if (i || l || c) {
    const s = gn(
      a,
      o,
      n
    );
    e == null || e.viewport.fitBounds(s);
  }
}
function En(e, n, r, a, o) {
  var l;
  if (!(n != null && n.items) || (n == null ? void 0 : n.items.length) === 0)
    return;
  const i = [];
  n.items.forEach((c) => {
    const s = e.get(c.id);
    typeof s.target == "string" && s.target.startsWith(a.id) && i.push(s);
  }), r && ((l = o.contentSearch) != null && l.overlays) && nt(
    r,
    a,
    o.contentSearch.overlays,
    i,
    "content-search-overlay"
  );
}
const me = 209, Sn = {
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
    accent: `hsl(${me} 100% 38.2%)`,
    accentMuted: `hsl(${me} 80% 61.8%)`,
    accentAlt: `hsl(${me} 80% 30%)`,
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
}, Se = {
  xxs: "(max-width: 349px)",
  xs: "(max-width: 575px)",
  sm: "(max-width: 767px)",
  md: "(max-width: 991px)",
  lg: "(max-width: 90rem)",
  xl: "(min-width: calc(90rem + 1px))"
}, { styled: p, css: _a, keyframes: Ce, createTheme: ja } = Bt({
  theme: Sn,
  media: Se
}), Cn = p("div", {
  display: "flex",
  flexDirection: "column",
  alignItems: "center"
}), kn = p("p", {
  fontWeight: "bold",
  fontSize: "x-large"
}), In = p("span", {
  fontSize: "medium"
}), at = ({ error: e }) => {
  const { message: n } = e;
  return /* @__PURE__ */ t.createElement(Cn, { role: "alert" }, /* @__PURE__ */ t.createElement(kn, { "data-testid": "headline" }, "Something went wrong"), n && /* @__PURE__ */ t.createElement(In, null, `Error message: ${n}`, " "));
}, it = p("div", {
  position: "relative",
  zIndex: "0"
}), lt = p("div", {
  display: "flex",
  flexDirection: "row",
  flexGrow: "1",
  overflow: "hidden",
  "@sm": {
    flexDirection: "column"
  }
}), st = p("div", {
  display: "flex",
  flexDirection: "column",
  flexGrow: "1",
  flexShrink: "1",
  width: "61.8%",
  "@sm": {
    width: "100%"
  }
}), ct = p(we.Trigger, {
  display: "none",
  border: "none",
  padding: "0",
  transition: "$all",
  opacity: "1",
  background: "#6663",
  margin: "1rem 0",
  borderRadius: "6px",
  "&[data-information-panel='false']": {
    opacity: "0",
    marginTop: "-59px"
  },
  "@sm": {
    display: "flex",
    "> span": {
      display: "flex",
      flexGrow: "1",
      fontSize: "0.8333em",
      justifyContent: "center",
      padding: "0.5rem",
      fontFamily: "inherit"
    }
  }
}), dt = p(we.Content, {
  width: "100%",
  display: "flex"
}), $n = p("aside", {
  display: "flex",
  flexGrow: "1",
  flexShrink: "0",
  width: "38.2%",
  maxHeight: "100%",
  "@sm": {
    width: "100%"
  }
}), An = p("div", {
  display: "flex",
  flexDirection: "column",
  fontSmooth: "auto",
  webkitFontSmoothing: "antialiased",
  '&[data-absolute-position="true"]': {
    position: "absolute",
    width: "100%",
    height: "100%",
    zIndex: "0"
  },
  "> div": {
    display: "flex",
    flexDirection: "column",
    flexGrow: "1",
    justifyContent: "flex-start",
    height: "100%",
    maxHeight: "100%",
    "@sm": {
      [`& ${lt}`]: {
        flexGrow: "1"
      },
      [`& ${st}`]: {
        flexGrow: "0"
      }
    }
  },
  "@sm": {
    padding: "0"
  },
  "&[data-information-panel-open='true']": {
    "@sm": {
      position: "fixed",
      height: "100%",
      width: "100%",
      top: "0",
      left: "0",
      zIndex: "2500000000",
      [`& ${it}`]: {
        display: "none"
      },
      [`& ${ct}`]: {
        margin: "1rem"
      },
      [`& ${dt}`]: {
        height: "100%"
      }
    }
  }
}), Tn = p(le.Root, {
  display: "flex",
  flexDirection: "column",
  width: "100%",
  height: "100%",
  flexGrow: "1",
  flexShrink: "0",
  position: "relative",
  zIndex: "1",
  maskImage: "linear-gradient(180deg, rgba(0, 0, 0, 1) calc(100% - 2rem), transparent 100%)",
  "@sm": {
    marginTop: "0.5rem",
    boxShadow: "none"
  }
}), Ln = p(le.List, {
  display: "flex",
  flexGrow: "0",
  margin: "0 1.618rem",
  borderBottom: "4px solid #6663",
  "@sm": {
    margin: "0 1rem"
  }
}), te = p(le.Trigger, {
  display: "flex",
  position: "relative",
  padding: "0.5rem 1rem",
  background: "none",
  backgroundColor: "transparent",
  fontFamily: "inherit",
  border: "none",
  opacity: "0.7",
  fontSize: "1rem",
  marginRight: "1rem",
  lineHeight: "1rem",
  whiteSpace: "nowrap",
  cursor: "pointer",
  fontWeight: 400,
  transition: "$all",
  "&::after": {
    width: "0",
    height: "4px",
    content: "",
    position: "absolute",
    bottom: "-4px",
    left: "0",
    transition: "$all"
  },
  "&[data-state='active']": {
    opacity: "1",
    fontWeight: 700,
    "&::after": {
      width: "100%",
      backgroundColor: "$accent"
    }
  }
}), ne = p(le.Content, {
  display: "flex",
  flexGrow: "1",
  flexShrink: "0",
  position: "absolute",
  top: "0",
  left: "0",
  "&[data-state='active']": {
    width: "100%",
    height: "calc(100% - 2rem)",
    padding: "1.618rem 0"
  }
}), Rn = ({
  handleScroll: e,
  children: n,
  className: r
}) => /* @__PURE__ */ t.createElement("div", { className: r, onScroll: e }, n), Mn = p(Rn, {
  position: "relative",
  height: "100%",
  width: "100%",
  overflowY: "scroll"
}), mt = {
  position: "relative",
  cursor: "pointer",
  display: "flex",
  width: "100%",
  justifyContent: "space-between",
  textAlign: "left",
  margin: "0",
  padding: "0.5rem 1.618rem",
  fontFamily: "inherit",
  lineHeight: "1.25em",
  fontSize: "1rem",
  color: "inherit",
  border: "none",
  background: "none"
}, ut = p("button", {
  textAlign: "left",
  "&:hover": {
    color: "$accent"
  }
}), zn = p("div", {
  display: "flex",
  flexDirection: "column",
  width: "100%"
}), Pn = p("div", {
  ...mt
}), Fn = p("div", {
  "&:hover": {
    color: "$accent"
  }
}), Re = ({
  value: e,
  handleClick: n
}) => /* @__PURE__ */ t.createElement(ut, { onClick: n }, e), Vn = ({
  value: e,
  handleClick: n
}) => /* @__PURE__ */ t.createElement(
  Fn,
  {
    dangerouslySetInnerHTML: { __html: e },
    onClick: n
  }
), Hn = () => {
  function e(o) {
    return o.map((i) => {
      const l = i.identifier || ae();
      return { ...i, identifier: l };
    });
  }
  function n(o) {
    var s;
    const i = [], l = [], c = e(o);
    for (const d of c) {
      for (; l.length > 0 && l[l.length - 1].end <= d.start; )
        l.pop();
      l.length > 0 ? (l[l.length - 1].children || (l[l.length - 1].children = []), (s = l[l.length - 1].children) == null || s.push(d), l.push(d)) : (i.push(d), l.push(d));
    }
    return i;
  }
  function r(o, i = []) {
    return i.some(
      (l) => o.start >= l.start && o.end <= l.end
    );
  }
  function a(o = []) {
    return o.sort((i, l) => i.start - l.start);
  }
  return {
    addIdentifiersToParsedCues: e,
    createNestedCues: n,
    isChild: r,
    orderCuesByTime: a
  };
}, Me = Ce({
  from: { transform: "rotate(360deg)" },
  to: { transform: "rotate(0deg)" }
}), Bn = p(se.Root, {
  display: "flex",
  flexDirection: "column",
  width: "100%"
}), pt = p(se.Item, {
  ...mt,
  "@sm": {
    padding: "0.5rem 1rem",
    fontSize: "0.8333rem"
  },
  "&::before": {
    content: "",
    width: "12px",
    height: "12px",
    borderRadius: "12px",
    position: "absolute",
    backgroundColor: "$primaryMuted",
    opacity: "0",
    left: "8px",
    marginTop: "3px",
    boxSizing: "content-box",
    "@sm": {
      content: "unset"
    }
  },
  "&::after": {
    content: "",
    width: "4px",
    height: "6px",
    position: "absolute",
    backgroundColor: "$secondary",
    opacity: "0",
    clipPath: "polygon(100% 50%, 0 100%, 0 0)",
    left: "13px",
    marginTop: "6px",
    boxSizing: "content-box",
    "@sm": {
      content: "unset"
    }
  },
  strong: {
    marginLeft: "1rem"
  },
  "&:hover": {
    color: "$accent",
    "&::before": {
      backgroundColor: "$accent",
      opacity: "1"
    },
    "&::after": {
      content: "",
      width: "4px",
      height: "6px",
      position: "absolute",
      backgroundColor: "$secondary",
      clipPath: "polygon(100% 50%, 0 100%, 0 0)",
      opacity: "1"
    }
  },
  "&[aria-checked='true']": {
    backgroundColor: "#6663",
    "&::before": {
      content: "",
      width: "6px",
      height: "6px",
      position: "absolute",
      backgroundColor: "transparent",
      border: "3px solid $accentMuted",
      borderRadius: "12px",
      left: "8px",
      marginTop: "4px",
      opacity: "1",
      animation: "1s linear infinite",
      animationName: Me,
      boxSizing: "content-box",
      "@sm": {
        content: "unset"
      }
    },
    "&::after": {
      content: "",
      width: "6px",
      height: "6px",
      position: "absolute",
      backgroundColor: "transparent",
      border: "3px solid $accent",
      clipPath: "polygon(100% 0, 100% 100%, 0 0)",
      borderRadius: "12px",
      left: "8px",
      marginTop: "4px",
      opacity: "1",
      animation: "1.5s linear infinite",
      animationName: Me,
      boxSizing: "content-box",
      "@sm": {
        content: "unset"
      }
    }
  }
}), Nn = 750, On = (e) => {
  for (; e && e !== document.body; ) {
    const n = window.getComputedStyle(e).overflowY;
    if (n !== "visible" && n !== "hidden" && e.scrollHeight > e.clientHeight)
      return e;
    e = e.parentNode;
  }
  return null;
}, Dn = ({ label: e, start: n, end: r }) => {
  var h, b;
  const a = z(), {
    configOptions: o,
    isAutoScrollEnabled: i,
    isUserScrolling: l
  } = $(), c = (b = (h = o == null ? void 0 : o.informationPanel) == null ? void 0 : h.vtt) == null ? void 0 : b.autoScroll, [s, d] = k(!1), g = ye(null), m = document.getElementById(
    "clover-iiif-video"
  );
  E(() => (m == null || m.addEventListener("timeupdate", () => {
    const { currentTime: f } = m;
    d(n <= f && f < r);
  }), () => document.removeEventListener("timeupdate", () => {
  })), [r, n, m]), E(() => {
    var u;
    const f = (v) => {
      a({ type: "updateAutoScrolling", isAutoScrolling: !0 }), v(), setTimeout(
        () => a({ type: "updateAutoScrolling", isAutoScrolling: !1 }),
        Nn
      );
    };
    if (i && s && g.current && !l) {
      const v = g.current;
      if (v && v instanceof HTMLElement) {
        const w = On(v);
        if (w && w instanceof HTMLElement) {
          let C;
          switch ((u = c == null ? void 0 : c.settings) == null ? void 0 : u.block) {
            case "center":
              const A = w.getBoundingClientRect();
              C = v.offsetTop + v.offsetHeight - Math.floor((A.bottom - A.top) / 2);
              break;
            case "end":
              C = v.offsetTop + v.offsetHeight - (w.clientHeight - v.clientHeight) + 2;
              break;
            default:
              C = v.offsetTop - 2;
              break;
          }
          f(
            () => {
              var A;
              return w.scrollTo({
                top: C,
                left: 0,
                behavior: (A = c == null ? void 0 : c.settings) == null ? void 0 : A.behavior
              });
            }
          );
        }
      }
    }
  }, [
    c,
    s,
    l,
    i,
    a
  ]);
  const y = () => {
    m && (m.pause(), m.currentTime = n, m.play());
  };
  return /* @__PURE__ */ t.createElement(
    pt,
    {
      ref: g,
      "aria-checked": s,
      "data-testid": "information-panel-cue",
      onClick: y,
      value: e
    },
    e,
    /* @__PURE__ */ t.createElement("strong", null, qe(n))
  );
}, Wn = p("ul", {
  listStyle: "none",
  paddingLeft: "1rem",
  position: "relative",
  "&&:first-child": {
    paddingLeft: "0"
  },
  "& li ul": {
    [`& ${pt}`]: {
      backgroundColor: "unset",
      "&::before": {
        content: "none"
      },
      "&::after": {
        content: "none"
      }
    }
  },
  "&:first-child": {
    margin: "0 0 1.618rem"
  }
}), ht = ({ items: e }) => /* @__PURE__ */ t.createElement(Wn, null, e.map((n) => {
  const { text: r, start: a, end: o, children: i, identifier: l } = n;
  return /* @__PURE__ */ t.createElement("li", { key: l }, /* @__PURE__ */ t.createElement(Dn, { label: r, start: a, end: o }), i && /* @__PURE__ */ t.createElement(ht, { items: i }));
})), _n = ({
  label: e,
  vttUri: n
}) => {
  const [r, a] = t.useState([]), { createNestedCues: o, orderCuesByTime: i } = Hn(), [l, c] = t.useState();
  return E(
    () => {
      n && fetch(n, {
        headers: {
          "Content-Type": "text/plain",
          Accept: "application/json"
        }
      }).then((s) => s.text()).then((s) => {
        const d = Ot(s).cues, g = i(d), m = o(g);
        a(m);
      }).catch((s) => {
        console.error(n, s.toString()), c(s);
      });
    },
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [n]
  ), /* @__PURE__ */ t.createElement(
    Bn,
    {
      "data-testid": "annotation-item-vtt",
      "aria-label": `navigate ${X(e, "en")}`
    },
    l && /* @__PURE__ */ t.createElement("div", { "data-testid": "error-message" }, "Network Error: ", l.toString()),
    /* @__PURE__ */ t.createElement(ht, { items: r })
  );
}, jn = ({
  caption: e,
  handleClick: n,
  imageUri: r
}) => /* @__PURE__ */ t.createElement(ut, { onClick: n }, /* @__PURE__ */ t.createElement("img", { src: r, alt: `A visual annotation for ${e}` }), /* @__PURE__ */ t.createElement("span", null, e)), Gn = ({ annotation: e }) => {
  var h, b;
  const { target: n } = e, r = $(), { openSeadragonViewer: a, vault: o, activeCanvas: i, configOptions: l } = r, c = e.body.map((f) => o.get(f.id)), s = ((h = c.find((f) => f.format)) == null ? void 0 : h.format) || "", d = ((b = c.find((f) => f.value)) == null ? void 0 : b.value) || "", g = o.get({
    id: i,
    type: "Canvas"
  });
  function m() {
    var u;
    if (!n)
      return;
    const f = ((u = l.annotationOverlays) == null ? void 0 : u.zoomLevel) || 1;
    ge(a, f, n, g);
  }
  function y() {
    var f, u;
    switch (s) {
      case "text/plain":
        return /* @__PURE__ */ t.createElement(
          Re,
          {
            value: d,
            handleClick: m
          }
        );
      case "text/html":
        return /* @__PURE__ */ t.createElement(
          Vn,
          {
            value: d,
            handleClick: m
          }
        );
      case "text/vtt":
        return /* @__PURE__ */ t.createElement(
          _n,
          {
            label: c[0].label,
            vttUri: c[0].id || ""
          }
        );
      case ((f = s.match(/^image\//)) == null ? void 0 : f.input):
        const v = ((u = c.find((w) => {
          var C;
          return !((C = w.id) != null && C.includes("vault://"));
        })) == null ? void 0 : u.id) || "";
        return /* @__PURE__ */ t.createElement(
          jn,
          {
            caption: d,
            handleClick: m,
            imageUri: v
          }
        );
      default:
        return /* @__PURE__ */ t.createElement(
          Re,
          {
            value: d,
            handleClick: m
          }
        );
    }
  }
  return /* @__PURE__ */ t.createElement(Pn, null, y());
}, Un = ({ annotationPage: e }) => {
  var o;
  const n = $(), { vault: r } = n;
  if (!e || !e.items || ((o = e.items) == null ? void 0 : o.length) === 0)
    return /* @__PURE__ */ t.createElement(t.Fragment, null);
  const a = e.items.map((i) => r.get(i.id));
  return a ? /* @__PURE__ */ t.createElement(zn, { "data-testid": "annotation-page" }, a == null ? void 0 : a.map((i) => /* @__PURE__ */ t.createElement(Gn, { key: i.id, annotation: i }))) : /* @__PURE__ */ t.createElement(t.Fragment, null);
}, qn = p("button", {
  textAlign: "left",
  "&:hover": {
    color: "$accent"
  }
}), Zn = p("li", {
  margin: "0.25rem 0"
}), Xn = p("ol", {
  listStyleType: "auto",
  marginBottom: "1rem",
  listStylePosition: "inside"
}), Yn = p("div", {
  margin: "0.5rem 1.618rem"
}), Jn = p("div", {
  fontWeight: "bold"
}), Kn = p("div", {
  marginBottom: "1rem"
}), Qn = ({
  value: e,
  handleClick: n,
  target: r,
  canvas: a
}) => /* @__PURE__ */ t.createElement(
  qn,
  {
    onClick: n,
    "data-target": r,
    "data-canvas": a
  },
  e
), er = ({
  annotation: e,
  activeContentSearchTarget: n,
  setActiveContentSearchTarget: r
}) => {
  var C, A, T;
  const a = z(), o = $(), {
    openSeadragonViewer: i,
    vault: l,
    contentSearchVault: c,
    activeCanvas: s,
    configOptions: d,
    OSDImageLoaded: g
  } = o, m = l.get({
    id: s,
    type: "Canvas"
  }), h = ((C = e.body.map((I) => c.get(I.id)).find((I) => I.value)) == null ? void 0 : C.value) || "";
  let b;
  e.target && typeof e.target == "string" && (b = e.target);
  let f;
  if (b) {
    const I = b.split("#xywh");
    I.length > 1 && (f = I[0]);
  }
  const u = ((T = (A = d.contentSearch) == null ? void 0 : A.overlays) == null ? void 0 : T.zoomLevel) || 1;
  E(() => {
    g && i && e.target && e.target == n && ge(i, u, b, m);
  }, [i, g]);
  function v(I) {
    if (!i)
      return;
    const H = JSON.parse(I.target.dataset.target), B = I.target.dataset.canvas;
    s === B ? ge(i, u, b, m) : (a({
      type: "updateOSDImageLoaded",
      OSDImageLoaded: !1
    }), a({
      type: "updateActiveCanvas",
      canvasId: B
    }), r(H));
  }
  const w = JSON.stringify(b);
  return /* @__PURE__ */ t.createElement(Zn, null, /* @__PURE__ */ t.createElement(
    Qn,
    {
      target: w,
      canvas: f,
      value: h,
      handleClick: v
    }
  ));
};
let ze = !1;
const tr = ({ annotationPage: e }) => {
  var y, h, b, f;
  const n = $(), { contentSearchVault: r, configOptions: a } = n, [o, i] = k(), l = (y = a.contentSearch) == null ? void 0 : y.searchResultsLimit, c = !!((h = a.contentSearch) != null && h.zoomToFirst), s = (b = a.localeText) == null ? void 0 : b.contentSearch;
  function d(u) {
    const v = {};
    return u.items.forEach((w) => {
      const C = r.get(
        w.id
      );
      let A = "";
      if (C.label) {
        const T = X(C.label);
        T && (A = T[0]);
      }
      v[A] == null && (v[A] = []), v[A].push(C), !ze && c && typeof C.target == "string" && (i(C.target), ze = !0);
    }), v;
  }
  function g(u) {
    return (l ? u.slice(0, l) : u).map((w, C) => /* @__PURE__ */ t.createElement(
      er,
      {
        key: C,
        annotation: w,
        activeContentSearchTarget: o,
        setActiveContentSearchTarget: i
      }
    ));
  }
  function m(u) {
    if (l) {
      const v = u.length - l;
      if (v > 0)
        return /* @__PURE__ */ t.createElement(Kn, null, v, " ", s == null ? void 0 : s.moreResults);
    }
  }
  return !e || !e.items || ((f = e.items) == null ? void 0 : f.length) === 0 ? /* @__PURE__ */ t.createElement("p", null, s == null ? void 0 : s.noSearchResults) : /* @__PURE__ */ t.createElement(t.Fragment, null, Object.entries(d(e)).map(
    ([u, v], w) => /* @__PURE__ */ t.createElement("div", { key: w }, /* @__PURE__ */ t.createElement(Jn, { className: "content-search-results-title" }, u), /* @__PURE__ */ t.createElement(Xn, { className: "content-search-results" }, g(v)), m(v))
  ));
}, nr = p("div", {
  ".content-search-form": { display: "flex", marginBottom: "1rem" },
  input: {
    padding: ".25rem",
    marginRight: "1rem"
  }
}), rr = p("button", {
  display: "flex",
  background: "none",
  border: "none",
  width: "2rem",
  height: "2rem",
  padding: "0",
  margin: "0",
  fontWeight: "700",
  borderRadius: "2rem",
  backgroundColor: "$accent",
  color: "$secondary",
  cursor: "pointer",
  boxSizing: "content-box",
  transition: "$all",
  svg: {
    height: "60%",
    width: "60%",
    padding: "20%",
    fill: "$secondary",
    stroke: "$secondary",
    opacity: "1",
    filter: "drop-shadow(5px 5px 5px #000D)",
    boxSizing: "inherit",
    transition: "$all"
  },
  "&:disabled": {
    backgroundColor: "transparent",
    boxShadow: "none",
    svg: { opacity: "0.25" }
  }
}), or = ({
  searchServiceUrl: e,
  setContentSearchResource: n,
  setLoading: r
}) => {
  var h;
  const a = $(), { contentSearchVault: o, openSeadragonViewer: i, configOptions: l } = a, c = (h = l.localeText) == null ? void 0 : h.contentSearch, s = l.initialSearch, [d, g] = k(
    s
  );
  async function m(b) {
    b && b.preventDefault();
    const f = c == null ? void 0 : c.tabLabel;
    if (i && e) {
      if (!d || d.trim() === "") {
        n({
          label: { none: [f] }
        });
        return;
      }
      r(!0), Qe(o, e, f, {
        q: d
      }).then((u) => {
        n(u), r(!1);
      });
    }
  }
  const y = (b) => {
    b.preventDefault(), g(b.target.value);
  };
  return E(() => {
    s && (g(s), m(null));
  }, [i]), /* @__PURE__ */ t.createElement(nr, null, /* @__PURE__ */ t.createElement(ee.Root, { onSubmit: m, className: "content-search-form" }, /* @__PURE__ */ t.createElement(
    ee.Field,
    {
      className: "FormField",
      name: "searchTerms",
      onChange: y
    },
    /* @__PURE__ */ t.createElement(ee.Control, { placeholder: c == null ? void 0 : c.formPlaceholder })
  ), /* @__PURE__ */ t.createElement(ee.Submit, { asChild: !0 }, /* @__PURE__ */ t.createElement(rr, { type: "submit" }, /* @__PURE__ */ t.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ t.createElement("title", null, "Search"), /* @__PURE__ */ t.createElement("path", { d: "M456.69 421.39L362.6 327.3a173.81 173.81 0 0034.84-104.58C397.44 126.38 319.06 48 222.72 48S48 126.38 48 222.72s78.38 174.72 174.72 174.72A173.81 173.81 0 00327.3 362.6l94.09 94.09a25 25 0 0035.3-35.3zM97.92 222.72a124.8 124.8 0 11124.8 124.8 124.95 124.95 0 01-124.8-124.8z" }))))));
}, ar = ({
  searchServiceUrl: e,
  setContentSearchResource: n,
  activeCanvas: r,
  annotationPage: a
}) => {
  const [o, i] = k(!1);
  return /* @__PURE__ */ t.createElement(Yn, null, /* @__PURE__ */ t.createElement(
    or,
    {
      searchServiceUrl: e,
      setContentSearchResource: n,
      activeCanvas: r,
      setLoading: i
    }
  ), !o && /* @__PURE__ */ t.createElement(tr, { annotationPage: a }), o && /* @__PURE__ */ t.createElement("span", null, "Loading..."));
}, ir = p("div", {
  padding: " 0 1.618rem 2rem",
  display: "flex",
  flexDirection: "column",
  overflow: "scroll",
  position: "absolute",
  fontWeight: "400",
  fontSize: "1rem",
  zIndex: "0",
  img: {
    maxWidth: "100px",
    maxHeight: "100px",
    objectFit: "contain",
    color: "transparent",
    margin: "0 0 1rem",
    borderRadius: "3px",
    backgroundColor: "$secondaryMuted"
  },
  video: {
    display: "none"
  },
  "a, a:visited": {
    color: "$accent"
  },
  p: {
    fontSize: "1rem",
    lineHeight: "1.45em",
    margin: "0"
  },
  dl: {
    margin: "0",
    dt: {
      fontWeight: "700",
      margin: "1rem 0 0.25rem"
    },
    dd: {
      margin: "0"
    }
  },
  ".manifest-property-title": {
    fontWeight: "700",
    margin: "1rem 0 0.25rem"
  },
  "ul, ol": {
    padding: "0",
    margin: "0",
    li: {
      fontSize: "1rem",
      lineHeight: "1.45em",
      listStyle: "none",
      margin: "0.25rem 0 0.25rem"
    }
  }
}), lr = p("div", {
  position: "relative",
  width: "100%",
  height: "100%",
  zIndex: "0"
}), gt = (e, n = "none") => {
  if (!e)
    return null;
  if (typeof e == "string")
    return [e];
  if (!e[n]) {
    const r = Object.getOwnPropertyNames(e);
    if (r.length > 0)
      return e[r[0]];
  }
  return !e[n] || !Array.isArray(e[n]) ? null : e[n];
}, P = (e, n = "none", r = ", ") => {
  const a = gt(e, n);
  return Array.isArray(a) ? a.join(`${r}`) : a;
};
function sr(e) {
  return { __html: cr(e) };
}
function W(e, n) {
  const r = Object.keys(e).filter(
    (o) => n.includes(o) ? null : o
  ), a = new Object();
  return r.forEach((o) => {
    a[o] = e[o];
  }), a;
}
function cr(e) {
  return Dt(e, {
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
const dr = p("span", {}), G = (e) => {
  const { as: n, label: r } = e, o = W(e, ["as", "label"]);
  return /* @__PURE__ */ t.createElement(dr, { as: n, ...o }, P(r, o.lang));
}, mr = (e, n = "200,", r = "full") => {
  Array.isArray(e) && (e = e[0]);
  const { id: a, service: o } = e;
  let i;
  if (!o)
    return a;
  if (Array.isArray(e.service) && e.service.length > 0 && (i = o[0]), i) {
    if (i["@id"])
      return `${i["@id"]}/${r}/${n}/0/default.jpg`;
    if (i.id)
      return `${i.id}/${r}/${n}/0/default.jpg`;
  }
}, Pe = p("img", { objectFit: "cover" }), ur = (e) => {
  const n = ye(null), { contentResource: r, altAsLabel: a, region: o = "full" } = e;
  let i;
  a && (i = P(a));
  const c = W(e, ["contentResource", "altAsLabel"]), { type: s, id: d, width: g = 200, height: m = 200, duration: y } = r;
  E(() => {
    if (!d && !n.current || ["Image"].includes(s) || !d.includes("m3u8"))
      return;
    const f = new D();
    return n.current && (f.attachMedia(n.current), f.on(D.Events.MEDIA_ATTACHED, function() {
      f.loadSource(d);
    })), f.on(D.Events.ERROR, function(u, v) {
      if (v.fatal)
        switch (v.type) {
          case D.ErrorTypes.NETWORK_ERROR:
            console.error(
              `fatal ${u} network error encountered, try to recover`
            ), f.startLoad();
            break;
          case D.ErrorTypes.MEDIA_ERROR:
            console.error(
              `fatal ${u} media error encountered, try to recover`
            ), f.recoverMediaError();
            break;
          default:
            f.destroy();
            break;
        }
    }), () => {
      f && (f.detachMedia(), f.destroy());
    };
  }, [d, s]);
  const h = oe(() => {
    if (!n.current)
      return;
    let f = 0, u = 30;
    if (y && (u = y), !d.split("#t=") && y && (f = y * 0.1), d.split("#t=").pop()) {
      const w = d.split("#t=").pop();
      w && (f = parseInt(w.split(",")[0]));
    }
    const v = n.current;
    v.autoplay = !0, v.currentTime = f, setTimeout(() => h(), u * 1e3);
  }, [y, d]);
  E(() => h(), [h]);
  const b = mr(
    r,
    `${g},${m}`,
    o
  );
  switch (s) {
    case "Image":
      return /* @__PURE__ */ t.createElement(
        Pe,
        {
          as: "img",
          alt: i,
          css: { width: g, height: m },
          key: d,
          src: b,
          ...c
        }
      );
    case "Video":
      return /* @__PURE__ */ t.createElement(
        Pe,
        {
          as: "video",
          css: { width: g, height: m },
          disablePictureInPicture: !0,
          key: d,
          loop: !0,
          muted: !0,
          onPause: h,
          ref: n,
          src: d
        }
      );
    default:
      return console.warn(
        `Resource type: ${s} is not valid or not yet supported in Primitives.`
      ), /* @__PURE__ */ t.createElement(t.Fragment, null);
  }
}, pr = p("a", {}), hr = (e) => {
  const { children: n, homepage: r } = e, o = W(e, ["children", "homepage"]);
  return /* @__PURE__ */ t.createElement(t.Fragment, null, r && r.map((i) => {
    const l = P(
      i.label,
      o.lang
    );
    return /* @__PURE__ */ t.createElement(
      pr,
      {
        "aria-label": n ? l : void 0,
        href: i.id,
        key: i.id,
        ...o
      },
      n || l
    );
  }));
}, gr = {
  delimiter: ", "
}, ke = Mt(void 0), ft = () => {
  const e = zt(ke);
  if (e === void 0)
    throw new Error(
      "usePrimitivesContext must be used with a PrimitivesProvider"
    );
  return e;
}, Ie = ({
  children: e,
  initialState: n = gr
}) => {
  const r = fr(n, "delimiter");
  return /* @__PURE__ */ t.createElement(ke.Provider, { value: { delimiter: r } }, e);
}, fr = (e, n) => Object.hasOwn(e, n) ? e[n].toString() : void 0, vr = p("span", {}), Fe = (e) => {
  const { as: n, markup: r } = e, { delimiter: a } = ft();
  if (!r)
    return /* @__PURE__ */ t.createElement(t.Fragment, null);
  const i = W(e, ["as", "markup"]), l = sr(
    P(r, i.lang, a)
  );
  return /* @__PURE__ */ t.createElement(vr, { as: n, ...i, dangerouslySetInnerHTML: l });
}, vt = (e) => t.useContext(ke) ? /* @__PURE__ */ t.createElement(Fe, { ...e }) : /* @__PURE__ */ t.createElement(Ie, null, /* @__PURE__ */ t.createElement(Fe, { ...e })), br = ({ as: e = "dd", lang: n, value: r }) => /* @__PURE__ */ t.createElement(vt, { markup: r, as: e, lang: n }), yr = p("span", {}), wr = ({
  as: e = "dd",
  customValueContent: n,
  lang: r,
  value: a
}) => {
  var l;
  const { delimiter: o } = ft(), i = (l = gt(a, r)) == null ? void 0 : l.map((c) => Pt(n, {
    value: c
  }));
  return /* @__PURE__ */ t.createElement(yr, { as: e, lang: r }, i == null ? void 0 : i.map((c, s) => [
    s > 0 && `${o}`,
    /* @__PURE__ */ t.createElement(Ft, { key: s }, c)
  ]));
}, bt = (e) => {
  var c;
  const { item: n, lang: r, customValueContent: a } = e, { label: o, value: i } = n, l = (c = P(o)) == null ? void 0 : c.replace(" ", "-").toLowerCase();
  return /* @__PURE__ */ t.createElement("div", { role: "group", "data-label": l }, /* @__PURE__ */ t.createElement(G, { as: "dt", label: o, lang: r }), a ? /* @__PURE__ */ t.createElement(
    wr,
    {
      as: "dd",
      customValueContent: a,
      value: i,
      lang: r
    }
  ) : /* @__PURE__ */ t.createElement(br, { as: "dd", value: i, lang: r }));
};
function xr(e, n) {
  const r = n.filter((a) => {
    const { matchingLabel: o } = a, i = Object.keys(a.matchingLabel)[0], l = P(o, i);
    if (P(e, i) === l)
      return !0;
  }).map((a) => a.Content);
  if (Array.isArray(r))
    return r[0];
}
const Er = p("dl", {}), Sr = (e) => {
  const { as: n, customValueContent: r, metadata: a } = e;
  if (!Array.isArray(a))
    return /* @__PURE__ */ t.createElement(t.Fragment, null);
  const o = Xe(e, "customValueDelimiter"), l = W(e, [
    "as",
    "customValueContent",
    "customValueDelimiter",
    "metadata"
  ]);
  return /* @__PURE__ */ t.createElement(
    Ie,
    {
      ...typeof o == "string" ? { initialState: { delimiter: o } } : void 0
    },
    a.length > 0 && /* @__PURE__ */ t.createElement(Er, { as: n, ...l }, a.map((c, s) => {
      const d = r ? xr(c.label, r) : void 0;
      return /* @__PURE__ */ t.createElement(
        bt,
        {
          customValueContent: d,
          item: c,
          key: s,
          lang: l == null ? void 0 : l.lang
        }
      );
    }))
  );
};
p("li", {});
p("ul", {});
const Cr = p("li", {}), kr = p("ul", {}), Ir = (e) => {
  const { as: n, rendering: r } = e, o = W(e, ["as", "rendering"]);
  return /* @__PURE__ */ t.createElement(kr, { as: n }, r && r.map((i) => {
    const l = P(
      i.label,
      o.lang
    );
    return /* @__PURE__ */ t.createElement(Cr, { key: i.id }, /* @__PURE__ */ t.createElement("a", { href: i.id, ...o, target: "_blank" }, l || i.id));
  }));
}, $r = p("dl", {}), Ar = (e) => {
  const { as: n, requiredStatement: r } = e;
  if (!r)
    return /* @__PURE__ */ t.createElement(t.Fragment, null);
  const a = Xe(e, "customValueDelimiter"), i = W(e, ["as", "customValueDelimiter", "requiredStatement"]);
  return /* @__PURE__ */ t.createElement(
    Ie,
    {
      ...typeof a == "string" ? { initialState: { delimiter: a } } : void 0
    },
    /* @__PURE__ */ t.createElement($r, { as: n, ...i }, /* @__PURE__ */ t.createElement(bt, { item: r, lang: i.lang }))
  );
}, Tr = p("li", {}), Lr = p("ul", {}), Rr = (e) => {
  const { as: n, seeAlso: r } = e, o = W(e, ["as", "seeAlso"]);
  return /* @__PURE__ */ t.createElement(Lr, { as: n }, r && r.map((i) => {
    const l = P(
      i.label,
      o.lang
    );
    return /* @__PURE__ */ t.createElement(Tr, { key: i.id }, /* @__PURE__ */ t.createElement("a", { href: i.id, ...o }, l || i.id));
  }));
}, Mr = (e) => {
  const { as: n, summary: r } = e, o = W(e, ["as", "customValueDelimiter", "summary"]);
  return /* @__PURE__ */ t.createElement(vt, { as: n, markup: r, ...o });
}, yt = (e) => {
  const { thumbnail: n, region: r } = e, o = W(e, ["thumbnail"]);
  return /* @__PURE__ */ t.createElement(t.Fragment, null, n && n.map((i) => /* @__PURE__ */ t.createElement(
    ur,
    {
      contentResource: i,
      key: i.id,
      region: r,
      ...o
    }
  )));
}, zr = ({
  homepage: e
}) => (e == null ? void 0 : e.length) === 0 ? /* @__PURE__ */ t.createElement(t.Fragment, null) : /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("span", { className: "manifest-property-title" }, "Homepage"), /* @__PURE__ */ t.createElement(hr, { homepage: e })), Pr = ({
  id: e,
  htmlLabel: n,
  parent: r = "manifest"
}) => /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("span", { className: "manifest-property-title" }, n), /* @__PURE__ */ t.createElement("a", { href: e, target: "_blank", id: `iiif-${r}-id` }, e)), Fr = ({
  metadata: e,
  parent: n = "manifest"
}) => e ? /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(Sr, { metadata: e, id: `iiif-${n}-metadata` })) : /* @__PURE__ */ t.createElement(t.Fragment, null), Vr = ({
  rendering: e
}) => (e == null ? void 0 : e.length) === 0 ? /* @__PURE__ */ t.createElement(t.Fragment, null) : /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("span", { className: "manifest-property-title" }, "Alternate formats"), /* @__PURE__ */ t.createElement(Ir, { rendering: e })), Hr = ({
  requiredStatement: e,
  parent: n = "manifest"
}) => e ? /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(
  Ar,
  {
    requiredStatement: e,
    id: `iiif-${n}-required-statement`
  }
)) : /* @__PURE__ */ t.createElement(t.Fragment, null), Br = ({ rights: e }) => e ? /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("span", { className: "manifest-property-title" }, "Rights"), /* @__PURE__ */ t.createElement("a", { href: e, target: "_blank" }, e)) : /* @__PURE__ */ t.createElement(t.Fragment, null), Nr = ({ seeAlso: e }) => (e == null ? void 0 : e.length) === 0 ? /* @__PURE__ */ t.createElement(t.Fragment, null) : /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("span", { className: "manifest-property-title" }, "See Also"), /* @__PURE__ */ t.createElement(Rr, { seeAlso: e })), Or = ({
  summary: e,
  parent: n = "manifest"
}) => e ? /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(Mr, { summary: e, as: "p", id: `iiif-${n}-summary` })) : /* @__PURE__ */ t.createElement(t.Fragment, null), Dr = ({
  label: e,
  thumbnail: n
}) => (n == null ? void 0 : n.length) === 0 ? /* @__PURE__ */ t.createElement(t.Fragment, null) : /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(
  yt,
  {
    altAsLabel: e || { none: ["resource"] },
    thumbnail: n,
    style: { backgroundColor: "#6663", objectFit: "cover" }
  }
)), Wr = () => {
  const e = $(), { activeManifest: n, vault: r } = e, [a, o] = k(), [i, l] = k([]), [c, s] = k([]), [d, g] = k([]), [m, y] = k([]);
  return E(() => {
    var b, f, u, v;
    const h = r.get(n);
    o(h), ((b = h.homepage) == null ? void 0 : b.length) > 0 && l(r.get(h.homepage)), ((f = h.seeAlso) == null ? void 0 : f.length) > 0 && s(r.get(h.seeAlso)), ((u = h.rendering) == null ? void 0 : u.length) > 0 && g(r.get(h.rendering)), ((v = h.thumbnail) == null ? void 0 : v.length) > 0 && y(r.get(h.thumbnail));
  }, [n, r]), a ? /* @__PURE__ */ t.createElement(lr, null, /* @__PURE__ */ t.createElement(ir, null, /* @__PURE__ */ t.createElement(Dr, { thumbnail: m, label: a.label }), /* @__PURE__ */ t.createElement(Or, { summary: a.summary }), /* @__PURE__ */ t.createElement(Fr, { metadata: a.metadata }), /* @__PURE__ */ t.createElement(Hr, { requiredStatement: a.requiredStatement }), /* @__PURE__ */ t.createElement(Br, { rights: a.rights }), /* @__PURE__ */ t.createElement(
    zr,
    {
      homepage: i
    }
  ), /* @__PURE__ */ t.createElement(
    Nr,
    {
      seeAlso: c
    }
  ), /* @__PURE__ */ t.createElement(
    Vr,
    {
      rendering: d
    }
  ), /* @__PURE__ */ t.createElement(Pr, { id: a.id, htmlLabel: "IIIF Manifest" }))) : /* @__PURE__ */ t.createElement(t.Fragment, null);
};
function _r(e) {
  const n = [];
  return e.forEach((r) => {
    var a;
    (a = r.informationPanel) != null && a.component && n.push(r);
  }), { pluginsWithInfoPanel: n };
}
const jr = 1500, Gr = ({
  activeCanvas: e,
  annotationResources: n,
  searchServiceUrl: r,
  setContentSearchResource: a,
  contentSearchResource: o
}) => {
  const i = z(), l = $(), {
    isAutoScrolling: c,
    configOptions: { informationPanel: s },
    configOptions: d,
    isUserScrolling: g,
    vault: m,
    plugins: y,
    activeManifest: h,
    openSeadragonViewer: b,
    informationPanelCounts: f
  } = l, u = m.get({
    id: e,
    type: "Canvas"
  }), [v, w] = k(), C = s == null ? void 0 : s.renderAbout, A = s == null ? void 0 : s.renderAnnotation, T = s == null ? void 0 : s.renderContentSearch, { pluginsWithInfoPanel: I } = _r(y);
  function H(S, M) {
    var N, O;
    const F = (N = S == null ? void 0 : S.informationPanel) == null ? void 0 : N.component;
    return F === void 0 ? /* @__PURE__ */ t.createElement(t.Fragment, null) : /* @__PURE__ */ t.createElement(ne, { key: M, value: S.id }, /* @__PURE__ */ t.createElement(
      F,
      {
        ...(O = S == null ? void 0 : S.informationPanel) == null ? void 0 : O.componentProps,
        activeManifest: h,
        canvas: u,
        viewerConfigOptions: d,
        openSeadragonViewer: b,
        useViewerDispatch: z,
        useViewerState: $
      }
    ));
  }
  E(() => {
    if (!v)
      if (s != null && s.defaultTab) {
        const S = ["manifest-about", "manifest-content-search"];
        u.annotations.length > 0 && u.annotations.forEach(
          (M) => S.push(M.id)
        ), S.includes(s == null ? void 0 : s.defaultTab) ? w(s.defaultTab) : w("manifest-about");
      } else
        C ? w("manifest-about") : T ? w("manifest-content-search") : n && (n == null ? void 0 : n.length) > 0 && w(n[0].id);
  }, [
    s == null ? void 0 : s.defaultTab,
    e,
    v,
    C,
    T,
    n,
    o,
    u == null ? void 0 : u.annotations,
    y
  ]);
  function B() {
    if (!c) {
      clearTimeout(g);
      const S = setTimeout(() => {
        i({
          type: "updateUserScrolling",
          isUserScrolling: void 0
        });
      }, jr);
      i({
        type: "updateUserScrolling",
        isUserScrolling: S
      });
    }
  }
  const _ = (S) => {
    w(S);
  };
  return /* @__PURE__ */ t.createElement(
    Tn,
    {
      "data-testid": "information-panel",
      defaultValue: v,
      onValueChange: _,
      orientation: "horizontal",
      value: v,
      className: "clover-viewer-information-panel"
    },
    /* @__PURE__ */ t.createElement(Ln, { "aria-label": "select chapter", "data-testid": "information-panel-list" }, T && o && /* @__PURE__ */ t.createElement(te, { value: "manifest-content-search" }, /* @__PURE__ */ t.createElement(G, { label: o.label })), A && n && n.map((S, M) => /* @__PURE__ */ t.createElement(te, { key: M, value: S.id }, /* @__PURE__ */ t.createElement(G, { label: S.label }))), I && I.map((S, M) => {
      var x;
      const F = P(
        (x = S.informationPanel) == null ? void 0 : x.label
      ), N = f[S.id] ? " (" + f[S.id] + ")" : "", O = { none: [F + N] };
      return /* @__PURE__ */ t.createElement(te, { key: M, value: S.id }, /* @__PURE__ */ t.createElement(G, { label: O }));
    }), C && /* @__PURE__ */ t.createElement(te, { value: "manifest-about" }, "About")),
    /* @__PURE__ */ t.createElement(Mn, { handleScroll: B }, T && o && /* @__PURE__ */ t.createElement(ne, { value: "manifest-content-search" }, /* @__PURE__ */ t.createElement(
      ar,
      {
        searchServiceUrl: r,
        setContentSearchResource: a,
        activeCanvas: e,
        annotationPage: o
      }
    )), A && n && n.map((S) => /* @__PURE__ */ t.createElement(ne, { key: S.id, value: S.id }, /* @__PURE__ */ t.createElement(Un, { annotationPage: S }))), I && I.map(
      (S, M) => H(S, M)
    ), C && /* @__PURE__ */ t.createElement(ne, { value: "manifest-about" }, /* @__PURE__ */ t.createElement(Wr, null)))
  );
}, wt = p("div", {
  position: "absolute",
  right: "1rem",
  top: "1rem",
  display: "flex",
  justifyContent: "flex-end",
  zIndex: "1"
}), Ur = p("input", {
  flexGrow: "1",
  border: "none",
  backgroundColor: "$secondaryMuted",
  color: "$primary",
  marginRight: "1rem",
  height: "2rem",
  padding: "0 1rem",
  borderRadius: "2rem",
  fontFamily: "inherit",
  fontSize: "1rem",
  lineHeight: "1rem",
  boxShadow: "inset 1px 1px 2px #0003",
  "&::placeholder": {
    color: "$primaryMuted"
  }
}), ue = p("button", {
  display: "flex",
  background: "none",
  border: "none",
  width: "2rem !important",
  height: "2rem !important",
  padding: "0",
  margin: "0",
  fontWeight: "700",
  borderRadius: "2rem",
  backgroundColor: "$accent",
  color: "$secondary",
  cursor: "pointer",
  boxSizing: "content-box !important",
  transition: "$all",
  svg: {
    height: "60%",
    width: "60%",
    padding: "20%",
    fill: "$secondary",
    stroke: "$secondary",
    opacity: "1",
    filter: "drop-shadow(5px 5px 5px #000D)",
    boxSizing: "inherit",
    transition: "$all"
  },
  "&:disabled": {
    backgroundColor: "transparent",
    boxShadow: "none",
    svg: { opacity: "0.25" }
  }
}), qr = p("div", {
  display: "flex",
  marginRight: "0.618rem",
  backgroundColor: "$accentAlt",
  borderRadius: "2rem",
  boxShadow: "5px 5px 5px #0003",
  color: "$secondary",
  alignItems: "center",
  "> span": {
    display: "flex",
    margin: "0 0.5rem",
    fontSize: "0.7222rem"
  }
}), Zr = p("div", {
  display: "flex",
  position: "relative",
  zIndex: "1",
  width: "100%",
  padding: "0",
  transition: "$all",
  variants: {
    isToggle: {
      true: {
        paddingTop: "2.618rem",
        [`& ${wt}`]: {
          width: "calc(100% - 2rem)",
          "@sm": {
            width: "calc(100% - 2rem)"
          }
        }
      }
    }
  }
}), Xr = (e, n) => {
  E(() => {
    function r(a) {
      a.key === e && n();
    }
    return window.addEventListener("keyup", r), () => window.removeEventListener("keyup", r);
  }, []);
}, Yr = () => /* @__PURE__ */ t.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ t.createElement("title", null, "Arrow Back"), /* @__PURE__ */ t.createElement(
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
)), Jr = () => /* @__PURE__ */ t.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ t.createElement("title", null, "Arrow Forward"), /* @__PURE__ */ t.createElement(
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
)), Kr = () => /* @__PURE__ */ t.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ t.createElement("title", null, "Close"), /* @__PURE__ */ t.createElement("path", { d: "M289.94 256l95-95A24 24 0 00351 127l-95 95-95-95a24 24 0 00-34 34l95 95-95 95a24 24 0 1034 34l95-95 95 95a24 24 0 0034-34z" })), Qr = () => /* @__PURE__ */ t.createElement("svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 512 512" }, /* @__PURE__ */ t.createElement("title", null, "Search"), /* @__PURE__ */ t.createElement("path", { d: "M456.69 421.39L362.6 327.3a173.81 173.81 0 0034.84-104.58C397.44 126.38 319.06 48 222.72 48S48 126.38 48 222.72s78.38 174.72 174.72 174.72A173.81 173.81 0 00327.3 362.6l94.09 94.09a25 25 0 0035.3-35.3zM97.92 222.72a124.8 124.8 0 11124.8 124.8 124.95 124.95 0 01-124.8-124.8z" })), eo = ({
  handleCanvasToggle: e,
  handleFilter: n,
  activeIndex: r,
  canvasLength: a
}) => {
  const [o, i] = k(!1), [l, c] = k(!1), [s, d] = k(!1);
  E(() => {
    d(r === 0), r === a - 1 ? c(!0) : c(!1);
  }, [r, a]), Xr("Escape", () => {
    i(!1), n("");
  });
  const g = () => {
    i((y) => !y), n("");
  }, m = (y) => n(y.target.value);
  return /* @__PURE__ */ t.createElement(Zr, { isToggle: o }, /* @__PURE__ */ t.createElement(wt, null, o && /* @__PURE__ */ t.createElement(Ur, { autoFocus: !0, onChange: m, placeholder: "Search" }), !o && /* @__PURE__ */ t.createElement(qr, null, /* @__PURE__ */ t.createElement(
    ue,
    {
      onClick: () => e(-1),
      disabled: s,
      type: "button"
    },
    /* @__PURE__ */ t.createElement(Yr, null)
  ), /* @__PURE__ */ t.createElement("span", null, r + 1, " of ", a), /* @__PURE__ */ t.createElement(
    ue,
    {
      onClick: () => e(1),
      disabled: l,
      type: "button"
    },
    /* @__PURE__ */ t.createElement(Jr, null)
  )), /* @__PURE__ */ t.createElement(ue, { onClick: g, type: "button" }, o ? /* @__PURE__ */ t.createElement(Kr, null) : /* @__PURE__ */ t.createElement(Qr, null))));
}, to = p(se.Root, {
  display: "flex",
  flexDirection: "row",
  flexGrow: "1",
  padding: "1.618rem",
  overflowX: "scroll",
  position: "relative",
  zIndex: "0"
}), no = () => /* @__PURE__ */ t.createElement(
  "path",
  {
    fill: "none",
    stroke: "currentColor",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    strokeWidth: "32",
    d: "M256 112v288M400 256H112"
  }
), ro = () => /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("path", { d: "M232 416a23.88 23.88 0 01-14.2-4.68 8.27 8.27 0 01-.66-.51L125.76 336H56a24 24 0 01-24-24V200a24 24 0 0124-24h69.75l91.37-74.81a8.27 8.27 0 01.66-.51A24 24 0 01256 120v272a24 24 0 01-24 24zm-106.18-80zm-.27-159.86zM320 336a16 16 0 01-14.29-23.19c9.49-18.87 14.3-38 14.3-56.81 0-19.38-4.66-37.94-14.25-56.73a16 16 0 0128.5-14.54C346.19 208.12 352 231.44 352 256c0 23.86-6 47.81-17.7 71.19A16 16 0 01320 336z" }), /* @__PURE__ */ t.createElement("path", { d: "M368 384a16 16 0 01-13.86-24C373.05 327.09 384 299.51 384 256c0-44.17-10.93-71.56-29.82-103.94a16 16 0 0127.64-16.12C402.92 172.11 416 204.81 416 256c0 50.43-13.06 83.29-34.13 120a16 16 0 01-13.87 8z" }), /* @__PURE__ */ t.createElement("path", { d: "M416 432a16 16 0 01-13.39-24.74C429.85 365.47 448 323.76 448 256c0-66.5-18.18-108.62-45.49-151.39a16 16 0 1127-17.22C459.81 134.89 480 181.74 480 256c0 64.75-14.66 113.63-50.6 168.74A16 16 0 01416 432z" })), oo = () => /* @__PURE__ */ t.createElement("path", { d: "M289.94 256l95-95A24 24 0 00351 127l-95 95-95-95a24 24 0 00-34 34l95 95-95 95a24 24 0 1034 34l95-95 95 95a24 24 0 0034-34z" }), ao = () => /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(
  "path",
  {
    d: "M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40",
    fill: "none",
    stroke: "currentColor",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    strokeWidth: "32"
  }
), /* @__PURE__ */ t.createElement(
  "path",
  {
    fill: "none",
    stroke: "currentColor",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    strokeWidth: "32",
    d: "M176 272l80 80 80-80M256 48v288"
  }
)), io = () => /* @__PURE__ */ t.createElement("path", { d: "M416 64H96a64.07 64.07 0 00-64 64v256a64.07 64.07 0 0064 64h320a64.07 64.07 0 0064-64V128a64.07 64.07 0 00-64-64zm-80 64a48 48 0 11-48 48 48.05 48.05 0 0148-48zM96 416a32 32 0 01-32-32v-67.63l94.84-84.3a48.06 48.06 0 0165.8 1.9l64.95 64.81L172.37 416zm352-32a32 32 0 01-32 32H217.63l121.42-121.42a47.72 47.72 0 0161.64-.16L448 333.84z" }), lo = () => /* @__PURE__ */ t.createElement("path", { d: "M464 384.39a32 32 0 01-13-2.77 15.77 15.77 0 01-2.71-1.54l-82.71-58.22A32 32 0 01352 295.7v-79.4a32 32 0 0113.58-26.16l82.71-58.22a15.77 15.77 0 012.71-1.54 32 32 0 0145 29.24v192.76a32 32 0 01-32 32zM268 400H84a68.07 68.07 0 01-68-68V180a68.07 68.07 0 0168-68h184.48A67.6 67.6 0 01336 179.52V332a68.07 68.07 0 01-68 68z" }), xt = p("svg", {
  display: "inline-flex",
  variants: {
    isLarge: {
      true: {
        height: "4rem",
        width: "4rem"
      }
    },
    isMedium: {
      true: {
        height: "2rem",
        width: "2rem"
      }
    },
    isSmall: {
      true: {
        height: "1rem",
        width: "1rem"
      }
    }
  }
}), so = ({ children: e }) => /* @__PURE__ */ t.createElement("title", null, e), R = (e) => /* @__PURE__ */ t.createElement(
  xt,
  {
    ...e,
    "data-testid": "icon-svg",
    role: "img",
    viewBox: "0 0 512 512",
    xmlns: "http://www.w3.org/2000/svg"
  },
  e.children
);
R.Title = so;
R.Add = no;
R.Audio = ro;
R.Close = oo;
R.Download = ao;
R.Image = io;
R.Video = lo;
const co = Ce({
  "0%": { opacity: 0, transform: "translateY(1rem)" },
  "100%": { opacity: 1, transform: "translateY(0)" }
}), mo = Ce({
  "0%": { opacity: 0, transform: "translateY(1rem)" },
  "100%": { opacity: 1, transform: "translateY(0)" }
}), Et = p(K.Arrow, {
  fill: "$secondaryAlt"
}), uo = p(K.Close, {
  position: "absolute",
  right: "0",
  top: "0",
  padding: "0.5rem",
  margin: "0",
  cursor: "pointer",
  border: "none",
  background: "none",
  fill: "inherit",
  "&:hover": {
    opacity: "0.75"
  }
}), po = p(K.Content, {
  border: "none",
  backgroundColor: "white",
  fill: "inhrerit",
  padding: "1rem 2rem 1rem 1rem",
  width: "auto",
  minWidth: "200px",
  maxWidth: "350px",
  borderRadius: "3px",
  boxShadow: "5px 5px 13px #0002",
  /**
   * Animate toggle
   */
  animationDuration: "0.3s",
  animationTimingFunction: "cubic-bezier(0.16, 1, 0.3, 1)",
  '&[data-side="top"]': { animationName: mo },
  '&[data-side="bottom"]': { animationName: co },
  /**
   *
   */
  '&[data-align="end"]': {
    [`& ${Et}`]: {
      margin: "0 0.7rem"
    }
  }
}), ho = p(K.Trigger, {
  display: "inline-flex",
  padding: "0.5rem 0",
  margin: "0 0.5rem 0 0",
  cursor: "pointer",
  border: "none",
  background: "none",
  "> button, > span": {
    margin: "0"
  }
}), go = p(K.Root, {
  boxSizing: "content-box"
}), fo = (e) => /* @__PURE__ */ t.createElement(ho, { ...e }, e.children), vo = (e) => /* @__PURE__ */ t.createElement(po, { ...e }, /* @__PURE__ */ t.createElement(Et, null), /* @__PURE__ */ t.createElement(uo, null, /* @__PURE__ */ t.createElement(R, { isSmall: !0 }, /* @__PURE__ */ t.createElement(R.Close, null))), e.children), q = ({ children: e }) => /* @__PURE__ */ t.createElement(go, null, e);
q.Trigger = fo;
q.Content = vo;
const fe = p("div", {
  // Reset
  boxSizing: "border-box",
  // Custom
  display: "inline-flex",
  alignItems: "center",
  borderRadius: "5px",
  padding: "$1",
  marginBottom: "$2",
  marginRight: "$2",
  backgroundColor: "$lightGrey",
  color: "$richBlack50",
  textTransform: "uppercase",
  fontSize: "$2",
  objectFit: "contain",
  lineHeight: "1em !important",
  "&:last-child": {
    marginRight: "0"
  },
  [`${xt}`]: {
    position: "absolute",
    left: "$1",
    height: "$3",
    width: "$3"
  },
  variants: {
    isIcon: {
      true: { position: "relative", paddingLeft: "$5" }
    }
  }
}), ve = p("span", {
  display: "flex"
}), bo = p("span", {
  display: "flex",
  width: "1.2111rem",
  height: "0.7222rem"
}), yo = p("span", {
  display: "inline-flex",
  marginLeft: "5px",
  marginBottom: "-1px"
}), wo = p(se.Item, {
  display: "flex",
  flexShrink: "0",
  margin: "0 1.618rem 0 0",
  padding: "0",
  cursor: "pointer",
  background: "none",
  border: "none",
  fontFamily: "inherit",
  lineHeight: "1.25em",
  fontSize: "1rem",
  textAlign: "left",
  "&:last-child": {
    marginRight: "1rem"
  },
  figure: {
    margin: "0",
    width: "161.8px",
    "> div": {
      position: "relative",
      display: "flex",
      backgroundColor: "$secondaryAlt",
      width: "inherit",
      height: "100px",
      overflow: "hidden",
      borderRadius: "3px",
      transition: "$all",
      img: {
        width: "100%",
        height: "100%",
        objectFit: "cover",
        filter: "blur(0)",
        transform: "scale3d(1, 1, 1)",
        transition: "$all",
        color: "transparent"
      },
      [`& ${ve}`]: {
        position: "absolute",
        right: "0",
        bottom: "0",
        [`& ${fe}`]: {
          margin: "0",
          paddingLeft: "0",
          fontSize: "0.7222rem",
          backgroundColor: "#000d",
          color: "$secondary",
          fill: "$secondary",
          borderBottomLeftRadius: "0",
          borderTopRightRadius: "0"
        }
      }
    },
    figcaption: {
      marginTop: "0.5rem",
      fontWeight: "400",
      fontSize: "0.8333rem",
      display: "-webkit-box",
      overflow: "hidden",
      MozBoxOrient: "vertical",
      WebkitBoxOrient: "vertical",
      WebkitLineClamp: "5",
      "@sm": {
        fontSize: "0.8333rem"
      }
    }
  },
  "&[aria-checked='true']": {
    figure: {
      "> div": {
        backgroundColor: "$primaryAlt",
        "&::before": {
          position: "absolute",
          zIndex: "1",
          color: "$secondaryMuted",
          content: "Active Item",
          textTransform: "uppercase",
          fontWeight: "700",
          fontSize: "0.6111rem",
          letterSpacing: "0.03rem",
          display: "flex",
          width: "100%",
          height: "100%",
          flexDirection: "column",
          justifyContent: "center",
          textAlign: "center",
          textShadow: "5px 5px 5px #0003"
        },
        img: {
          opacity: "0.3",
          transform: "scale3d(1.1, 1.1, 1.1)",
          filter: "blur(2px)"
        },
        [`& ${ve}`]: {
          [`& ${fe}`]: {
            backgroundColor: "$accent"
          }
        }
      }
    },
    figcaption: {
      fontWeight: "700"
    }
  }
}), xo = ({ type: e }) => {
  switch (e) {
    case "Sound":
      return /* @__PURE__ */ t.createElement(R.Audio, null);
    case "Image":
      return /* @__PURE__ */ t.createElement(R.Image, null);
    case "Video":
      return /* @__PURE__ */ t.createElement(R.Video, null);
    default:
      return /* @__PURE__ */ t.createElement(R.Image, null);
  }
}, Eo = ({
  canvas: e,
  canvasIndex: n,
  isActive: r,
  thumbnail: a,
  type: o,
  handleChange: i
}) => /* @__PURE__ */ t.createElement(
  wo,
  {
    "aria-checked": r,
    "data-testid": "media-thumbnail",
    "data-canvas": n,
    onClick: () => i(e.id),
    value: e.id
  },
  /* @__PURE__ */ t.createElement("figure", null, /* @__PURE__ */ t.createElement("div", null, (a == null ? void 0 : a.id) && /* @__PURE__ */ t.createElement(
    "img",
    {
      src: a.id,
      alt: e != null && e.label ? X(e.label) : ""
    }
  ), /* @__PURE__ */ t.createElement(ve, null, /* @__PURE__ */ t.createElement(fe, { isIcon: !0, "data-testid": "thumbnail-tag" }, /* @__PURE__ */ t.createElement(bo, null), /* @__PURE__ */ t.createElement(R, { "aria-label": o }, /* @__PURE__ */ t.createElement(xo, { type: o })), ["Video", "Sound"].includes(o) && /* @__PURE__ */ t.createElement(yo, null, qe(e.duration))))), (e == null ? void 0 : e.label) && /* @__PURE__ */ t.createElement("figcaption", { "data-testid": "fig-caption" }, /* @__PURE__ */ t.createElement(G, { label: e.label })))
), So = (e) => e.body ? e.body.type : "Image", Co = ({ items: e }) => {
  const n = z(), r = $(), { activeCanvas: a, vault: o } = r, [i, l] = k(""), [c, s] = k([]), [d, g] = k(0), m = t.useRef(null), y = "painting", h = (u) => {
    a !== u && n({
      type: "updateActiveCanvas",
      canvasId: u
    });
  };
  E(() => {
    if (!c.length) {
      const u = ["Image", "Sound", "Video"], v = e.map(
        (w) => et(o, w, y, u)
      ).filter((w) => w.annotations.length > 0);
      s(v);
    }
  }, [e, c.length, o]), E(() => {
    c.forEach((u, v) => {
      u != null && u.canvas && u.canvas.id === a && g(v);
    });
  }, [a, c]), E(() => {
    const u = document.querySelector(
      `[data-canvas="${d}"]`
    );
    if (u instanceof HTMLElement && m.current) {
      const v = u.offsetLeft - m.current.offsetWidth / 2 + u.offsetWidth / 2;
      m.current.scrollTo({ left: v, behavior: "smooth" });
    }
  }, [d]);
  const b = (u) => l(u), f = (u) => {
    const v = c[d + u];
    v != null && v.canvas && h(v.canvas.id);
  };
  return /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(
    eo,
    {
      handleFilter: b,
      handleCanvasToggle: f,
      activeIndex: d,
      canvasLength: c.length
    }
  ), /* @__PURE__ */ t.createElement(to, { "aria-label": "select item", "data-testid": "media", ref: m }, c.filter((u) => {
    var v;
    if ((v = u.canvas) != null && v.label) {
      const w = X(u.canvas.label);
      if (Array.isArray(w))
        return w[0].toLowerCase().includes(i.toLowerCase());
    }
  }).map((u, v) => {
    var w, C;
    return /* @__PURE__ */ t.createElement(
      Eo,
      {
        canvas: u.canvas,
        canvasIndex: v,
        handleChange: h,
        isActive: a === ((w = u == null ? void 0 : u.canvas) == null ? void 0 : w.id),
        key: (C = u == null ? void 0 : u.canvas) == null ? void 0 : C.id,
        thumbnail: ln(o, u, 200, 200),
        type: So(u.annotations[0])
      }
    );
  })));
}, St = p("button", {
  position: "absolute",
  background: "none",
  border: "none",
  cursor: "zoom-in",
  margin: "0",
  padding: "0",
  width: "100%",
  height: "100%",
  transition: "$all",
  "& img": {
    width: "100%",
    height: "100%",
    objectFit: "contain",
    color: "transparent",
    transition: "$all"
  },
  variants: {
    isMedia: {
      true: {
        cursor: "pointer"
      }
    }
  }
}), Ct = p("button", {
  display: "flex",
  height: "2rem",
  width: "2rem",
  borderRadius: "2rem",
  padding: "0",
  margin: "0",
  fontFamily: "inherit",
  background: "none",
  backgroundColor: "$primary",
  border: "none",
  color: "white",
  cursor: "pointer",
  marginLeft: "0.618rem",
  filter: "drop-shadow(2px 2px 5px #0003)",
  transition: "$all",
  boxSizing: "content-box !important",
  "&:first-child": {
    marginLeft: "0"
  },
  "@xs": {
    marginBottom: "0.618rem",
    marginLeft: "0",
    "&:last-child": {
      marginBottom: "0"
    }
  },
  svg: {
    height: "60%",
    width: "60%",
    padding: "20%",
    fill: "$secondary",
    stroke: "$secondary",
    filter: "drop-shadow(2px 2px 5px #0003)",
    transition: "$all",
    boxSizing: "inherit"
  },
  "&:hover, &:focus": {
    backgroundColor: "$accent"
  },
  "&[data-button=rotate-right]": {
    "&:hover, &:focus": {
      svg: {
        rotate: "45deg"
      }
    }
  },
  "&[data-button=rotate-left]": {
    transform: "scaleX(-1)",
    "&:hover, &:focus": {
      svg: {
        rotate: "45deg"
      }
    }
  },
  "&[data-button=reset]": {
    "&:hover, &:focus": {
      svg: {
        rotate: "-15deg"
      }
    }
  }
}), kt = p(Ct, {
  position: "absolute",
  width: "2rem",
  top: "1rem",
  right: "1rem",
  zIndex: 100,
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  textAlign: "center",
  transition: "$all",
  borderRadius: "50%",
  backgroundColor: "$accent",
  cursor: "pointer",
  "&:hover, &:focus": {
    backgroundColor: "$accent !important"
  },
  variants: {
    isInteractive: {
      true: {
        "&:hover": {
          opacity: "1"
        }
      },
      false: {}
    },
    isMedia: {
      true: {
        cursor: "pointer !important"
      }
    }
  },
  compoundVariants: [
    {
      isInteractive: !1,
      isMedia: !0,
      css: {
        top: "50%",
        right: "50%",
        width: "4rem",
        height: "4rem",
        transform: "translate(50%,-50%)"
      }
    }
  ]
}), ko = p("div", {
  position: "relative",
  display: "flex",
  flexDirection: "column",
  flexGrow: "1",
  flexShrink: "1",
  gap: "1rem",
  zIndex: "0",
  overflow: "hidden",
  "&:hover": {
    [`${kt}`]: {
      backgroundColor: "$accent"
    },
    [`${St}`]: {
      backgroundColor: "#6662"
    }
  }
}), Io = p("div", {
  width: "100%",
  height: "100%"
}), $o = p("svg", {
  height: "19px",
  color: "$accent",
  fill: "$accent",
  stroke: "$accent",
  display: "flex",
  margin: "0.25rem 0.85rem"
}), Ao = p(Q.Trigger, {
  fontSize: "1.25rem",
  fontWeight: "400",
  fontFamily: "inherit",
  alignSelf: "flex-start",
  flexGrow: "1",
  cursor: "pointer",
  transition: "$all",
  border: "1px solid #6663",
  boxShadow: "2px 2px 5px #0001",
  borderRadius: "3px",
  display: "flex",
  alignItems: "center",
  paddingLeft: "0.5rem",
  width: "100%",
  "@sm": {
    fontSize: "1rem"
  }
}), To = p(Q.Content, {
  borderRadius: "3px",
  boxShadow: "3px 3px 8px #0003",
  backgroundColor: "$secondary",
  marginTop: "2.25rem",
  marginLeft: "6px",
  paddingBottom: "0.25rem",
  maxHeight: "calc(61.8vh - 2.5rem) !important",
  borderTopLeftRadius: "0",
  border: "1px solid $secondaryMuted",
  maxWidth: "90vw"
}), Lo = p(Q.Item, {
  display: "flex",
  alignItems: "center",
  fontFamily: "inherit",
  padding: "0.25rem 0.5rem",
  color: "$primary",
  fontWeight: "400",
  fontSize: "0.8333rem",
  cursor: "pointer",
  backgroundColor: "$secondary",
  width: "calc(100% - 1rem)",
  "> span": {
    whiteSpace: "nowrap",
    textOverflow: "ellipsis",
    overflow: "hidden"
  },
  '&[data-state="checked"]': {
    fontWeight: "700",
    color: "$primary !important"
  },
  "&:hover": {
    color: "$accent"
  },
  img: {
    width: "31px",
    height: "31px",
    marginRight: "0.5rem",
    borderRadius: "3px"
  }
}), Ro = p(Q.Label, {
  color: "$primaryMuted",
  fontFamily: "inherit",
  fontSize: "0.85rem",
  padding: "0.5rem 1rem 0.5rem 0.5rem",
  display: "flex",
  alignItems: "center",
  marginBottom: "0.25rem",
  borderRadius: "3px",
  borderTopLeftRadius: "0",
  borderBottomLeftRadius: "0",
  borderBottomRightRadius: "0",
  backgroundColor: "$secondaryMuted"
}), It = p(Q.Root, {
  position: "relative",
  zIndex: "5",
  width: "100%"
}), pe = ({ direction: e, title: n }) => {
  const r = () => /* @__PURE__ */ t.createElement("path", { d: "M414 321.94L274.22 158.82a24 24 0 00-36.44 0L98 321.94c-13.34 15.57-2.28 39.62 18.22 39.62h279.6c20.5 0 31.56-24.05 18.18-39.62z" }), a = () => /* @__PURE__ */ t.createElement("path", { d: "M98 190.06l139.78 163.12a24 24 0 0036.44 0L414 190.06c13.34-15.57 2.28-39.62-18.22-39.62h-279.6c-20.5 0-31.56 24.05-18.18 39.62z" });
  return /* @__PURE__ */ t.createElement(
    $o,
    {
      xmlns: "http://www.w3.org/2000/svg",
      focusable: "false",
      viewBox: "0 0 512 512",
      role: "img"
    },
    /* @__PURE__ */ t.createElement("title", null, n),
    e === "up" && /* @__PURE__ */ t.createElement(r, null),
    e === "down" && /* @__PURE__ */ t.createElement(a, null)
  );
}, $t = ({
  children: e,
  label: n,
  maxHeight: r,
  onValueChange: a,
  value: o
}) => /* @__PURE__ */ t.createElement(It, { onValueChange: a, value: o }, /* @__PURE__ */ t.createElement(Ao, { "data-testid": "select-button" }, /* @__PURE__ */ t.createElement(Wt, { "data-testid": "select-button-value" }), /* @__PURE__ */ t.createElement(_t, null, /* @__PURE__ */ t.createElement(pe, { direction: "down", title: "select" }))), /* @__PURE__ */ t.createElement(jt, null, /* @__PURE__ */ t.createElement(
  To,
  {
    css: { maxHeight: `${r} !important` },
    "data-testid": "select-content"
  },
  /* @__PURE__ */ t.createElement(Gt, null, /* @__PURE__ */ t.createElement(pe, { direction: "up", title: "scroll up for more" })),
  /* @__PURE__ */ t.createElement(Ut, null, /* @__PURE__ */ t.createElement(qt, null, n && /* @__PURE__ */ t.createElement(Ro, null, /* @__PURE__ */ t.createElement(G, { "data-testid": "select-label", label: n })), e)),
  /* @__PURE__ */ t.createElement(Zt, null, /* @__PURE__ */ t.createElement(pe, { direction: "down", title: "scroll down for more" }))
))), At = (e) => /* @__PURE__ */ t.createElement(Lo, { ...e }, e.thumbnail && /* @__PURE__ */ t.createElement(yt, { thumbnail: e.thumbnail }), /* @__PURE__ */ t.createElement(Xt, null, /* @__PURE__ */ t.createElement(G, { label: e.label })), /* @__PURE__ */ t.createElement(Yt, null)), be = p("div", {
  position: "absolute !important",
  zIndex: "1",
  top: "1rem",
  left: "1rem",
  width: "161.8px",
  height: "100px",
  backgroundColor: "#000D",
  boxShadow: "5px 5px 5px #0002",
  borderRadius: "3px",
  ".displayregion": {
    border: " 3px solid $accent !important",
    boxShadow: "0 0 3px #0006"
  },
  "@sm": {
    width: "123px",
    height: "76px"
  },
  "@xs": {
    width: "100px",
    height: "61.8px"
  }
}), Mo = p("div", {
  position: "relative",
  width: "100%",
  height: "100%",
  zIndex: "0"
}), zo = p("div", {
  width: "100%",
  height: "100%",
  maxHeight: "100vh",
  background: "transparent",
  backgroundSize: "contain",
  color: "white",
  position: "relative",
  zIndex: "0",
  overflow: "hidden",
  variants: {
    hasNavigator: {
      true: {
        [`${be}`]: {
          display: "block"
        }
      },
      false: {
        [`${be}`]: {
          display: "none"
        }
      }
    }
  }
}), Z = ({ className: e, id: n, label: r, children: a }) => {
  const o = r.toLowerCase().replace(/\s/g, "-");
  return /* @__PURE__ */ t.createElement(
    Ct,
    {
      id: n,
      className: e,
      "data-testid": "openseadragon-button",
      "data-button": o
    },
    /* @__PURE__ */ t.createElement(
      "svg",
      {
        xmlns: "http://www.w3.org/2000/svg",
        "aria-labelledby": `${n}-svg-title`,
        "data-testid": "openseadragon-button-svg",
        focusable: "false",
        viewBox: "0 0 512 512",
        role: "img"
      },
      /* @__PURE__ */ t.createElement("title", { id: `${n}-svg-title` }, r),
      a
    )
  );
}, Po = p("div", {
  position: "absolute",
  zIndex: "1",
  top: "1rem",
  right: "1rem",
  display: "flex",
  "@xs": {
    flexDirection: "column",
    zIndex: "2"
  },
  variants: {
    hasPlaceholder: {
      true: {
        right: "3.618rem",
        "@xs": {
          top: "3.618rem",
          right: "1rem"
        }
      },
      false: {
        right: "1rem",
        "@xs": {
          top: "1rem",
          right: "1rem"
        }
      }
    }
  }
}), Fo = () => /* @__PURE__ */ t.createElement(
  "path",
  {
    strokeLinecap: "round",
    strokeMiterlimit: "10",
    strokeWidth: "45",
    d: "M256 112v288M400 256H112"
  }
), Vo = () => /* @__PURE__ */ t.createElement(
  "path",
  {
    strokeLinecap: "round",
    strokeMiterlimit: "10",
    strokeWidth: "45",
    d: "M400 256H112"
  }
), Ho = () => /* @__PURE__ */ t.createElement(
  "path",
  {
    fill: "none",
    stroke: "currentColor",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    strokeWidth: "32",
    d: "M432 320v112H320M421.8 421.77L304 304M80 192V80h112M90.2 90.23L208 208M320 80h112v112M421.77 90.2L304 208M192 432H80V320M90.23 421.8L208 304"
  }
), Bo = () => /* @__PURE__ */ t.createElement("path", { d: "M448 440a16 16 0 01-12.61-6.15c-22.86-29.27-44.07-51.86-73.32-67C335 352.88 301 345.59 256 344.23V424a16 16 0 01-27 11.57l-176-168a16 16 0 010-23.14l176-168A16 16 0 01256 88v80.36c74.14 3.41 129.38 30.91 164.35 81.87C449.32 292.44 464 350.9 464 424a16 16 0 01-16 16z" }), Ve = () => /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(
  "path",
  {
    fill: "none",
    strokeLinecap: "round",
    strokeMiterlimit: "10",
    strokeWidth: "45",
    d: "M400 148l-21.12-24.57A191.43 191.43 0 00240 64C134 64 48 150 48 256s86 192 192 192a192.09 192.09 0 00181.07-128"
  }
), /* @__PURE__ */ t.createElement("path", { d: "M464 97.42V208a16 16 0 01-16 16H337.42c-14.26 0-21.4-17.23-11.32-27.31L436.69 86.1C446.77 76 464 83.16 464 97.42z" })), No = ({
  _cloverViewerHasPlaceholder: e,
  config: n
}) => {
  const r = $(), {
    activeCanvas: a,
    configOptions: o,
    openSeadragonViewer: i,
    plugins: l,
    vault: c,
    activeManifest: s
  } = r, d = c.get({
    id: a,
    type: "Canvas"
  });
  function g() {
    return l.filter((m) => {
      var y;
      return (y = m.imageViewer) == null ? void 0 : y.menu;
    }).map((m, y) => {
      var b, f, u, v;
      const h = (f = (b = m.imageViewer) == null ? void 0 : b.menu) == null ? void 0 : f.component;
      return /* @__PURE__ */ t.createElement(
        h,
        {
          key: y,
          ...(v = (u = m == null ? void 0 : m.imageViewer) == null ? void 0 : u.menu) == null ? void 0 : v.componentProps,
          activeManifest: s,
          canvas: d,
          viewerConfigOptions: o,
          openSeadragonViewer: i,
          useViewerDispatch: z,
          useViewerState: $
        }
      );
    });
  }
  return /* @__PURE__ */ t.createElement(
    Po,
    {
      "data-testid": "clover-iiif-image-openseadragon-controls",
      hasPlaceholder: e
    },
    n.showZoomControl && /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(Z, { id: n.zoomInButton, label: "zoom in" }, /* @__PURE__ */ t.createElement(Fo, null)), /* @__PURE__ */ t.createElement(Z, { id: n.zoomOutButton, label: "zoom out" }, /* @__PURE__ */ t.createElement(Vo, null))),
    n.showFullPageControl && /* @__PURE__ */ t.createElement(Z, { id: n.fullPageButton, label: "full page" }, /* @__PURE__ */ t.createElement(Ho, null)),
    n.showRotationControl && /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement(Z, { id: n.rotateRightButton, label: "rotate right" }, /* @__PURE__ */ t.createElement(Ve, null)), /* @__PURE__ */ t.createElement(Z, { id: n.rotateLeftButton, label: "rotate left" }, /* @__PURE__ */ t.createElement(Ve, null))),
    n.showHomeControl && /* @__PURE__ */ t.createElement(Z, { id: n.homeButton, label: "reset" }, /* @__PURE__ */ t.createElement(Bo, null)),
    g()
  );
}, Oo = ({
  ariaLabel: e,
  config: n,
  uri: r,
  _cloverViewerHasPlaceholder: a,
  imageType: o,
  openSeadragonCallback: i
}) => {
  const [l, c] = k(), [s, d] = k(), g = z(), m = ye(!1);
  return E(() => (m.current || (m.current = !0, s || d(ie(n))), () => s == null ? void 0 : s.destroy()), []), E(() => {
    s && i && i(s);
  }, [s, i]), E(() => {
    s && r !== l && (s == null || s.forceRedraw(), c(r));
  }, [s, l, r]), E(() => {
    if (l && s)
      switch (o) {
        case "simpleImage":
          s == null || s.addSimpleImage({
            url: l
          });
          break;
        case "tiledImage":
          cn(l).then((y) => {
            try {
              if (!y)
                throw new Error(`No tile source found for ${l}`);
              s == null || s.addTiledImage({
                tileSource: y,
                success: () => {
                  typeof g == "function" && g({
                    type: "updateOSDImageLoaded",
                    OSDImageLoaded: !0
                  });
                }
              });
            } catch (h) {
              console.error(h);
            }
          });
          break;
        default:
          s == null || s.close(), console.warn(
            `Unable to render ${l} in OpenSeadragon as type: "${o}"`
          );
          break;
      }
  }, [o, l]), /* @__PURE__ */ t.createElement(
    zo,
    {
      className: "clover-iiif-image-openseadragon",
      "data-testid": "clover-iiif-image-openseadragon",
      "data-openseadragon-instance": n.id,
      hasNavigator: n.showNavigator
    },
    /* @__PURE__ */ t.createElement(
      No,
      {
        _cloverViewerHasPlaceholder: a,
        config: n
      }
    ),
    n.showNavigator && /* @__PURE__ */ t.createElement(
      be,
      {
        id: n.navigatorId,
        "data-testid": "clover-iiif-image-openseadragon-navigator"
      }
    ),
    /* @__PURE__ */ t.createElement(
      Mo,
      {
        id: n.id,
        "data-testid": "clover-iiif-image-openseadragon-viewport",
        role: "img",
        ...e && { "aria-label": e }
      }
    )
  );
};
function Do(e) {
  return {
    id: `openseadragon-${e}`,
    navigatorId: `openseadragon-navigator-${e}`,
    loadTilesWithAjax: !0,
    fullPageButton: `fullPage-${e}`,
    homeButton: `reset-${e}`,
    rotateLeftButton: `rotateLeft-${e}`,
    rotateRightButton: `rotateRight-${e}`,
    zoomInButton: `zoomIn-${e}`,
    zoomOutButton: `zoomOut-${e}`,
    showNavigator: !0,
    showFullPageControl: !0,
    showHomeControl: !0,
    showRotationControl: !0,
    showZoomControl: !0,
    navigatorBorderColor: "transparent",
    gestureSettingsMouse: {
      clickToZoom: !0,
      dblClickToZoom: !0,
      pinchToZoom: !0,
      scrollToZoom: !1
    }
  };
}
const Wo = ({
  _cloverViewerHasPlaceholder: e = !1,
  body: n,
  instanceId: r,
  isTiledImage: a = !1,
  label: o,
  src: i = "",
  openSeadragonCallback: l,
  openSeadragonConfig: c = {}
}) => {
  const s = r || ae(), d = typeof o == "string" ? o : P(o), g = {
    ...Do(s),
    ...c
  }, { imageType: m, uri: y } = n ? wn(n) : xn(i, a);
  return y ? /* @__PURE__ */ t.createElement(Ue, { FallbackComponent: at }, /* @__PURE__ */ t.createElement(
    Oo,
    {
      _cloverViewerHasPlaceholder: e,
      ariaLabel: d,
      config: g,
      imageType: m,
      key: s,
      uri: y,
      openSeadragonCallback: l
    }
  )) : null;
}, _o = ({
  isMedia: e,
  label: n,
  placeholderCanvas: r,
  setIsInteractive: a
}) => {
  const { vault: o } = $(), i = re(o, r), l = i ? i[0] : void 0, c = n ? X(n) : ["placeholder image"];
  return /* @__PURE__ */ t.createElement(
    St,
    {
      onClick: () => a(!0),
      isMedia: e,
      className: "clover-viewer-placeholder"
    },
    /* @__PURE__ */ t.createElement(
      "img",
      {
        src: (l == null ? void 0 : l.id) || "",
        alt: c.join(),
        height: l == null ? void 0 : l.height,
        width: l == null ? void 0 : l.width
      }
    )
  );
}, jo = p("canvas", {
  position: "absolute",
  width: "100%",
  height: "100%",
  zIndex: "0"
}), Go = t.forwardRef(
  (e, n) => {
    const r = t.useRef(null), a = oe(() => {
      var h, b;
      if ((h = n.current) != null && h.currentTime && ((b = n.current) == null ? void 0 : b.currentTime) > 0)
        return;
      const i = n.current;
      if (!i)
        return;
      const l = new AudioContext(), c = l.createMediaElementSource(i), s = l.createAnalyser(), d = r.current;
      if (!d)
        return;
      d.width = i.offsetWidth, d.height = i.offsetHeight;
      const g = d.getContext("2d");
      c.connect(s), s.connect(l.destination), s.fftSize = 256;
      const m = s.frequencyBinCount, y = new Uint8Array(m);
      setInterval(function() {
        o(
          s,
          g,
          m,
          y,
          d.width,
          d.height
        );
      }, 20);
    }, [n]);
    t.useEffect(() => {
      !n || !n.current || (n.current.onplay = a);
    }, [a, n]);
    function o(i, l, c, s, d, g) {
      const m = d / c * 2.6;
      let y, h = 0;
      i.getByteFrequencyData(s), l.fillStyle = "#000000", l.fillRect(0, 0, d, g);
      for (let b = 0; b < c; b++)
        y = s[b] * 2, l.fillStyle = "rgba(78, 42, 132, 1)", l.fillRect(h, g - y, m, y), h += m + 6;
    }
    return /* @__PURE__ */ t.createElement(jo, { ref: r, role: "presentation" });
  }
), Uo = p("div", {
  position: "relative",
  backgroundColor: "$primaryAlt",
  display: "flex",
  flexGrow: "0",
  flexShrink: "1",
  height: "100%",
  zIndex: "1",
  video: {
    backgroundColor: "transparent",
    objectFit: "contain",
    width: "100%",
    height: "100%",
    position: "relative",
    zIndex: "1"
  }
}), qo = ({ resource: e, ignoreCaptionLabels: n }) => {
  const r = X(e.label, "en");
  return Array.isArray(r) && r.some((o) => n.includes(o)) ? null : /* @__PURE__ */ t.createElement(
    "track",
    {
      key: e.id,
      src: e.id,
      label: Array.isArray(r) ? r[0] : r,
      srcLang: "en",
      "data-testid": "player-track"
    }
  );
}, Zo = [
  // Apple santioned
  "application/vnd.apple.mpegurl",
  "vnd.apple.mpegurl",
  // Apple sanctioned for backwards compatibility
  "audio/mpegurl",
  // Very common
  "audio/x-mpegurl",
  // Very common
  "application/x-mpegurl",
  // Included for completeness
  "video/x-mpegurl",
  "video/mpegurl",
  "application/mpegurl"
], Xo = ({
  allSources: e,
  annotationResources: n,
  painting: r
}) => {
  const [a, o] = t.useState(0), [i, l] = t.useState(), c = t.useRef(null), s = (r == null ? void 0 : r.type) === "Sound", d = $(), { activeCanvas: g, configOptions: m, vault: y } = d;
  return E(() => {
    if (!r.id || !c.current)
      return;
    if (c != null && c.current) {
      const f = c.current;
      f.src = r.id, f.load();
    }
    if (r.id.split(".").pop() !== "m3u8" && r.format && !Zo.includes(r.format))
      return;
    const h = {
      // eslint-disable-next-line @typescript-eslint/no-unused-vars
      xhrSetup: function(f, u) {
        f.withCredentials = !!m.withCredentials;
      }
    }, b = new D(h);
    return b.attachMedia(c.current), b.on(D.Events.MEDIA_ATTACHED, function() {
      b.loadSource(r.id);
    }), b.on(D.Events.ERROR, function(f, u) {
      if (u.fatal)
        switch (u.type) {
          case D.ErrorTypes.NETWORK_ERROR:
            console.error(
              `fatal ${f} network error encountered, try to recover`
            ), b.startLoad();
            break;
          case D.ErrorTypes.MEDIA_ERROR:
            console.error(
              `fatal ${f} media error encountered, try to recover`
            ), b.recoverMediaError();
            break;
          default:
            b.destroy();
            break;
        }
    }), () => {
      if (b && c.current) {
        const f = c.current;
        b.detachMedia(), b.destroy(), f.currentTime = 0;
      }
    };
  }, [m.withCredentials, r.id]), E(() => {
    var v, w, C, A;
    const h = y.get(g), b = (v = h.accompanyingCanvas) != null && v.id ? re(y, (w = h.accompanyingCanvas) == null ? void 0 : w.id) : null, f = (C = h.placeholderCanvas) != null && C.id ? re(y, (A = h.placeholderCanvas) == null ? void 0 : A.id) : null;
    !!(b && f) ? l(a === 0 ? f[0].id : b[0].id) : (b && l(b[0].id), f && l(f[0].id));
  }, [g, a, y]), E(() => {
    if (c != null && c.current) {
      const h = c.current;
      return h == null || h.addEventListener(
        "timeupdate",
        () => o(h.currentTime)
      ), () => document.removeEventListener("timeupdate", () => {
      });
    }
  }, []), /* @__PURE__ */ t.createElement(
    Uo,
    {
      css: {
        backgroundColor: m.canvasBackgroundColor,
        maxHeight: m.canvasHeight,
        position: "relative"
      },
      "data-testid": "player-wrapper",
      className: "clover-viewer-player-wrapper"
    },
    /* @__PURE__ */ t.createElement(
      "video",
      {
        id: "clover-iiif-video",
        key: r.id,
        ref: c,
        controls: !0,
        height: r.height,
        width: r.width,
        crossOrigin: "anonymous",
        poster: i,
        style: {
          maxHeight: m.canvasHeight,
          position: "relative",
          zIndex: "1"
        }
      },
      e.map((h) => /* @__PURE__ */ t.createElement("source", { src: h.id, type: h.format, key: h.id })),
      (n == null ? void 0 : n.length) > 0 && n.map((h) => {
        const b = [];
        return h.items.forEach((f) => {
          y.get(
            f.id
          ).body.forEach((v) => {
            const w = y.get(
              v.id
            );
            b.push(w);
          });
        }), b.map((f) => /* @__PURE__ */ t.createElement(
          qo,
          {
            resource: f,
            ignoreCaptionLabels: m.ignoreCaptionLabels || [],
            key: f.id
          }
        ));
      }),
      "Sorry, your browser doesn't support embedded videos."
    ),
    s && /* @__PURE__ */ t.createElement(Go, { ref: c })
  );
}, Yo = () => /* @__PURE__ */ t.createElement(
  "svg",
  {
    xmlns: "http://www.w3.org/2000/svg",
    "aria-labelledby": "close-svg-title",
    focusable: "false",
    viewBox: "0 0 512 512",
    role: "img"
  },
  /* @__PURE__ */ t.createElement("title", { id: "close-svg-title" }, "close"),
  /* @__PURE__ */ t.createElement("path", { d: "M289.94 256l95-95A24 24 0 00351 127l-95 95-95-95a24 24 0 00-34 34l95 95-95 95a24 24 0 1034 34l95-95 95 95a24 24 0 0034-34z" })
), Jo = ({ isMedia: e }) => /* @__PURE__ */ t.createElement(
  "svg",
  {
    xmlns: "http://www.w3.org/2000/svg",
    "aria-labelledby": "open-svg-title",
    focusable: "false",
    viewBox: "0 0 512 512",
    role: "img"
  },
  /* @__PURE__ */ t.createElement("title", { id: "open-svg-title" }, "open"),
  e ? /* @__PURE__ */ t.createElement("path", { d: "M133 440a35.37 35.37 0 01-17.5-4.67c-12-6.8-19.46-20-19.46-34.33V111c0-14.37 7.46-27.53 19.46-34.33a35.13 35.13 0 0135.77.45l247.85 148.36a36 36 0 010 61l-247.89 148.4A35.5 35.5 0 01133 440z" }) : /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("path", { d: "m456.69,421.39l-94.09-94.09c22.65-30.16,34.88-66.86,34.84-104.58,0-96.34-78.38-174.72-174.72-174.72S48,126.38,48,222.72s78.38,174.72,174.72,174.72c37.72.04,74.42-12.19,104.58-34.84l94.09,94.09c10.29,9.2,26.1,8.32,35.3-1.98,8.48-9.49,8.48-23.83,0-33.32Zm-233.97-73.87c-68.89-.08-124.72-55.91-124.8-124.8h0c0-68.93,55.87-124.8,124.8-124.8s124.8,55.87,124.8,124.8-55.87,124.8-124.8,124.8Z" }), /* @__PURE__ */ t.createElement("path", { d: "m279.5,197.76h-3.35s-28.47,0-28.47,0v-31.82c-.77-13.79-12.57-24.33-26.36-23.56-12.71.71-22.85,10.86-23.56,23.56v3.35h0v28.47h-31.82c-13.79.77-24.33,12.57-23.56,26.36.71,12.71,10.86,22.85,23.56,23.56h3.35s28.47,0,28.47,0v31.82c.77,13.79,12.57,24.33,26.36,23.56,12.71-.71,22.85-10.86,23.56-23.56v-3.35h0v-28.47h31.82c13.79-.77,24.33-12.57,23.56-26.36-.71-12.71-10.86-22.85-23.56-23.56Z" }))
), Ko = ({
  handleToggle: e,
  isInteractive: n,
  isMedia: r
}) => /* @__PURE__ */ t.createElement(
  kt,
  {
    onClick: e,
    isInteractive: n,
    isMedia: r,
    "data-testid": "placeholder-toggle"
  },
  n ? /* @__PURE__ */ t.createElement(Yo, null) : /* @__PURE__ */ t.createElement(Jo, { isMedia: r })
), Qo = ({
  activeCanvas: e,
  annotationResources: n,
  isMedia: r,
  painting: a
}) => {
  var S, M, F, N, O;
  const [o, i] = t.useState(0), [l, c] = t.useState(!1), {
    configOptions: s,
    customDisplays: d,
    openSeadragonViewer: g,
    vault: m,
    viewerId: y
  } = $(), h = z(), b = m.get(e), f = (S = b == null ? void 0 : b.placeholderCanvas) == null ? void 0 : S.id, u = !!f, v = (a == null ? void 0 : a.length) > 1, w = f && !l && !r, C = `${y}-${Kt(e + o)}`, A = () => c(!l), T = (x) => {
    const L = a.findIndex((j) => j.id === x);
    i(L);
  }, I = d.find((x) => {
    var $e;
    let L = !1;
    const { canvasId: j, paintingFormat: Y } = x.target;
    if (Array.isArray(j) && j.length > 0 && (L = j.includes(e)), Array.isArray(Y) && Y.length > 0) {
      const Ae = (($e = a[o]) == null ? void 0 : $e.format) || "";
      L = !!(Ae && Y.includes(Ae));
    }
    return L;
  }), H = [];
  (F = (M = n[0]) == null ? void 0 : M.items) == null || F.forEach((x) => {
    const L = m.get(x.id);
    H.push(L);
  }), E(() => {
    var x;
    H && g && ((x = s.annotationOverlays) != null && x.renderOverlays) && (ot(g, "annotation-overlay"), nt(
      g,
      b,
      s.annotationOverlays,
      H,
      "annotation-overlay"
    ));
  }, [b, H, g, s]);
  const B = (x) => {
    x && (g == null ? void 0 : g.id) !== `openseadragon-${C}` && h({
      type: "updateOpenSeadragonViewer",
      openSeadragonViewer: x
    });
  }, _ = (N = I == null ? void 0 : I.display) == null ? void 0 : N.component;
  return /* @__PURE__ */ t.createElement(ko, { className: "clover-viewer-painting" }, /* @__PURE__ */ t.createElement(
    Io,
    {
      style: {
        backgroundColor: s.canvasBackgroundColor,
        height: "100%"
      }
    },
    f && !r && /* @__PURE__ */ t.createElement(
      Ko,
      {
        handleToggle: A,
        isInteractive: l,
        isMedia: r
      }
    ),
    w && !r && /* @__PURE__ */ t.createElement(
      _o,
      {
        isMedia: r,
        label: b == null ? void 0 : b.label,
        placeholderCanvas: f,
        setIsInteractive: c
      }
    ),
    !w && !I && (r ? /* @__PURE__ */ t.createElement(
      Xo,
      {
        allSources: a,
        painting: a[o],
        annotationResources: n
      }
    ) : a && /* @__PURE__ */ t.createElement(
      Wo,
      {
        _cloverViewerHasPlaceholder: u,
        body: a[o],
        instanceId: C,
        key: C,
        openSeadragonCallback: B,
        openSeadragonConfig: s.openSeadragon
      }
    )),
    !w && _ && /* @__PURE__ */ t.createElement(
      _,
      {
        id: e,
        annotationBody: a[o],
        ...I == null ? void 0 : I.display.componentProps
      }
    )
  ), v && /* @__PURE__ */ t.createElement(
    $t,
    {
      value: (O = a[o]) == null ? void 0 : O.id,
      onValueChange: T,
      maxHeight: "200px"
    },
    a == null ? void 0 : a.map((x) => /* @__PURE__ */ t.createElement(
      At,
      {
        value: x == null ? void 0 : x.id,
        key: x == null ? void 0 : x.id,
        label: x == null ? void 0 : x.label
      }
    ))
  ));
}, ea = ({
  activeCanvas: e,
  annotationResources: n,
  searchServiceUrl: r,
  setContentSearchResource: a,
  contentSearchResource: o,
  isAudioVideo: i,
  items: l,
  painting: c
}) => {
  const { isInformationOpen: s, showPageNavigation: d, configOptions: g } = $(), { informationPanel: m } = g, y = (m == null ? void 0 : m.renderAbout) && s, h = (m == null ? void 0 : m.renderAnnotation) && n.length > 0 && !m.open || o;
  return /* @__PURE__ */ t.createElement(
    lt,
    {
      className: "clover-viewer-content",
      style: { height: g.canvasHeight ?? "100%" },
      "data-testid": "clover-viewer-content"
    },
    /* @__PURE__ */ t.createElement(st, null, /* @__PURE__ */ t.createElement(
      Qo,
      {
        activeCanvas: e,
        annotationResources: n,
        isMedia: i,
        painting: c
      }
    ), y && /* @__PURE__ */ t.createElement(ct, null, /* @__PURE__ */ t.createElement("span", null, s ? "View Items" : "More Information")), l.length > 1 && d && /* @__PURE__ */ t.createElement(it, { className: "clover-viewer-media-wrapper" }, /* @__PURE__ */ t.createElement(Co, { items: l, activeItem: 0 }))),
    (y || h) && s && /* @__PURE__ */ t.createElement($n, null, /* @__PURE__ */ t.createElement(dt, null, /* @__PURE__ */ t.createElement(
      Gr,
      {
        activeCanvas: e,
        annotationResources: n,
        searchServiceUrl: r,
        setContentSearchResource: a,
        contentSearchResource: o
      }
    )))
  );
}, ta = p(q.Trigger, {
  width: "30px",
  padding: "5px"
}), Tt = p(q.Content, {
  display: "flex",
  flexDirection: "column",
  fontSize: "0.8333rem",
  border: "none",
  boxShadow: "2px 2px 5px #0003",
  zIndex: "2",
  button: {
    display: "flex",
    textDecoration: "none",
    marginBottom: "0.5em",
    color: "$accentAlt",
    cursor: "pointer",
    background: "$secondary",
    border: "none",
    "&:last-child": {
      marginBottom: "0"
    }
  }
}), na = p("span", {
  fontSize: "1.33rem",
  alignSelf: "flex-start",
  flexGrow: "0",
  flexShrink: "1",
  padding: "1rem",
  "@sm": {
    fontSize: "1rem"
  },
  "&.visually-hidden": {
    position: "absolute",
    width: "1px",
    height: "1px",
    padding: "0",
    margin: "-1px",
    overflow: "hidden",
    clip: "rect(0, 0, 0, 0)",
    whiteSpace: "nowrap",
    border: "0"
  }
}), ra = p("header", {
  display: "flex",
  backgroundColor: "transparent !important",
  justifyContent: "space-between",
  alignItems: "flex-start",
  width: "100%",
  [`> ${It}`]: {
    flexGrow: "1",
    flexShrink: "0"
  },
  form: {
    flexGrow: "0",
    flexShrink: "1"
  }
}), oa = p("div", {
  display: "flex",
  alignItems: "flex-end",
  justifyContent: "flex-end",
  padding: "1rem",
  flexShrink: "0",
  flexGrow: "1"
}), aa = () => {
  var s;
  const e = z(), n = $(), { activeManifest: r, collection: a, configOptions: o, vault: i } = n, l = o == null ? void 0 : o.canvasHeight, c = (d) => {
    e({
      type: "updateActiveManifest",
      manifestId: d
    }), e({
      type: "updateViewerId",
      viewerId: ae()
    });
  };
  return /* @__PURE__ */ t.createElement("div", { style: { margin: "0.75rem" } }, /* @__PURE__ */ t.createElement(
    $t,
    {
      label: a.label,
      maxHeight: l,
      value: r,
      onValueChange: c
    },
    (s = a == null ? void 0 : a.items) == null ? void 0 : s.map((d) => /* @__PURE__ */ t.createElement(
      At,
      {
        value: d.id,
        key: d.id,
        thumbnail: d != null && d.thumbnail ? i.get(d == null ? void 0 : d.thumbnail) : void 0,
        label: d.label
      }
    ))
  ));
}, ia = (e, n = 2500) => {
  const [r, a] = k(), o = oe(() => {
    navigator.clipboard.writeText(e).then(
      () => a("copied"),
      () => a("failed")
    );
  }, [e]);
  return E(() => {
    if (!r)
      return;
    const i = setTimeout(() => a(void 0), n);
    return () => clearTimeout(i);
  }, [r]), [r, o];
}, la = p("span", {
  display: "flex",
  alignContent: "center",
  alignItems: "center",
  padding: "0.125rem 0.25rem 0",
  marginTop: "-0.125rem",
  marginLeft: "0.5rem",
  backgroundColor: "$accent",
  color: "$secondary",
  borderRadius: "3px",
  fontSize: "0.6111rem",
  textTransform: "uppercase",
  lineHeight: "1em"
}), sa = ({ status: e }) => e ? /* @__PURE__ */ t.createElement(la, { "data-copy-status": e }, e) : null, He = ({
  textPrompt: e,
  textToCopy: n
}) => {
  const [r, a] = ia(n);
  return /* @__PURE__ */ t.createElement("button", { onClick: a }, e, " ", /* @__PURE__ */ t.createElement(sa, { status: r }));
}, ca = () => {
  const e = "#ed1d33", n = "#2873ab";
  return /* @__PURE__ */ t.createElement("svg", { viewBox: "0 0 493.35999 441.33334", id: "iiif-logo", version: "1.1" }, /* @__PURE__ */ t.createElement("title", null, "IIIF Manifest Options"), /* @__PURE__ */ t.createElement("g", { transform: "matrix(1.3333333,0,0,-1.3333333,0,441.33333)" }, /* @__PURE__ */ t.createElement("g", { transform: "scale(0.1)" }, /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: n },
      d: "M 65.2422,2178.75 775.242,1915 773.992,15 65.2422,276.25 v 1902.5"
    }
  ), /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: n },
      d: "m 804.145,2640.09 c 81.441,-240.91 -26.473,-436.2 -241.04,-436.2 -214.558,0 -454.511,195.29 -535.9527,436.2 -81.4335,240.89 26.4805,436.18 241.0387,436.18 214.567,0 454.512,-195.29 535.954,-436.18"
    }
  ), /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: e },
      d: "M 1678.58,2178.75 968.578,1915 969.828,15 1678.58,276.25 v 1902.5"
    }
  ), /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: e },
      d: "m 935.082,2640.09 c -81.437,-240.91 26.477,-436.2 241.038,-436.2 214.56,0 454.51,195.29 535.96,436.2 81.43,240.89 -26.48,436.18 -241.04,436.18 -214.57,0 -454.52,-195.29 -535.958,-436.18"
    }
  ), /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: n },
      d: "m 1860.24,2178.75 710,-263.75 -1.25,-1900 -708.75,261.25 v 1902.5"
    }
  ), /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: n },
      d: "m 2603.74,2640.09 c 81.45,-240.91 -26.47,-436.2 -241.03,-436.2 -214.58,0 -454.52,195.29 -535.96,436.2 -81.44,240.89 26.48,436.18 241.03,436.18 214.57,0 454.51,-195.29 535.96,-436.18"
    }
  ), /* @__PURE__ */ t.createElement(
    "path",
    {
      style: { fill: e },
      d: "m 3700.24,3310 v -652.5 c 0,0 -230,90 -257.5,-142.5 -2.5,-247.5 0,-336.25 0,-336.25 l 257.5,83.75 V 1690 l -258.61,-92.5 V 262.5 L 2735.24,0 v 2360 c 0,0 -15,850 965,950"
    }
  ))));
}, da = p(ce.Root, {
  all: "unset",
  height: "2rem",
  width: "3.236rem",
  backgroundColor: "#6663",
  borderRadius: "9999px",
  position: "relative",
  WebkitTapHighlightColor: "transparent",
  cursor: "pointer",
  "&:focus": {
    boxShadow: "0 0 0 2px $secondaryAlt"
  },
  '&[data-state="checked"]': {
    backgroundColor: "$accent",
    boxShadow: "inset 2px 2px 5px #0003"
  }
}), ma = p(ce.Thumb, {
  display: "block",
  height: "calc(2rem - 12px)",
  width: "calc(2rem - 12px)",
  backgroundColor: "$secondary",
  borderRadius: "100%",
  boxShadow: "2px 2px 5px #0001",
  transition: "$all",
  transform: "translateX(6px)",
  willChange: "transform",
  '&[data-state="checked"]': {
    transform: "translateX(calc(1.236rem + 6px))"
  }
}), ua = p("label", {
  fontSize: "0.8333rem",
  fontWeight: "400",
  lineHeight: "1em",
  userSelect: "none",
  cursor: "pointer",
  paddingRight: "0.618rem"
}), pa = p("form", {
  display: "flex",
  flexShrink: "0",
  flexGrow: "1",
  alignItems: "center",
  marginLeft: "1.618rem"
}), ha = () => {
  var i, l;
  const { configOptions: e } = $(), n = z(), [r, a] = k((i = e == null ? void 0 : e.informationPanel) == null ? void 0 : i.open), o = ((l = e == null ? void 0 : e.informationPanel) == null ? void 0 : l.toggleLabel) ?? "More information";
  return E(() => {
    n({
      type: "updateInformationOpen",
      isInformationOpen: r
    });
  }, [r, n]), /* @__PURE__ */ t.createElement(pa, null, /* @__PURE__ */ t.createElement(ua, { htmlFor: "information-toggle", css: r ? { opacity: "1" } : {} }, o), /* @__PURE__ */ t.createElement(
    da,
    {
      checked: r,
      onCheckedChange: () => a(!r),
      id: "information-toggle",
      "aria-label": "information panel toggle",
      name: "toggled?"
    },
    /* @__PURE__ */ t.createElement(ma, null)
  ));
}, ga = p(ce.Root, {
  all: "unset",
  height: "2rem",
  width: "3.236rem",
  backgroundColor: "#6663",
  borderRadius: "9999px",
  position: "relative",
  WebkitTapHighlightColor: "transparent",
  cursor: "pointer",
  "&:focus": {
    boxShadow: "0 0 0 2px $secondaryAlt"
  },
  '&[data-state="checked"]': {
    backgroundColor: "$accent",
    boxShadow: "inset 2px 2px 5px #0003"
  }
}), fa = p(ce.Thumb, {
  display: "block",
  height: "calc(2rem - 12px)",
  width: "calc(2rem - 12px)",
  backgroundColor: "$secondary",
  borderRadius: "100%",
  boxShadow: "2px 2px 5px #0001",
  transition: "$all",
  transform: "translateX(6px)",
  willChange: "transform",
  '&[data-state="checked"]': {
    transform: "translateX(calc(1.236rem + 6px))"
  }
}), va = p("label", {
  fontSize: "0.8333rem",
  fontWeight: "400",
  lineHeight: "1em",
  userSelect: "none",
  cursor: "pointer",
  paddingRight: "0.618rem"
}), ba = p("form", {
  display: "flex",
  flexShrink: "0",
  flexGrow: "1",
  alignItems: "center",
  marginLeft: "1.618rem"
}), ya = () => {
  var i, l;
  const { configOptions: e } = $(), n = z(), [r, a] = k((i = e == null ? void 0 : e.pages) == null ? void 0 : i.show), o = ((l = e == null ? void 0 : e.pages) == null ? void 0 : l.toggleLabel) ?? "Show pages";
  return E(() => {
    n({
      type: "updateShowPageNavigation",
      showPageNavigation: r
    });
  }, [r, n]), /* @__PURE__ */ t.createElement(ba, null, /* @__PURE__ */ t.createElement(va, { htmlFor: "show-pages-toggle", css: r ? { opacity: "1" } : {} }, o), /* @__PURE__ */ t.createElement(
    ga,
    {
      checked: r,
      onCheckedChange: () => a(!r),
      id: "show-pages-toggle",
      "aria-label": "show pages toggle",
      name: "toggled?"
    },
    /* @__PURE__ */ t.createElement(fa, null)
  ));
}, wa = p(q.Trigger, {
  width: "30px",
  padding: "5px"
}), xa = p(Tt, {
  h3: {
    color: "$primaryAlt",
    fontSize: "$2",
    fontWeight: "700",
    margin: "$2 0"
  },
  button: {},
  "& ul li": {
    marginBottom: "$1"
  }
});
function Ea(e) {
  const { vault: n } = $();
  try {
    const r = e && n.get(e);
    if (!r)
      throw new Error(`Vault entity ${e} not found.`);
    return (r == null ? void 0 : r["@id"]) || (r == null ? void 0 : r.id);
  } catch (r) {
    return console.error(r), e;
  }
}
function Be(e, n) {
  const r = [];
  if (!e)
    return r;
  for (const a of e)
    if (a.id) {
      const o = n.get(a.id);
      o && r.push(o);
    }
  return r;
}
function Sa() {
  const { activeCanvas: e, activeManifest: n, vault: r } = $(), [a, o] = k({
    root: [],
    canvas: []
  });
  return E(() => {
    const i = r.get(n), l = r.get(e), c = i == null ? void 0 : i.rendering, s = l == null ? void 0 : l.rendering, d = Be(c, r), g = Be(s, r);
    o({
      root: d,
      canvas: g
    });
  }, [e, n, r]), { ...a };
}
function Ne(e, n) {
  return e.map(({ format: r, id: a, label: o }) => {
    const i = Ea(a);
    return {
      format: r,
      id: i,
      label: P(o) || n
    };
  });
}
function Ca() {
  const e = Sa(), n = Ne(
    (e == null ? void 0 : e.root) || [],
    "Root Rendering Label"
  ), r = Ne(
    (e == null ? void 0 : e.canvas) || [],
    "Canvas Rendering Label"
  );
  return {
    allPages: n,
    individualPages: r
  };
}
const ka = () => {
  const { allPages: e, individualPages: n } = Ca(), r = e.length > 0 || n.length > 0, a = (o) => {
    window.open(o, "_blank");
  };
  return r ? /* @__PURE__ */ t.createElement(q, null, /* @__PURE__ */ t.createElement(wa, { "data-testid": "download-button" }, /* @__PURE__ */ t.createElement(R, null, /* @__PURE__ */ t.createElement(R.Download, null))), /* @__PURE__ */ t.createElement(xa, { "data-testid": "download-content" }, n.length > 0 && /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("h3", null, "Individual Pages"), /* @__PURE__ */ t.createElement("ul", null, n.map(({ format: o, id: i, label: l }) => /* @__PURE__ */ t.createElement("li", { key: l }, /* @__PURE__ */ t.createElement("button", { onClick: () => a(i) }, l, " (", o, ")"))))), e.length > 0 && /* @__PURE__ */ t.createElement(t.Fragment, null, /* @__PURE__ */ t.createElement("h3", null, "All Pages"), /* @__PURE__ */ t.createElement("ul", null, e.map(({ format: o, id: i, label: l }) => /* @__PURE__ */ t.createElement("li", { key: l }, /* @__PURE__ */ t.createElement("button", { onClick: () => a(i) }, l, " (", o, ")"))))))) : null;
}, Lt = (e) => {
  const n = () => window.matchMedia ? window.matchMedia(e).matches : !1, [r, a] = k(n);
  return E(() => {
    const o = () => a(n);
    return window.addEventListener("resize", o), () => window.removeEventListener("resize", o);
  }), r;
}, Ia = ({
  manifest: e,
  manifestId: n,
  manifestLabel: r
}) => {
  const a = $(), { collection: o, configOptions: i } = a, l = z(), [c, s] = k(0);
  E(() => {
    s(0);
  }, []);
  const {
    informationPanel: d,
    showDownload: g,
    showIIIFBadge: m,
    showTitle: y,
    headerNavigation: h
  } = i, b = g || m || (d == null ? void 0 : d.renderToggle), f = Lt(Se.sm);
  return /* @__PURE__ */ t.createElement(ra, { className: "clover-viewer-header" }, o != null && o.items ? /* @__PURE__ */ t.createElement(aa, null) : /* @__PURE__ */ t.createElement(na, { className: y ? "" : "visually-hidden" }, y && /* @__PURE__ */ t.createElement(G, { label: r, className: "label" }), h && /* @__PURE__ */ t.createElement(
    "span",
    {
      className: "headerNavigation",
      dangerouslySetInnerHTML: { __html: h }
    }
  ), /* @__PURE__ */ t.createElement(
    "button",
    {
      onClick: (u) => {
        if (u.preventDefault(), !e.items[c - 1])
          return;
        const v = e.items[c - 1].id;
        s(c - 1), l({
          type: "updateActiveCanvas",
          canvasId: v
        });
      }
    },
    "Previous page"
  ), /* @__PURE__ */ t.createElement(
    "button",
    {
      onClick: (u) => {
        if (u.preventDefault(), !e.items[c + 1])
          return;
        const v = e.items[c + 1].id;
        s(c + 1), l({
          type: "updateActiveCanvas",
          canvasId: v
        });
      }
    },
    "Next page"
  )), b && /* @__PURE__ */ t.createElement(oa, null, g && /* @__PURE__ */ t.createElement(ka, null), m && /* @__PURE__ */ t.createElement(q, null, /* @__PURE__ */ t.createElement(ta, null, /* @__PURE__ */ t.createElement(ca, null)), /* @__PURE__ */ t.createElement(Tt, null, (o == null ? void 0 : o.items) && /* @__PURE__ */ t.createElement(
    "button",
    {
      onClick: (u) => {
        u.preventDefault(), window.open(o.id, "_blank");
      }
    },
    "View Collection"
  ), /* @__PURE__ */ t.createElement(
    "button",
    {
      onClick: (u) => {
        u.preventDefault(), window.open(n, "_blank");
      }
    },
    "View Manifest"
  ), " ", (o == null ? void 0 : o.items) && /* @__PURE__ */ t.createElement(
    He,
    {
      textPrompt: "Copy Collection URL",
      textToCopy: o.id
    }
  ), /* @__PURE__ */ t.createElement(
    He,
    {
      textPrompt: "Copy Manifest URL",
      textToCopy: n
    }
  ))), (d == null ? void 0 : d.renderToggle) && !f && /* @__PURE__ */ t.createElement(ha, null), /* @__PURE__ */ t.createElement(ya, null)));
}, $a = (e = !1) => {
  const [n, r] = k(e);
  return Vt(() => {
    if (!n)
      return;
    const a = document.documentElement.style.overflow;
    return document.documentElement.style.overflow = "hidden", () => {
      document.documentElement.style.overflow = a;
    };
  }, [n]), E(() => {
    n !== e && r(e);
  }, [e]), [n, r];
}, Aa = ({
  manifest: e,
  theme: n,
  iiifContentSearchQuery: r
}) => {
  var O;
  const a = $(), o = z(), {
    activeCanvas: i,
    isInformationOpen: l,
    vault: c,
    contentSearchVault: s,
    configOptions: d,
    openSeadragonViewer: g
  } = a, m = ["100%", "auto"], y = (d == null ? void 0 : d.canvasHeight) && m.includes(d == null ? void 0 : d.canvasHeight), [h, b] = k(!1), [f, u] = k(!1), [v, w] = k([]), [C, A] = k([]), [T, I] = k(), [H, B] = $a(!1), _ = Lt(Se.sm), [S, M] = k(), F = oe(
    (x) => {
      o({
        type: "updateInformationOpen",
        isInformationOpen: x
      });
    },
    [o]
  );
  E(() => {
    var x;
    (x = d == null ? void 0 : d.informationPanel) != null && x.open && F(!_);
  }, [
    _,
    (O = d == null ? void 0 : d.informationPanel) == null ? void 0 : O.open,
    F
  ]), E(() => {
    if (!_) {
      B(!1);
      return;
    }
    B(l);
  }, [l, _, B]), E(() => {
    const x = re(c, i);
    x && (u(
      ["Sound", "Video"].indexOf(x[0].type) > -1
    ), w(x));
    const L = an(c, i);
    L.length > 0 && o({
      type: "updateInformationOpen",
      isInformationOpen: !0
    }), A(L), b(L.length !== 0);
  }, [i, c, o]);
  const N = e.service.some(
    (x) => x.type === "SearchService2"
  );
  return E(() => {
    if (N) {
      const x = e.service.find(
        (L) => L.type === "SearchService2"
      );
      x && M(x.id);
    }
  }, [e, N]), E(() => {
    var x, L, j;
    S && ((x = d.informationPanel) == null ? void 0 : x.renderContentSearch) !== !1 && Qe(
      s,
      S,
      (j = (L = d.localeText) == null ? void 0 : L.contentSearch) == null ? void 0 : j.tabLabel,
      r
    ).then((Y) => {
      I(Y);
    });
  }, [S]), E(() => {
    if (!g || !T)
      return;
    const x = c.get({
      id: i,
      type: "Canvas"
    });
    ot(g, "content-search-overlay"), En(
      s,
      T,
      g,
      x,
      d
    );
  }, [g, T]), /* @__PURE__ */ t.createElement(Ue, { FallbackComponent: at }, /* @__PURE__ */ t.createElement(
    An,
    {
      className: `${n} clover-viewer`,
      css: { background: d == null ? void 0 : d.background },
      "data-body-locked": H,
      "data-absolute-position": y,
      "data-information-panel": h,
      "data-information-panel-open": l
    },
    /* @__PURE__ */ t.createElement(
      we.Root,
      {
        open: l,
        onOpenChange: F
      },
      /* @__PURE__ */ t.createElement(
        Ia,
        {
          manifest: e,
          manifestLabel: e.label,
          manifestId: e.id
        }
      ),
      /* @__PURE__ */ t.createElement(
        ea,
        {
          activeCanvas: i,
          painting: v,
          annotationResources: C,
          searchServiceUrl: S,
          setContentSearchResource: I,
          contentSearchResource: T,
          items: e.items,
          isAudioVideo: f
        }
      )
    )
  ));
}, Oe = {
  ignoreCache: !1,
  headers: {
    Accept: "application/json, text/javascript, text/plain"
  },
  timeout: 5e3,
  withCredentials: !1
};
function Ta(e) {
  return {
    ok: e.status >= 200 && e.status < 300,
    status: e.status,
    statusText: e.statusText,
    headers: e.getAllResponseHeaders(),
    data: e.responseText,
    json: () => JSON.parse(e.responseText)
  };
}
function De(e, n = null) {
  return {
    ok: !1,
    status: e.status,
    statusText: e.statusText,
    headers: e.getAllResponseHeaders(),
    data: n || e.statusText,
    json: () => JSON.parse(n || e.statusText)
  };
}
function La(e, n = Oe) {
  const r = n.headers || Oe.headers;
  return new Promise((a, o) => {
    const i = new XMLHttpRequest();
    i.open("get", e), i.withCredentials = n.withCredentials, r && Object.keys(r).forEach(
      (l) => i.setRequestHeader(l, r[l])
    ), i.onload = () => {
      a(Ta(i));
    }, i.onerror = () => {
      o(De(i, "Failed to make request."));
    }, i.ontimeout = () => {
      o(De(i, "Request took longer than expected."));
    }, i.send();
  });
}
const Ga = ({
  canvasIdCallback: e = () => {
  },
  customDisplays: n = [],
  plugins: r = [],
  customTheme: a,
  iiifContent: o,
  id: i,
  manifestId: l,
  options: c,
  iiifContentSearchQuery: s
}) => {
  var m, y, h;
  let d = o;
  i && (d = i), l && (d = l);
  const g = Ye(
    (y = (m = c == null ? void 0 : c.informationPanel) == null ? void 0 : m.vtt) == null ? void 0 : y.autoScroll
  );
  return /* @__PURE__ */ t.createElement(
    on,
    {
      initialState: {
        ...de,
        customDisplays: n,
        plugins: r,
        isAutoScrollEnabled: g.enabled,
        isInformationOpen: !!((h = c == null ? void 0 : c.informationPanel) != null && h.open),
        showPageNavigation: !0,
        vault: new he({
          customFetcher: (b) => La(b, {
            withCredentials: c == null ? void 0 : c.withCredentials,
            headers: c == null ? void 0 : c.requestHeaders
          }).then((f) => JSON.parse(f.data))
        })
      }
    },
    /* @__PURE__ */ t.createElement(
      Ra,
      {
        iiifContent: d,
        canvasIdCallback: e,
        customTheme: a,
        options: c,
        iiifContentSearchQuery: s
      }
    )
  );
}, Ra = ({
  canvasIdCallback: e,
  customTheme: n,
  iiifContent: r,
  options: a,
  iiifContentSearchQuery: o
}) => {
  const i = z(), l = $(), { activeCanvas: c, activeManifest: s, isLoaded: d, vault: g } = l, [m, y] = k(), [h, b] = k();
  let f = {};
  if (n && (f = Nt("custom", n)), E(() => {
    e && e(c);
  }, [c, e]), E(() => {
    s && g.loadManifest(s).then((v) => {
      b(v), i({
        type: "updateActiveCanvas",
        canvasId: un(r, v)
      });
    }).catch((v) => {
      console.error(`Manifest failed to load: ${v}`);
    }).finally(() => {
      i({
        type: "updateIsLoaded",
        isLoaded: !0
      });
    });
  }, [r, s, i, g]), E(() => {
    i({
      type: "updateConfigOptions",
      configOptions: a
    });
    const v = mn(r);
    g.load(v).then((w) => {
      y(w);
    }).catch((w) => {
      console.error(
        `The IIIF resource ${r} failed to load: ${w}`
      );
    });
  }, [i, r, a, g]), E(() => {
    if ((m == null ? void 0 : m.type) === "Collection") {
      i({
        type: "updateCollection",
        collection: m
      });
      const v = pn(
        r,
        m
      );
      v && i({
        type: "updateActiveManifest",
        manifestId: v
      });
    } else
      (m == null ? void 0 : m.type) === "Manifest" && i({
        type: "updateActiveManifest",
        manifestId: m.id
      });
  }, [i, r, m]), !d)
    return /* @__PURE__ */ t.createElement(t.Fragment, null, "Loading");
  if (!h || !h.items)
    return console.log(`The IIIF manifest ${r} failed to load.`), /* @__PURE__ */ t.createElement(t.Fragment, null);
  if (h.items.length === 0)
    return console.log(`The IIIF manifest ${r} does not contain canvases.`), /* @__PURE__ */ t.createElement(t.Fragment, null);
  const u = (a == null ? void 0 : a.initialPage) ?? 0;
  return u > 0 && (h != null && h.items) && h.items[u - 1] && c !== h.items[u - 1].id && (i({
    type: "updateActiveCanvas",
    canvasId: h.items[u - 1].id
  }), a && (a.initialPage = void 0)), /* @__PURE__ */ t.createElement(
    Aa,
    {
      manifest: h,
      theme: f,
      key: h.id,
      iiifContentSearchQuery: o
    }
  );
};
export {
  Ga as default
};
//# sourceMappingURL=index.mjs.map
