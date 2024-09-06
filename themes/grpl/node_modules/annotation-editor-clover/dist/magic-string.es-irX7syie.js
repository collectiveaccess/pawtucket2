import { c as U } from "./_commonjsHelpers-CT_km90n.js";
var O = { exports: {} };
(function(p, t) {
  (function(e, n) {
    n(t);
  })(U, function(e) {
    const r = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", s = new Uint8Array(64), h = new Uint8Array(128);
    for (let u = 0; u < r.length; u++) {
      const l = r.charCodeAt(u);
      s[u] = l, h[l] = u;
    }
    const o = typeof TextDecoder < "u" ? /* @__PURE__ */ new TextDecoder() : typeof Buffer < "u" ? {
      decode(u) {
        return Buffer.from(u.buffer, u.byteOffset, u.byteLength).toString();
      }
    } : {
      decode(u) {
        let l = "";
        for (let g = 0; g < u.length; g++)
          l += String.fromCharCode(u[g]);
        return l;
      }
    };
    function a(u) {
      const l = new Int32Array(5), g = [];
      let w = 0;
      do {
        const d = S(u, w), m = [];
        let c = !0, b = 0;
        l[0] = 0;
        for (let f = w; f < d; f++) {
          let x;
          f = y(u, f, l, 0);
          const C = l[0];
          C < b && (c = !1), b = C, N(u, f, d) ? (f = y(u, f, l, 1), f = y(u, f, l, 2), f = y(u, f, l, 3), N(u, f, d) ? (f = y(u, f, l, 4), x = [C, l[1], l[2], l[3], l[4]]) : x = [C, l[1], l[2], l[3]]) : x = [C], m.push(x);
        }
        c || T(m), g.push(m), w = d + 1;
      } while (w <= u.length);
      return g;
    }
    function S(u, l) {
      const g = u.indexOf(";", l);
      return g === -1 ? u.length : g;
    }
    function y(u, l, g, w) {
      let d = 0, m = 0, c = 0;
      do {
        const f = u.charCodeAt(l++);
        c = h[f], d |= (c & 31) << m, m += 5;
      } while (c & 32);
      const b = d & 1;
      return d >>>= 1, b && (d = -2147483648 | -d), g[w] += d, l;
    }
    function N(u, l, g) {
      return l >= g ? !1 : u.charCodeAt(l) !== 44;
    }
    function T(u) {
      u.sort(j);
    }
    function j(u, l) {
      return u[0] - l[0];
    }
    function $(u) {
      const l = new Int32Array(5), g = 1024 * 16, w = g - 36, d = new Uint8Array(g), m = d.subarray(0, w);
      let c = 0, b = "";
      for (let f = 0; f < u.length; f++) {
        const x = u[f];
        if (f > 0 && (c === g && (b += o.decode(d), c = 0), d[c++] = 59), x.length !== 0) {
          l[0] = 0;
          for (let C = 0; C < x.length; C++) {
            const v = x[C];
            c > w && (b += o.decode(m), d.copyWithin(0, w, c), c -= w), C > 0 && (d[c++] = 44), c = k(d, c, l, v, 0), v.length !== 1 && (c = k(d, c, l, v, 1), c = k(d, c, l, v, 2), c = k(d, c, l, v, 3), v.length !== 4 && (c = k(d, c, l, v, 4)));
          }
        }
      }
      return b + o.decode(d.subarray(0, c));
    }
    function k(u, l, g, w, d) {
      const m = w[d];
      let c = m - g[d];
      g[d] = m, c = c < 0 ? -c << 1 | 1 : c << 1;
      do {
        let b = c & 31;
        c >>>= 5, c > 0 && (b |= 32), u[l++] = s[b];
      } while (c > 0);
      return l;
    }
    e.decode = a, e.encode = $, Object.defineProperty(e, "__esModule", { value: !0 });
  });
})(O, O.exports);
var M = O.exports;
class R {
  constructor(t) {
    this.bits = t instanceof R ? t.bits.slice() : [];
  }
  add(t) {
    this.bits[t >> 5] |= 1 << (t & 31);
  }
  has(t) {
    return !!(this.bits[t >> 5] & 1 << (t & 31));
  }
}
class _ {
  constructor(t, e, n) {
    this.start = t, this.end = e, this.original = n, this.intro = "", this.outro = "", this.content = n, this.storeName = !1, this.edited = !1, this.previous = null, this.next = null;
  }
  appendLeft(t) {
    this.outro += t;
  }
  appendRight(t) {
    this.intro = this.intro + t;
  }
  clone() {
    const t = new _(this.start, this.end, this.original);
    return t.intro = this.intro, t.outro = this.outro, t.content = this.content, t.storeName = this.storeName, t.edited = this.edited, t;
  }
  contains(t) {
    return this.start < t && t < this.end;
  }
  eachNext(t) {
    let e = this;
    for (; e; )
      t(e), e = e.next;
  }
  eachPrevious(t) {
    let e = this;
    for (; e; )
      t(e), e = e.previous;
  }
  edit(t, e, n) {
    return this.content = t, n || (this.intro = "", this.outro = ""), this.storeName = e, this.edited = !0, this;
  }
  prependLeft(t) {
    this.outro = t + this.outro;
  }
  prependRight(t) {
    this.intro = t + this.intro;
  }
  reset() {
    this.intro = "", this.outro = "", this.edited && (this.content = this.original, this.storeName = !1, this.edited = !1);
  }
  split(t) {
    const e = t - this.start, n = this.original.slice(0, e), i = this.original.slice(e);
    this.original = n;
    const r = new _(t, this.end, i);
    return r.outro = this.outro, this.outro = "", this.end = t, this.edited ? (r.edit("", !1), this.content = "") : this.content = n, r.next = this.next, r.next && (r.next.previous = r), r.previous = this, this.next = r, r;
  }
  toString() {
    return this.intro + this.content + this.outro;
  }
  trimEnd(t) {
    if (this.outro = this.outro.replace(t, ""), this.outro.length)
      return !0;
    const e = this.content.replace(t, "");
    if (e.length)
      return e !== this.content && (this.split(this.start + e.length).edit("", void 0, !0), this.edited && this.edit(e, this.storeName, !0)), !0;
    if (this.edit("", void 0, !0), this.intro = this.intro.replace(t, ""), this.intro.length)
      return !0;
  }
  trimStart(t) {
    if (this.intro = this.intro.replace(t, ""), this.intro.length)
      return !0;
    const e = this.content.replace(t, "");
    if (e.length) {
      if (e !== this.content) {
        const n = this.split(this.end - e.length);
        this.edited && n.edit(e, this.storeName, !0), this.edit("", void 0, !0);
      }
      return !0;
    } else if (this.edit("", void 0, !0), this.outro = this.outro.replace(t, ""), this.outro.length)
      return !0;
  }
}
function B() {
  return typeof globalThis < "u" && typeof globalThis.btoa == "function" ? (p) => globalThis.btoa(unescape(encodeURIComponent(p))) : typeof Buffer == "function" ? (p) => Buffer.from(p, "utf-8").toString("base64") : () => {
    throw new Error("Unsupported environment: `window.btoa` or `Buffer` should be supported.");
  };
}
const P = /* @__PURE__ */ B();
class D {
  constructor(t) {
    this.version = 3, this.file = t.file, this.sources = t.sources, this.sourcesContent = t.sourcesContent, this.names = t.names, this.mappings = M.encode(t.mappings), typeof t.x_google_ignoreList < "u" && (this.x_google_ignoreList = t.x_google_ignoreList);
  }
  toString() {
    return JSON.stringify(this);
  }
  toUrl() {
    return "data:application/json;charset=utf-8;base64," + P(this.toString());
  }
}
function q(p) {
  const t = p.split(`
`), e = t.filter((r) => /^\t+/.test(r)), n = t.filter((r) => /^ {2,}/.test(r));
  if (e.length === 0 && n.length === 0)
    return null;
  if (e.length >= n.length)
    return "	";
  const i = n.reduce((r, s) => {
    const h = /^ +/.exec(s)[0].length;
    return Math.min(h, r);
  }, 1 / 0);
  return new Array(i + 1).join(" ");
}
function z(p, t) {
  const e = p.split(/[/\\]/), n = t.split(/[/\\]/);
  for (e.pop(); e[0] === n[0]; )
    e.shift(), n.shift();
  if (e.length) {
    let i = e.length;
    for (; i--; )
      e[i] = "..";
  }
  return e.concat(n).join("/");
}
const F = Object.prototype.toString;
function G(p) {
  return F.call(p) === "[object Object]";
}
function A(p) {
  const t = p.split(`
`), e = [];
  for (let n = 0, i = 0; n < t.length; n++)
    e.push(i), i += t[n].length + 1;
  return function(i) {
    let r = 0, s = e.length;
    for (; r < s; ) {
      const a = r + s >> 1;
      i < e[a] ? s = a : r = a + 1;
    }
    const h = r - 1, o = i - e[h];
    return { line: h, column: o };
  };
}
const H = /\w/;
class J {
  constructor(t) {
    this.hires = t, this.generatedCodeLine = 0, this.generatedCodeColumn = 0, this.raw = [], this.rawSegments = this.raw[this.generatedCodeLine] = [], this.pending = null;
  }
  addEdit(t, e, n, i) {
    if (e.length) {
      const r = e.length - 1;
      let s = e.indexOf(`
`, 0), h = -1;
      for (; s >= 0 && r > s; ) {
        const a = [this.generatedCodeColumn, t, n.line, n.column];
        i >= 0 && a.push(i), this.rawSegments.push(a), this.generatedCodeLine += 1, this.raw[this.generatedCodeLine] = this.rawSegments = [], this.generatedCodeColumn = 0, h = s, s = e.indexOf(`
`, s + 1);
      }
      const o = [this.generatedCodeColumn, t, n.line, n.column];
      i >= 0 && o.push(i), this.rawSegments.push(o), this.advance(e.slice(h + 1));
    } else
      this.pending && (this.rawSegments.push(this.pending), this.advance(e));
    this.pending = null;
  }
  addUneditedChunk(t, e, n, i, r) {
    let s = e.start, h = !0, o = !1;
    for (; s < e.end; ) {
      if (this.hires || h || r.has(s)) {
        const a = [this.generatedCodeColumn, t, i.line, i.column];
        this.hires === "boundary" ? H.test(n[s]) ? o || (this.rawSegments.push(a), o = !0) : (this.rawSegments.push(a), o = !1) : this.rawSegments.push(a);
      }
      n[s] === `
` ? (i.line += 1, i.column = 0, this.generatedCodeLine += 1, this.raw[this.generatedCodeLine] = this.rawSegments = [], this.generatedCodeColumn = 0, h = !0) : (i.column += 1, this.generatedCodeColumn += 1, h = !1), s += 1;
    }
    this.pending = null;
  }
  advance(t) {
    if (!t)
      return;
    const e = t.split(`
`);
    if (e.length > 1) {
      for (let n = 0; n < e.length - 1; n++)
        this.generatedCodeLine++, this.raw[this.generatedCodeLine] = this.rawSegments = [];
      this.generatedCodeColumn = 0;
    }
    this.generatedCodeColumn += e[e.length - 1].length;
  }
}
const L = `
`, E = {
  insertLeft: !1,
  insertRight: !1,
  storeName: !1
};
class I {
  constructor(t, e = {}) {
    const n = new _(0, t.length, t);
    Object.defineProperties(this, {
      original: { writable: !0, value: t },
      outro: { writable: !0, value: "" },
      intro: { writable: !0, value: "" },
      firstChunk: { writable: !0, value: n },
      lastChunk: { writable: !0, value: n },
      lastSearchedChunk: { writable: !0, value: n },
      byStart: { writable: !0, value: {} },
      byEnd: { writable: !0, value: {} },
      filename: { writable: !0, value: e.filename },
      indentExclusionRanges: { writable: !0, value: e.indentExclusionRanges },
      sourcemapLocations: { writable: !0, value: new R() },
      storedNames: { writable: !0, value: {} },
      indentStr: { writable: !0, value: void 0 },
      ignoreList: { writable: !0, value: e.ignoreList }
    }), this.byStart[0] = n, this.byEnd[t.length] = n;
  }
  addSourcemapLocation(t) {
    this.sourcemapLocations.add(t);
  }
  append(t) {
    if (typeof t != "string")
      throw new TypeError("outro content must be a string");
    return this.outro += t, this;
  }
  appendLeft(t, e) {
    if (typeof e != "string")
      throw new TypeError("inserted content must be a string");
    this._split(t);
    const n = this.byEnd[t];
    return n ? n.appendLeft(e) : this.intro += e, this;
  }
  appendRight(t, e) {
    if (typeof e != "string")
      throw new TypeError("inserted content must be a string");
    this._split(t);
    const n = this.byStart[t];
    return n ? n.appendRight(e) : this.outro += e, this;
  }
  clone() {
    const t = new I(this.original, { filename: this.filename });
    let e = this.firstChunk, n = t.firstChunk = t.lastSearchedChunk = e.clone();
    for (; e; ) {
      t.byStart[n.start] = n, t.byEnd[n.end] = n;
      const i = e.next, r = i && i.clone();
      r && (n.next = r, r.previous = n, n = r), e = i;
    }
    return t.lastChunk = n, this.indentExclusionRanges && (t.indentExclusionRanges = this.indentExclusionRanges.slice()), t.sourcemapLocations = new R(this.sourcemapLocations), t.intro = this.intro, t.outro = this.outro, t;
  }
  generateDecodedMap(t) {
    t = t || {};
    const e = 0, n = Object.keys(this.storedNames), i = new J(t.hires), r = A(this.original);
    return this.intro && i.advance(this.intro), this.firstChunk.eachNext((s) => {
      const h = r(s.start);
      s.intro.length && i.advance(s.intro), s.edited ? i.addEdit(
        e,
        s.content,
        h,
        s.storeName ? n.indexOf(s.original) : -1
      ) : i.addUneditedChunk(e, s, this.original, h, this.sourcemapLocations), s.outro.length && i.advance(s.outro);
    }), {
      file: t.file ? t.file.split(/[/\\]/).pop() : void 0,
      sources: [
        t.source ? z(t.file || "", t.source) : t.file || ""
      ],
      sourcesContent: t.includeContent ? [this.original] : void 0,
      names: n,
      mappings: i.raw,
      x_google_ignoreList: this.ignoreList ? [e] : void 0
    };
  }
  generateMap(t) {
    return new D(this.generateDecodedMap(t));
  }
  _ensureindentStr() {
    this.indentStr === void 0 && (this.indentStr = q(this.original));
  }
  _getRawIndentString() {
    return this._ensureindentStr(), this.indentStr;
  }
  getIndentString() {
    return this._ensureindentStr(), this.indentStr === null ? "	" : this.indentStr;
  }
  indent(t, e) {
    const n = /^[^\r\n]/gm;
    if (G(t) && (e = t, t = void 0), t === void 0 && (this._ensureindentStr(), t = this.indentStr || "	"), t === "")
      return this;
    e = e || {};
    const i = {};
    e.exclude && (typeof e.exclude[0] == "number" ? [e.exclude] : e.exclude).forEach((S) => {
      for (let y = S[0]; y < S[1]; y += 1)
        i[y] = !0;
    });
    let r = e.indentStart !== !1;
    const s = (a) => r ? `${t}${a}` : (r = !0, a);
    this.intro = this.intro.replace(n, s);
    let h = 0, o = this.firstChunk;
    for (; o; ) {
      const a = o.end;
      if (o.edited)
        i[h] || (o.content = o.content.replace(n, s), o.content.length && (r = o.content[o.content.length - 1] === `
`));
      else
        for (h = o.start; h < a; ) {
          if (!i[h]) {
            const S = this.original[h];
            S === `
` ? r = !0 : S !== "\r" && r && (r = !1, h === o.start || (this._splitChunk(o, h), o = o.next), o.prependRight(t));
          }
          h += 1;
        }
      h = o.end, o = o.next;
    }
    return this.outro = this.outro.replace(n, s), this;
  }
  insert() {
    throw new Error(
      "magicString.insert(...) is deprecated. Use prependRight(...) or appendLeft(...)"
    );
  }
  insertLeft(t, e) {
    return E.insertLeft || (console.warn(
      "magicString.insertLeft(...) is deprecated. Use magicString.appendLeft(...) instead"
    ), E.insertLeft = !0), this.appendLeft(t, e);
  }
  insertRight(t, e) {
    return E.insertRight || (console.warn(
      "magicString.insertRight(...) is deprecated. Use magicString.prependRight(...) instead"
    ), E.insertRight = !0), this.prependRight(t, e);
  }
  move(t, e, n) {
    if (n >= t && n <= e)
      throw new Error("Cannot move a selection inside itself");
    this._split(t), this._split(e), this._split(n);
    const i = this.byStart[t], r = this.byEnd[e], s = i.previous, h = r.next, o = this.byStart[n];
    if (!o && r === this.lastChunk)
      return this;
    const a = o ? o.previous : this.lastChunk;
    return s && (s.next = h), h && (h.previous = s), a && (a.next = i), o && (o.previous = r), i.previous || (this.firstChunk = r.next), r.next || (this.lastChunk = i.previous, this.lastChunk.next = null), i.previous = a, r.next = o || null, a || (this.firstChunk = i), o || (this.lastChunk = r), this;
  }
  overwrite(t, e, n, i) {
    return i = i || {}, this.update(t, e, n, { ...i, overwrite: !i.contentOnly });
  }
  update(t, e, n, i) {
    if (typeof n != "string")
      throw new TypeError("replacement content must be a string");
    for (; t < 0; )
      t += this.original.length;
    for (; e < 0; )
      e += this.original.length;
    if (e > this.original.length)
      throw new Error("end is out of bounds");
    if (t === e)
      throw new Error(
        "Cannot overwrite a zero-length range – use appendLeft or prependRight instead"
      );
    this._split(t), this._split(e), i === !0 && (E.storeName || (console.warn(
      "The final argument to magicString.overwrite(...) should be an options object. See https://github.com/rich-harris/magic-string"
    ), E.storeName = !0), i = { storeName: !0 });
    const r = i !== void 0 ? i.storeName : !1, s = i !== void 0 ? i.overwrite : !1;
    if (r) {
      const a = this.original.slice(t, e);
      Object.defineProperty(this.storedNames, a, {
        writable: !0,
        value: !0,
        enumerable: !0
      });
    }
    const h = this.byStart[t], o = this.byEnd[e];
    if (h) {
      let a = h;
      for (; a !== o; ) {
        if (a.next !== this.byStart[a.end])
          throw new Error("Cannot overwrite across a split point");
        a = a.next, a.edit("", !1);
      }
      h.edit(n, r, !s);
    } else {
      const a = new _(t, e, "").edit(n, r);
      o.next = a, a.previous = o;
    }
    return this;
  }
  prepend(t) {
    if (typeof t != "string")
      throw new TypeError("outro content must be a string");
    return this.intro = t + this.intro, this;
  }
  prependLeft(t, e) {
    if (typeof e != "string")
      throw new TypeError("inserted content must be a string");
    this._split(t);
    const n = this.byEnd[t];
    return n ? n.prependLeft(e) : this.intro = e + this.intro, this;
  }
  prependRight(t, e) {
    if (typeof e != "string")
      throw new TypeError("inserted content must be a string");
    this._split(t);
    const n = this.byStart[t];
    return n ? n.prependRight(e) : this.outro = e + this.outro, this;
  }
  remove(t, e) {
    for (; t < 0; )
      t += this.original.length;
    for (; e < 0; )
      e += this.original.length;
    if (t === e)
      return this;
    if (t < 0 || e > this.original.length)
      throw new Error("Character is out of bounds");
    if (t > e)
      throw new Error("end must be greater than start");
    this._split(t), this._split(e);
    let n = this.byStart[t];
    for (; n; )
      n.intro = "", n.outro = "", n.edit(""), n = e > n.end ? this.byStart[n.end] : null;
    return this;
  }
  reset(t, e) {
    for (; t < 0; )
      t += this.original.length;
    for (; e < 0; )
      e += this.original.length;
    if (t === e)
      return this;
    if (t < 0 || e > this.original.length)
      throw new Error("Character is out of bounds");
    if (t > e)
      throw new Error("end must be greater than start");
    this._split(t), this._split(e);
    let n = this.byStart[t];
    for (; n; )
      n.reset(), n = e > n.end ? this.byStart[n.end] : null;
    return this;
  }
  lastChar() {
    if (this.outro.length)
      return this.outro[this.outro.length - 1];
    let t = this.lastChunk;
    do {
      if (t.outro.length)
        return t.outro[t.outro.length - 1];
      if (t.content.length)
        return t.content[t.content.length - 1];
      if (t.intro.length)
        return t.intro[t.intro.length - 1];
    } while (t = t.previous);
    return this.intro.length ? this.intro[this.intro.length - 1] : "";
  }
  lastLine() {
    let t = this.outro.lastIndexOf(L);
    if (t !== -1)
      return this.outro.substr(t + 1);
    let e = this.outro, n = this.lastChunk;
    do {
      if (n.outro.length > 0) {
        if (t = n.outro.lastIndexOf(L), t !== -1)
          return n.outro.substr(t + 1) + e;
        e = n.outro + e;
      }
      if (n.content.length > 0) {
        if (t = n.content.lastIndexOf(L), t !== -1)
          return n.content.substr(t + 1) + e;
        e = n.content + e;
      }
      if (n.intro.length > 0) {
        if (t = n.intro.lastIndexOf(L), t !== -1)
          return n.intro.substr(t + 1) + e;
        e = n.intro + e;
      }
    } while (n = n.previous);
    return t = this.intro.lastIndexOf(L), t !== -1 ? this.intro.substr(t + 1) + e : this.intro + e;
  }
  slice(t = 0, e = this.original.length) {
    for (; t < 0; )
      t += this.original.length;
    for (; e < 0; )
      e += this.original.length;
    let n = "", i = this.firstChunk;
    for (; i && (i.start > t || i.end <= t); ) {
      if (i.start < e && i.end >= e)
        return n;
      i = i.next;
    }
    if (i && i.edited && i.start !== t)
      throw new Error(`Cannot use replaced character ${t} as slice start anchor.`);
    const r = i;
    for (; i; ) {
      i.intro && (r !== i || i.start === t) && (n += i.intro);
      const s = i.start < e && i.end >= e;
      if (s && i.edited && i.end !== e)
        throw new Error(`Cannot use replaced character ${e} as slice end anchor.`);
      const h = r === i ? t - i.start : 0, o = s ? i.content.length + e - i.end : i.content.length;
      if (n += i.content.slice(h, o), i.outro && (!s || i.end === e) && (n += i.outro), s)
        break;
      i = i.next;
    }
    return n;
  }
  // TODO deprecate this? not really very useful
  snip(t, e) {
    const n = this.clone();
    return n.remove(0, t), n.remove(e, n.original.length), n;
  }
  _split(t) {
    if (this.byStart[t] || this.byEnd[t])
      return;
    let e = this.lastSearchedChunk;
    const n = t > e.end;
    for (; e; ) {
      if (e.contains(t))
        return this._splitChunk(e, t);
      e = n ? this.byStart[e.end] : this.byEnd[e.start];
    }
  }
  _splitChunk(t, e) {
    if (t.edited && t.content.length) {
      const i = A(this.original)(e);
      throw new Error(
        `Cannot split a chunk that has already been edited (${i.line}:${i.column} – "${t.original}")`
      );
    }
    const n = t.split(e);
    return this.byEnd[e] = t, this.byStart[e] = n, this.byEnd[n.end] = n, t === this.lastChunk && (this.lastChunk = n), this.lastSearchedChunk = t, !0;
  }
  toString() {
    let t = this.intro, e = this.firstChunk;
    for (; e; )
      t += e.toString(), e = e.next;
    return t + this.outro;
  }
  isEmpty() {
    let t = this.firstChunk;
    do
      if (t.intro.length && t.intro.trim() || t.content.length && t.content.trim() || t.outro.length && t.outro.trim())
        return !1;
    while (t = t.next);
    return !0;
  }
  length() {
    let t = this.firstChunk, e = 0;
    do
      e += t.intro.length + t.content.length + t.outro.length;
    while (t = t.next);
    return e;
  }
  trimLines() {
    return this.trim("[\\r\\n]");
  }
  trim(t) {
    return this.trimStart(t).trimEnd(t);
  }
  trimEndAborted(t) {
    const e = new RegExp((t || "\\s") + "+$");
    if (this.outro = this.outro.replace(e, ""), this.outro.length)
      return !0;
    let n = this.lastChunk;
    do {
      const i = n.end, r = n.trimEnd(e);
      if (n.end !== i && (this.lastChunk === n && (this.lastChunk = n.next), this.byEnd[n.end] = n, this.byStart[n.next.start] = n.next, this.byEnd[n.next.end] = n.next), r)
        return !0;
      n = n.previous;
    } while (n);
    return !1;
  }
  trimEnd(t) {
    return this.trimEndAborted(t), this;
  }
  trimStartAborted(t) {
    const e = new RegExp("^" + (t || "\\s") + "+");
    if (this.intro = this.intro.replace(e, ""), this.intro.length)
      return !0;
    let n = this.firstChunk;
    do {
      const i = n.end, r = n.trimStart(e);
      if (n.end !== i && (n === this.lastChunk && (this.lastChunk = n.next), this.byEnd[n.end] = n, this.byStart[n.next.start] = n.next, this.byEnd[n.next.end] = n.next), r)
        return !0;
      n = n.next;
    } while (n);
    return !1;
  }
  trimStart(t) {
    return this.trimStartAborted(t), this;
  }
  hasChanged() {
    return this.original !== this.toString();
  }
  _replaceRegexp(t, e) {
    function n(r, s) {
      return typeof e == "string" ? e.replace(/\$(\$|&|\d+)/g, (h, o) => o === "$" ? "$" : o === "&" ? r[0] : +o < r.length ? r[+o] : `$${o}`) : e(...r, r.index, s, r.groups);
    }
    function i(r, s) {
      let h;
      const o = [];
      for (; h = r.exec(s); )
        o.push(h);
      return o;
    }
    if (t.global)
      i(t, this.original).forEach((s) => {
        s.index != null && this.overwrite(
          s.index,
          s.index + s[0].length,
          n(s, this.original)
        );
      });
    else {
      const r = this.original.match(t);
      r && r.index != null && this.overwrite(
        r.index,
        r.index + r[0].length,
        n(r, this.original)
      );
    }
    return this;
  }
  _replaceString(t, e) {
    const { original: n } = this, i = n.indexOf(t);
    return i !== -1 && this.overwrite(i, i + t.length, e), this;
  }
  replace(t, e) {
    return typeof t == "string" ? this._replaceString(t, e) : this._replaceRegexp(t, e);
  }
  _replaceAllString(t, e) {
    const { original: n } = this, i = t.length;
    for (let r = n.indexOf(t); r !== -1; r = n.indexOf(t, r + i))
      this.overwrite(r, r + i, e);
    return this;
  }
  replaceAll(t, e) {
    if (typeof t == "string")
      return this._replaceAllString(t, e);
    if (!t.global)
      throw new TypeError(
        "MagicString.prototype.replaceAll called with a non-global RegExp argument"
      );
    return this._replaceRegexp(t, e);
  }
}
export {
  D as SourceMap,
  I as default
};
