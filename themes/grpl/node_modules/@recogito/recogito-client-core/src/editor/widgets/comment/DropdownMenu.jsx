import React, { useRef } from 'react';
import useClickOutside from '../../useClickOutside';
import i18n from '../../../i18n';

const DropdownMenu = props => {

  const ref = useRef();

  // Custom hook that notifies when clicked outside this component
  useClickOutside(ref, () => props.onClickOutside());

  return (
    <ul ref={ref} className="r6o-comment-dropdown-menu">
      <li onClick={props.onEdit}>{i18n.t('Edit')}</li>
      <li onClick={props.onDelete}>{i18n.t('Delete')}</li>
    </ul>
  )

}

export default DropdownMenu;