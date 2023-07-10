export default function getMenuItemId(id, position) {
  return "".concat(id || '', "-item-").concat(position);
}