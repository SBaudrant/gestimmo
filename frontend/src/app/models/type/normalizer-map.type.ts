export type NormalizerMap<T> = { [P in keyof T]?: (tp: T[P], p: P, t: T) => any };
