import WebAnnotation from './WebAnnotation';
import { v4 as uuid } from 'uuid';
import equals from 'fast-deep-equal';

/**
 * An "annotation in draft mode". Really the same
 * data structure, but as a separate class so we can
 * tell things apart properly.
 */
export default class Selection {

  constructor(target, body) {
    this.underlying = {
      '@context': 'http://www.w3.org/ns/anno.jsonld',
      type: 'Selection',
      body: body || [],
      target
    }
  }

  /** Creates a copy of this selection **/
  clone = opt_props => {
    // Deep-clone
    const cloned = new Selection();
    cloned.underlying = JSON.parse(JSON.stringify(this.underlying));

    if (opt_props)
      cloned.underlying = { ...cloned.underlying, ...opt_props };

    return cloned;
  }

  get context() {
    return this.underlying['@context'];
  }

  get type() {
    return this.underlying.type;
  }

  get body() {
    return this.underlying.body;
  }

  get target() {
    return this.underlying.target;
  }

  get targets() {
    return (Array.isArray(this.underlying.target)) ?
      this.underlying.target : [ this.underlying.target ];
  }

  /** For consistency with WebAnnotation **/
  isEqual(other) {
    if (!other) {
      return false;
    } else {
      return equals(this.underlying, other.underlying);
    }
  }

  get bodies() {
    return (Array.isArray(this.underlying.body)) ?
      this.underlying.body : [ this.underlying.body ];
  }

  selector = type => {
    const { target } = this.underlying;

    if (target.selector) {
      // Normalize to array
      const selectors = Array.isArray(target.selector) ?
        target.selector : [ target.selector ];

      return selectors.find(s => s.type === type);
    }
  }

  /** Shorthand for the 'exact' field of the TextQuoteSelector **/
  get quote() {
    return this.selector('TextQuoteSelector')?.exact;
  }

  /*******************************************/
  /* Selection-specific properties & methods */
  /*******************************************/

  get isSelection() {
    return true;
  }

  toAnnotation = () => {
    const a = Object.assign({}, this.underlying, {
      'type': 'Annotation',
      'id': `#${uuid()}`
    });

    return new WebAnnotation(a);
  }

}
