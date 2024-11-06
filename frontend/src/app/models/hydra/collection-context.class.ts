import { EntityContext } from './entity-context.class';

export class CollectionContext<T extends EntityContext> extends EntityContext {
  public readonly '@type' = 'hydra:Collection';
  public readonly 'hydra:member': Omit<T, '@context'>[];
  public readonly 'hydra:totalItems': number;
  public readonly 'hydra:view'?: {
    readonly '@id': string;
    readonly '@type': string;
    readonly 'hydra:first'?: string;
    readonly 'hydra:last'?: string;
    readonly 'hydra:next'?: string;
    readonly 'hydra:previous'?: string;
  };
  public readonly 'hydra:search'?: {
    readonly '@type': string;
    readonly 'hydra:mapping': {
      readonly '@type': string;
      readonly variable: string;
      readonly property: string;
      readonly required: boolean;
    }[];
    readonly 'hydra:template': string;
    readonly 'hydra:variableRepresentation': string;
  };
}
