import { forkJoin, Observable, ObservableInput, ObservedValueUnionFromArray, of } from 'rxjs';

/**
 * Do a {@link forkJoin} on the array, but add supports of empty array.
 * By default, an empty array would not fire any response.
 */
export const emptyForkJoin =
  <T extends ObservableInput<any>[]>(sources: T): Observable<ObservedValueUnionFromArray<T>[]> =>
    sources.length
      ? forkJoin(sources)
      : of([])
;
