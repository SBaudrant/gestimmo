export const isIri = (v: any): boolean => typeof v === 'string' && /^\/[a-z_\/-]+\/\d+$/.test(v);
