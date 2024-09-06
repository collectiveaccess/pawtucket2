import { useEffect } from 'react';

export default function useClickOutside(ref, callback) {

  const onClickOutside = _ => {
    if (ref.current && !ref.current.contains(event.target))
      callback();
  }

  useEffect(() => {
    document.addEventListener('mousedown', onClickOutside);

    return () =>
      document.removeEventListener('mousedown', onClickOutside);
  });

}