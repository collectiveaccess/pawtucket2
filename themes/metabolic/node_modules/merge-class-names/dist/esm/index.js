export default function mergeClassNames() {
  return Array.prototype.slice.call(arguments).reduce(function (classList, arg) {
    return typeof arg === 'string' || Array.isArray(arg) ? classList.concat(arg) : classList;
  }, []).filter(Boolean).join(' ');
}