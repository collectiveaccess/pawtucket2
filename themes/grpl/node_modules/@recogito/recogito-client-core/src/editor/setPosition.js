const MARGIN_VERTICAL = 14;

/** Sets the editor position and determines a proper orientation **/
const setPosition = (wrapperEl, editorEl, selectedEl, autoPosition) => {
  // Container element bounds
  const containerBounds = wrapperEl.getBoundingClientRect();

  // Re-set orientation class
  editorEl.className = 'r6o-editor r6o-arrow-top r6o-arrow-left';

  // Default orientation (upwards arrow, at bottom-left of shape)
  const { left, top, right, bottom } = selectedEl.getBoundingClientRect();
  editorEl.style.top = `${bottom - containerBounds.top + MARGIN_VERTICAL}px`;
  editorEl.style.left = `${left - containerBounds.left}px`;

  if (autoPosition) {
    const defaultOrientation = editorEl.children[1].getBoundingClientRect();

    const { innerWidth, innerHeight } = wrapperEl.ownerDocument.defaultView;

    // Test 1: does right edge extend beyond the width of the page?
    // If so, flip horizontally
    if (defaultOrientation.right > innerWidth) {
      editorEl.classList.remove('r6o-arrow-left');
      editorEl.classList.add('r6o-arrow-right');
      editorEl.style.left = `${right - defaultOrientation.width - containerBounds.left}px`;
    }

    // Test 2: does the bottom edge extend beyond the height of the page?
    // If so, flip vertically
    if (defaultOrientation.bottom > innerHeight) {
      editorEl.classList.remove('r6o-arrow-top');
      editorEl.classList.add('r6o-arrow-bottom');
      
      const editorHeight = editorEl.children[1].getBoundingClientRect().height;
      editorEl.style.top = `${top - containerBounds.top - editorHeight - MARGIN_VERTICAL}px`;
    }

    // Get bounding box in current orientation for next tests
    const currentOrientation = editorEl.children[1].getBoundingClientRect();

    // Test 3: does the top (still?) extend beyond top of the page?
    // If so, push it down
    if (currentOrientation.top < 0) {
      editorEl.classList.add('pushed', 'down');
      editorEl.style.top = `${-containerBounds.top}px`;

      const shapeBottom = bottom - containerBounds.top;
      const editorBottom = currentOrientation.height - containerBounds.top;

      if (editorBottom > shapeBottom)
        editorEl.classList.remove('r6o-arrow-bottom');

    }

    // Test 4: does the left edge extend beyond the start of the page?
    // If so, push inward
    if (currentOrientation.left < 0) {
      editorEl.classList.add('pushed', 'right');
      editorEl.style.left = `${-containerBounds.left}px`;
    }

    // Make visible
    requestAnimationFrame(() =>
      editorEl.style.opacity = 1);
  }
}

export default setPosition;
