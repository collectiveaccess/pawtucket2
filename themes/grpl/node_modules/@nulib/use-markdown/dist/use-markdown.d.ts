export type UseMarkdownParams = string;

export interface UseMarkdownReturn {
  html: string;
  jsx: JSX.Element;
}

declare const useMarkdown: (markdown: UseMarkdownParams) => UseMarkdownReturn;

export default useMarkdown;
