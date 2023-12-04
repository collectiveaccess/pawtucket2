export declare type PagingProperties = {
  /**
   * A link from a resource with pages, such as a {@link Collection collection} or {@link Layer layer}, to its first
   * page resource, another collection or an {@link AnnotationList annotation list} respectively. The page resource
   * should be referenced by just its URI (from @id) but may also have more information associated with it as an object.
   *
   * - A {@link Collection collection} may have exactly one collection as its first page.
   * - A {@link Layer layer} may have exactly one annotation list as its first page.
   * - Other resource types must not have a first page.
   */
  first?: string;

  /**
   * A link from a resource with pages to its last page resource. The page resource should be referenced by just its
   * URI (from @id) but may also have more information associated with it as an object.
   *
   * - A {@link Collection collection} may have exactly one collection as its last page.
   * - A {@link Layer layer} may have exactly one annotation list as its last page.
   * - Other resource types must not have a last page.
   */
  last?: string;

  /**
   * The total number of leaf resources, such as {@Link Annotation annotations} within a {@link Layer layer}, within a
   * list of pages. The value must be a non-negative integer.
   *
   * - A {@link Collection collection} may have exactly one total, which must be the total number of collections and
   *   manifests in its list of pages.
   * - A {@link Layer layer} may have exactly one total, which must be the total number of annotations in its list of
   *   pages.
   * - Other resource types must not have a total.
   */
  total?: number;

  /**
   * A link from a page resource to the next page resource that follows it in order. The resource should be referenced
   * by just its URI (from @id) but may also have more information associated with it as an object.
   *
   * - A {@link Collection collection} may have exactly one collection as its next page.
   * - An {@link AnnotationList annotation list} may have exactly one annotation list as its next page.
   * - Other resource types must not have next pages.
   */
  next?: string;

  /**
   * A link from a page resource to the previous page resource that precedes it in order. The resource should be
   * referenced by just its URI (from @id) but may also have more information associated with it as an object.
   *
   * - A {@link Collection collection} may have exactly one collection as its previous page.
   * - An {@link AnnotationList annotation list} may have exactly one annotation list as its previous page.
   * - Other resource types must not have previous pages.
   */
  prev?: string;

  /**
   * The 0 based index of the first included resource in the current page, relative to the parent paged resource. The
   * value must be a non-negative integer.
   *
   * - A {@link Collection collection} may have exactly one startIndex, which must be the index of its first collection
   *   or manifest relative to the order established by its paging collection.
   * - An {@link AnnotationList annotation list} may have exactly one startIndex, which must be the index of its first
   *   annotation relative to the order established by its paging layer.
   * - Other resource types must not have a startIndex.
   */
  startIndex?: number;
};
