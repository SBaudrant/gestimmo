// This file holds our state type, as well as any other types related to this Redux store.

export interface HomeMetrics extends ApiResponse {
  id: number;
  packsToSpecify: number;
  componentsWithoutModel: number;
  ecnInProgress: number;
}

// This type is basically shorthand for `{ [key: string]: any }`. Feel free to replace `any` with
// the expected return type of your API response.
export type ApiResponse = Record<string, any>

// Use `enum`s for better autocompletion of action type names. These will
// be compiled away leaving only the final value in your compiled code.
//
// Define however naming conventions you'd like for your action types, but
// personally, I use the `@@context/ACTION_TYPE` convention, to follow the convention
// of Redux's `@@INIT` action.
export enum HomeActionTypes {
  FETCH_REQUEST = '@@home/FETCH_REQUEST',
  FETCH_SUCCESS = '@@home/FETCH_SUCCESS',
  FETCH_ERROR = '@@home/FETCH_ERROR',
}

// Declare state types with `readonly` modifier to get compile time immutability.
// https://github.com/piotrwitek/react-redux-typescript-guide#state-with-type-level-immutability
export interface HomeState {
  readonly loading: boolean
  readonly data: HomeMetrics[]
  readonly errors?: string
}
