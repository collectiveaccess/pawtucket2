import a, { useRef as D, useEffect as M, useCallback as z, createContext as _, useContext as q, cloneElement as W, Fragment as N } from "react";
import G from "sanitize-html";
import { createStitches as K } from "@stitches/react";
import E from "hls.js";
const V = (e, t = "none") => {
  if (!e)
    return null;
  if (typeof e == "string")
    return [e];
  if (!e[t]) {
    const n = Object.getOwnPropertyNames(e);
    if (n.length > 0)
      return e[n[0]];
  }
  return !e[t] || !Array.isArray(e[t]) ? null : e[t];
}, f = (e, t = "none", n = ", ") => {
  const o = V(e, t);
  return Array.isArray(o) ? o.join(`${n}`) : o;
};
function U(e) {
  return { __html: B(e) };
}
function p(e, t) {
  const n = Object.keys(e).filter(
    (s) => t.includes(s) ? null : s
  ), o = new Object();
  return n.forEach((s) => {
    o[s] = e[s];
  }), o;
}
function B(e) {
  return G(e, {
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
const A = 209, J = {
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
    accent: `hsl(${A} 100% 38.2%)`,
    accentMuted: `hsl(${A} 80% 61.8%)`,
    accentAlt: `hsl(${A} 80% 30%)`,
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
}, Q = {
  xxs: "(max-width: 349px)",
  xs: "(max-width: 575px)",
  sm: "(max-width: 767px)",
  md: "(max-width: 991px)",
  lg: "(max-width: 90rem)",
  xl: "(min-width: calc(90rem + 1px))"
}, { styled: m, css: we, keyframes: Pe, createTheme: Ce } = K({
  theme: J,
  media: Q
}), X = m("span", {}), L = (e) => {
  const { as: t, label: n } = e, s = p(e, ["as", "label"]);
  return /* @__PURE__ */ a.createElement(X, { as: t, ...s }, f(n, s.lang));
}, Y = (e, t = "200,", n = "full") => {
  Array.isArray(e) && (e = e[0]);
  const { id: o, service: s } = e;
  let r;
  if (!s)
    return o;
  if (Array.isArray(e.service) && e.service.length > 0 && (r = s[0]), r) {
    if (r["@id"])
      return `${r["@id"]}/${n}/${t}/0/default.jpg`;
    if (r.id)
      return `${r.id}/${n}/${t}/0/default.jpg`;
  }
}, $ = m("img", { objectFit: "cover" }), T = (e) => {
  const t = D(null), { contentResource: n, altAsLabel: o, region: s = "full" } = e;
  let r;
  o && (r = f(o));
  const d = p(e, ["contentResource", "altAsLabel"]), { type: x, id: c, width: h = 200, height: S = 200, duration: g } = n;
  M(() => {
    if (!c && !t.current || ["Image"].includes(x) || !c.includes("m3u8"))
      return;
    const l = new E();
    return t.current && (l.attachMedia(t.current), l.on(E.Events.MEDIA_ATTACHED, function() {
      l.loadSource(c);
    })), l.on(E.Events.ERROR, function(v, y) {
      if (y.fatal)
        switch (y.type) {
          case E.ErrorTypes.NETWORK_ERROR:
            console.error(
              `fatal ${v} network error encountered, try to recover`
            ), l.startLoad();
            break;
          case E.ErrorTypes.MEDIA_ERROR:
            console.error(
              `fatal ${v} media error encountered, try to recover`
            ), l.recoverMediaError();
            break;
          default:
            l.destroy();
            break;
        }
    }), () => {
      l && (l.detachMedia(), l.destroy());
    };
  }, [c, x]);
  const b = z(() => {
    if (!t.current)
      return;
    let l = 0, v = 30;
    if (g && (v = g), !c.split("#t=") && g && (l = g * 0.1), c.split("#t=").pop()) {
      const C = c.split("#t=").pop();
      C && (l = parseInt(C.split(",")[0]));
    }
    const y = t.current;
    y.autoplay = !0, y.currentTime = l, setTimeout(() => b(), v * 1e3);
  }, [g, c]);
  M(() => b(), [b]);
  const j = Y(
    n,
    `${h},${S}`,
    s
  );
  switch (x) {
    case "Image":
      return /* @__PURE__ */ a.createElement(
        $,
        {
          as: "img",
          alt: r,
          css: { width: h, height: S },
          key: c,
          src: j,
          ...d
        }
      );
    case "Video":
      return /* @__PURE__ */ a.createElement(
        $,
        {
          as: "video",
          css: { width: h, height: S },
          disablePictureInPicture: !0,
          key: c,
          loop: !0,
          muted: !0,
          onPause: b,
          ref: t,
          src: c
        }
      );
    default:
      return console.warn(
        `Resource type: ${x} is not valid or not yet supported in Primitives.`
      ), /* @__PURE__ */ a.createElement(a.Fragment, null);
  }
}, Z = m("a", {}), ee = (e) => {
  const { children: t, homepage: n } = e, s = p(e, ["children", "homepage"]);
  return /* @__PURE__ */ a.createElement(a.Fragment, null, n && n.map((r) => {
    const i = f(
      r.label,
      s.lang
    );
    return /* @__PURE__ */ a.createElement(
      Z,
      {
        "aria-label": t ? i : void 0,
        href: r.id,
        key: r.id,
        ...s
      },
      t || i
    );
  }));
}, te = {
  delimiter: ", "
}, R = _(void 0), F = () => {
  const e = q(R);
  if (e === void 0)
    throw new Error(
      "usePrimitivesContext must be used with a PrimitivesProvider"
    );
  return e;
}, k = ({
  children: e,
  initialState: t = te
}) => {
  const n = ne(t, "delimiter");
  return /* @__PURE__ */ a.createElement(R.Provider, { value: { delimiter: n } }, e);
}, ne = (e, t) => Object.hasOwn(e, t) ? e[t].toString() : void 0, re = m("span", {}), O = (e) => {
  const { as: t, markup: n } = e, { delimiter: o } = F();
  if (!n)
    return /* @__PURE__ */ a.createElement(a.Fragment, null);
  const r = p(e, ["as", "markup"]), i = U(
    f(n, r.lang, o)
  );
  return /* @__PURE__ */ a.createElement(re, { as: t, ...r, dangerouslySetInnerHTML: i });
}, w = (e) => a.useContext(R) ? /* @__PURE__ */ a.createElement(O, { ...e }) : /* @__PURE__ */ a.createElement(k, null, /* @__PURE__ */ a.createElement(O, { ...e })), I = ({ as: e = "dd", lang: t, value: n }) => /* @__PURE__ */ a.createElement(w, { markup: n, as: e, lang: t }), ae = m("span", {}), se = ({
  as: e = "dd",
  customValueContent: t,
  lang: n,
  value: o
}) => {
  var i;
  const { delimiter: s } = F(), r = (i = V(o, n)) == null ? void 0 : i.map((d) => W(t, {
    value: d
  }));
  return /* @__PURE__ */ a.createElement(ae, { as: e, lang: n }, r == null ? void 0 : r.map((d, x) => [
    x > 0 && `${s}`,
    /* @__PURE__ */ a.createElement(N, { key: x }, d)
  ]));
}, P = (e) => {
  var d;
  const { item: t, lang: n, customValueContent: o } = e, { label: s, value: r } = t, i = (d = f(s)) == null ? void 0 : d.replace(" ", "-").toLowerCase();
  return /* @__PURE__ */ a.createElement("div", { role: "group", "data-label": i }, /* @__PURE__ */ a.createElement(L, { as: "dt", label: s, lang: n }), o ? /* @__PURE__ */ a.createElement(
    se,
    {
      as: "dd",
      customValueContent: o,
      value: r,
      lang: n
    }
  ) : /* @__PURE__ */ a.createElement(I, { as: "dd", value: r, lang: n }));
}, H = (e, t) => Object.hasOwn(e, t) ? e[t].toString() : void 0;
function oe(e, t) {
  const n = t.filter((o) => {
    const { matchingLabel: s } = o, r = Object.keys(o.matchingLabel)[0], i = f(s, r);
    if (f(e, r) === i)
      return !0;
  }).map((o) => o.Content);
  if (Array.isArray(n))
    return n[0];
}
const ie = m("dl", {}), le = (e) => {
  const { as: t, customValueContent: n, metadata: o } = e;
  if (!Array.isArray(o))
    return /* @__PURE__ */ a.createElement(a.Fragment, null);
  const s = H(e, "customValueDelimiter"), i = p(e, [
    "as",
    "customValueContent",
    "customValueDelimiter",
    "metadata"
  ]);
  return /* @__PURE__ */ a.createElement(
    k,
    {
      ...typeof s == "string" ? { initialState: { delimiter: s } } : void 0
    },
    o.length > 0 && /* @__PURE__ */ a.createElement(ie, { as: t, ...i }, o.map((d, x) => {
      const c = n ? oe(d.label, n) : void 0;
      return /* @__PURE__ */ a.createElement(
        P,
        {
          customValueContent: c,
          item: d,
          key: x,
          lang: i == null ? void 0 : i.lang
        }
      );
    }))
  );
}, ce = m("li", {}), me = m("ul", {}), ue = (e) => {
  const { as: t, partOf: n } = e, s = p(e, ["as", "partOf"]);
  return /* @__PURE__ */ a.createElement(me, { as: t }, n && n.map((r) => {
    const i = r.label ? f(r.label, s.lang) : void 0;
    return /* @__PURE__ */ a.createElement(ce, { key: r.id }, /* @__PURE__ */ a.createElement("a", { href: r.id, ...s }, i || r.id));
  }));
}, de = m("li", {}), pe = m("ul", {}), fe = (e) => {
  const { as: t, rendering: n } = e, s = p(e, ["as", "rendering"]);
  return /* @__PURE__ */ a.createElement(pe, { as: t }, n && n.map((r) => {
    const i = f(
      r.label,
      s.lang
    );
    return /* @__PURE__ */ a.createElement(de, { key: r.id }, /* @__PURE__ */ a.createElement("a", { href: r.id, ...s, target: "_blank" }, i || r.id));
  }));
}, xe = m("dl", {}), ge = (e) => {
  const { as: t, requiredStatement: n } = e;
  if (!n)
    return /* @__PURE__ */ a.createElement(a.Fragment, null);
  const o = H(e, "customValueDelimiter"), r = p(e, ["as", "customValueDelimiter", "requiredStatement"]);
  return /* @__PURE__ */ a.createElement(
    k,
    {
      ...typeof o == "string" ? { initialState: { delimiter: o } } : void 0
    },
    /* @__PURE__ */ a.createElement(xe, { as: t, ...r }, /* @__PURE__ */ a.createElement(P, { item: n, lang: r.lang }))
  );
}, ve = m("li", {}), ye = m("ul", {}), Ee = (e) => {
  const { as: t, seeAlso: n } = e, s = p(e, ["as", "seeAlso"]);
  return /* @__PURE__ */ a.createElement(ye, { as: t }, n && n.map((r) => {
    const i = f(
      r.label,
      s.lang
    );
    return /* @__PURE__ */ a.createElement(ve, { key: r.id }, /* @__PURE__ */ a.createElement("a", { href: r.id, ...s }, i || r.id));
  }));
}, be = (e) => {
  const { as: t, summary: n } = e, s = p(e, ["as", "customValueDelimiter", "summary"]);
  return /* @__PURE__ */ a.createElement(w, { as: t, markup: n, ...s });
}, he = (e) => {
  const { thumbnail: t, region: n } = e, s = p(e, ["thumbnail"]);
  return /* @__PURE__ */ a.createElement(a.Fragment, null, t && t.map((r) => /* @__PURE__ */ a.createElement(
    T,
    {
      contentResource: r,
      key: r.id,
      region: n,
      ...s
    }
  )));
}, u = () => (console.log("Use dot notation to access Primitives.*, ex: Primitives.Label"), null);
u.ContentResource = T;
u.Homepage = ee;
u.Label = L;
u.Markup = w;
u.Metadata = le;
u.MetadataItem = P;
u.PartOf = ue;
u.Rendering = fe;
u.RequiredStatement = ge;
u.SeeAlso = Ee;
u.Summary = be;
u.Thumbnail = he;
u.Value = I;
export {
  T as ContentResource,
  ee as Homepage,
  L as Label,
  w as Markup,
  le as Metadata,
  P as MetadataItem,
  ue as PartOf,
  fe as Rendering,
  ge as RequiredStatement,
  Ee as SeeAlso,
  be as Summary,
  he as Thumbnail,
  I as Value,
  u as default
};
//# sourceMappingURL=index.mjs.map
