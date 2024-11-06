export type Shape<T> = {
  [P in keyof T]: T[P] | Shape<T[P]> | Shape<T[P]>[];
};
