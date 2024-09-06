/**
 * Content resources such as images or texts that are associated with a canvas.
 */
import { ImageService, Service as P3Service } from '@iiif/presentation-3';

type ContentResourceSelector =
  | {
      '@context': 'http://iiif.io/api/annex/openannotation/context.json';
      '@type': 'iiif:ImageApiSelector';
      region: string;
    }
  | {
      '@type': ['oa:SvgSelector', 'cnt:ContentAsText'] | [ 'cnt:ContentAsText', 'oa:SvgSelector' ] | 'oa:SvgSelector';
      chars: string;
    }
  | {
      '@context': 'http://iiif.io/api/annex/openannotation/context.json';
      '@type': 'iiif:ImageApiSelector';
      rotation: string;
    }
  | {
      '@context': 'http://iiif.io/api/annex/openannotation/context.json';
      '@type': 'iiif:ImageApiSelector';
      region: string;
      rotation: string;
    }
  | {
      '@type': 'oa:Choice';
      default: ContentResourceSelector;
      item: ContentResourceSelector | ContentResourceSelector[];
    }
  | {
      '@type': 'oa:FragmentSelector';
      value: string;
    }

type ImageResourceSegment = {
  '@id': string;
  '@type': 'dctypes:Image';
  height?: number;
  width?: number;
  format?: string;
  service?: ImageService;
};

type TextContentResource = {
  '@id': string;
  '@type': 'dctypes:Text';
  format: 'text/html';
};

type SoundResource = {
  '@id': string;
  '@type': 'dctypes:Sound';
  format: string;
};

type ImageResourceSegmentWithService = {
  '@id': 'http://www.example.org/iiif/book1-page1/50,50,1250,1850/full/0/default.jpg';
  '@type': 'oa:SpecificResource';
  style?: string;
  full: ImageResourceSegment;
  selector?: ContentResourceSelector;
};

export type XmlResourceResourceSegment = {
  '@id': string;
  '@type': 'dctypes:Text';
  format: 'application/tei+xml';
};

export type CharsEmbeddedContent = {
  '@type': 'cnt:ContentAsText';
  chars: string;
  format?: 'text/plain';
  language?: 'en';
};

export type ChoiceEmbeddedContent = {
  '@type': 'oa:Choice';
  default: CommonContentResource | 'rdf:nil';
  item: Array<CommonContentResource> | 'rdf:nil';
};

export type Service = P3Service;

export declare type CommonContentResource =
  | ChoiceEmbeddedContent
  | CharsEmbeddedContent
  | XmlResourceResourceSegment
  | ImageResourceSegmentWithService
  | ImageResourceSegment
  | TextContentResource
  | SoundResource;

export declare type ContentResource =
  | CommonContentResource
  | {
      '@id': string;
      '@type': string;
      format?: string;
      language?: string;
      default?: ContentResource | 'rdf:nil';
      item?: Array<ContentResource> | 'rdf:nil';
      selector?: ContentResourceSelector;
      full?: ImageResourceSegment;
      height?: number;
      width?: number;
      service?: Service;
    };
