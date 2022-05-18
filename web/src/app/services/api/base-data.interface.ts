export interface BaseData {
    "@context"?: string;
    "@id"?: string;
    "@type"?: string;
    id?: string;
}

export interface HydraView {
    "@id": string;
    "@type": string;
    "hydra:first": string;
    "hydra:last": string;
    "hydra:previous": string;
    "hydra:next": string;
}

export interface HydraMapping {
    "@type": string;
    variable: string;
    property: string;
    required: boolean;
}

export interface HydraSearch {
    "@type": string;
    "hydra:template": string;
    "hydra:variableRepresentation": string;
    "hydra:mapping": HydraMapping[];
}

export interface BaseCollection<t> {
    "@context": string;
    "@id": string;
    "@type": string;
    "hydra:member": t[];
    length: number;
    "hydra:totalItems": number;
    "hydra:view": HydraView,
    "hydra:search": HydraSearch;
}