export declare const manifest: {
    "@context": string;
    id: string;
    type: string;
    label: {
        en: string[];
    };
    items: {
        id: string;
        type: string;
        label: {
            en: string[];
        };
        duration: number;
        accompanyingCanvas: {
            id: string;
            type: string;
            label: {
                en: string[];
            };
            height: number;
            width: number;
            items: {
                id: string;
                type: string;
                items: {
                    id: string;
                    type: string;
                    motivation: string;
                    body: {
                        id: string;
                        type: string;
                        format: string;
                        height: number;
                        width: number;
                        service: {
                            id: string;
                            type: string;
                            profile: string;
                        }[];
                    };
                    target: string;
                }[];
            }[];
        };
        items: {
            id: string;
            type: string;
            items: {
                id: string;
                type: string;
                motivation: string;
                body: {
                    id: string;
                    type: string;
                    duration: number;
                    format: string;
                };
                target: string;
            }[];
        }[];
    }[];
};
