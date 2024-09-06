import { v4 as uuid } from 'uuid';
import equals from 'fast-deep-equal';

export default class WebAnnotation {

  constructor(annotation, opts) {
    this.underlying = annotation;
    this.opts = opts;
  }

  /** For convenience - creates an empty web annotation **/
  static create = args => {
    const stub = {
      '@context': 'http://www.w3.org/ns/anno.jsonld',
      'type': 'Annotation',
      'id': `#${uuid()}`,
      'body': []
    };

    return new WebAnnotation({ ...stub, ...args });
  }

  /** Creates a copy of this annotation **/
  clone = (opt_props, opt_opts) => {
    return new WebAnnotation({ ...this.underlying, ...opt_props}, { ...this.opts, ...opt_opts });
  }

  /** An equality check based on the underlying object **/
  isEqual(other) {
    if (other?.type !== 'Annotation') {
      return false;
    } else if (this.underlying === other.underlying) {
      return true;
    } else if (!this.underlying.id || !other.underlying.id) {
      return false;
    } else {
      return equals(this.underlying, other.underlying);
    }
  }

  get readOnly() {
    return this.opts?.readOnly;
  }

  /*************************************/
  /* Getters to forward properties of  */
  /* the underlying annotation         */
  /*************************************/

  get id() {
    return this.underlying.id;
  }

  get context() {
    return this.underlying['@context'];
  }

  get type() {
    return this.underlying.type;
  }

  get motivation() {
    return this.underlying.motivation;
  }

  get body() {
    return this.underlying.body;
  }

  get target() {
    return this.underlying.target;
  }

  /** Same as .body, but guaranteed to return an array **/
  get bodies() {
    return (Array.isArray(this.underlying.body)) ?
      this.underlying.body : [ this.underlying.body ];
  }

  /** Only bodies are meant to be mutated by the application **/
  set bodies(bodies) {
    this.underlying.body = bodies;
  }

  /** Same as .target, but guaranteed to return an array **/
  get targets() {
    return (Array.isArray(this.underlying.target)) ?
      this.underlying.target : [ this.underlying.target ];
  }

  /*****************************************/
  /* Various access helpers and shorthands */
  /*****************************************/

  /** Selector of the given type **/
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

  /** Shorthand for the 'start' field of the TextPositionSelector **/
  get start() {
    return this.selector('TextPositionSelector')?.start;
  }

  /** Shorthand for the 'end' field of the TextPositionSelector **/
  get end() {
    return this.selector('TextPositionSelector')?.end;
  }

}
