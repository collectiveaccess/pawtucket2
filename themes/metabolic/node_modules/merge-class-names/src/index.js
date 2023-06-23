export default function mergeClassNames() {
  return Array.prototype.slice.call(arguments).reduce(
    (classList, arg) => (
      (typeof arg === 'string' || Array.isArray(arg))
        ? classList.concat(arg)
        : classList
    ),
    [],
  ).filter(Boolean).join(' ');
}
