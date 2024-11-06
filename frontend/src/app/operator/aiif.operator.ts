import { defer, EMPTY, Observable, ObservableInput } from 'rxjs';

/**
 * Works like {@see iif} but using callback to generate the true/false values instead of passing them.
 */
export const aiif = <T = never, F = never>(
  condition: () => boolean,
  trueResult: () => ObservableInput<T> = () => EMPTY,
  falseResult: () => ObservableInput<F> = () => EMPTY,
): Observable<T> | Observable<F> =>
  <Observable<T> | Observable<F>> <unknown> defer(() => condition() ? trueResult() : falseResult())
;
