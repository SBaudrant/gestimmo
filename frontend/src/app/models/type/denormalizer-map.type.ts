export type DenormalizerMap<T> = { [P in keyof T]?: (tp: any, p: P, t: T) => T[P] };
