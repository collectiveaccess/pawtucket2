import React, { useEffect, useRef, useState } from 'react';

const getVocabSuggestions = (query, vocabulary) =>
  vocabulary.filter(item => {
    // Item could be string or { label, uri } tuple
    const label = item.label ? item.label : item;
    return label.toLowerCase().startsWith(query.toLowerCase());
  });

const getFnSuggestions = (query, fn) =>
  fn(query);

const Autocomplete = props => {

  const element = useRef();

  // Current value of the input field
  const [ value, setValue ] = useState(props.initialValue || '');

  // Current list of suggestions    
  const [ suggestions, setSuggestions ] = useState([]);

  // Highlighted suggestion, if any
  const [ highlightedIndex, setHighlightedIndex ] = useState(null);

  useEffect(() => {
    if (props.focus)
      element.current.querySelector('input').focus({ preventScroll: true });
  }, []);

  useEffect(() => {
    props.onChange && props.onChange(value);
  }, [ value ]);

  const getSuggestions = value => {
    if (typeof props.vocabulary === 'function') {
      const result = getFnSuggestions(value, props.vocabulary);

      // Result could be suggestions or Promise
      if (result.then)
        result.then(setSuggestions);
      else 
        setSuggestions(result);
    } else {
      const suggestions = getVocabSuggestions(value, props.vocabulary);
      setSuggestions(suggestions);
    }
  }

  const onSubmit = () => {
    if (highlightedIndex !== null) {
      // Submit highligted suggestion
      props.onSubmit(suggestions[highlightedIndex]);
    } else {
      // Submit input value
      const trimmed = value.trim();

      if (trimmed) {
        // If there is a vocabulary with the same label, use that
        const matchingTerm = Array.isArray(props.vocabulary) ?
          props.vocabulary.find(t => {
            const label = t.label || t;
            return label.toLowerCase() === trimmed.toLowerCase();
          }) : null;

        if (matchingTerm) {
          props.onSubmit(matchingTerm);
        } else {
          // Otherwise, just use as a freetext tag
          props.onSubmit(trimmed);
        }
      }
    }

    setValue('');
    setSuggestions([]);
    setHighlightedIndex(null);
  }

  const onKeyDown = evt => {
    if (evt.which === 13) {
      // Enter
      onSubmit();
    } else if (evt.which === 27) {
      props.onCancel && props.onCancel();
    } else {
      // Neither enter nor cancel
      if (suggestions.length > 0) {
        if (evt.which === 38) {
          // Key up
          if (highlightedIndex === null) {
            setHighlightedIndex(0);
          } else {
            const prev = Math.max(0, highlightedIndex - 1);
            setHighlightedIndex(prev);
          }
        } else if (evt.which === 40) {
          // Key down
          if (highlightedIndex === null) {
            setHighlightedIndex(0);
          } else {
            const next = Math.min(suggestions.length - 1, highlightedIndex + 1);
            setHighlightedIndex(next);
          }
        }
      } else {
        // No suggestions: key down shows all vocab 
        // options (only for hard-wired vocabs!)
        if (evt.which === 40) {
          if (Array.isArray(props.vocabulary))
            setSuggestions(props.vocabulary);
        }
      }
    }
  }

  const onChange = evt => {
    const { value } = evt.target;

    // Set controlled input value
    setValue(value);

    // Typing on the input resets the highlight
    setHighlightedIndex(null);

    if (value)
      getSuggestions(value);
    else
      setSuggestions([]);
  }

  return (
    <div
      ref={element}  
      className="r6o-autocomplete">
      <div>
        <input
          onKeyDown={onKeyDown}
          onChange={onChange}
          value={value}
          placeholder={props.placeholder} />
      </div>
      <ul>
        {suggestions.length > 0 && suggestions.map((item, index) => (
          <li 
            key={`${item.label ? item.label : item}${index}`}
            onClick={onSubmit}
            onMouseEnter={() => setHighlightedIndex(index)}
            style={
                highlightedIndex === index
                  ? { backgroundColor: '#bde4ff' }
                  : {}
              }>
            {item.label ? item.label : item}
          </li>
        ))}
      </ul>
    </div>
  )
}

export default Autocomplete;