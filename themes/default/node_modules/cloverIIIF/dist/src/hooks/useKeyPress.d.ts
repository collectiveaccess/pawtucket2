/**
 * useKeyPress
 * @param {string} key - the name of the key to respond to, compared against event.key
 * @param {function} action - the action to perform on key press
 */
declare const useKeyPress: (key: string, action: () => void) => void;
export default useKeyPress;
