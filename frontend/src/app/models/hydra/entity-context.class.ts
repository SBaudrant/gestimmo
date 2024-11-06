export abstract class EntityContext {
  public readonly '@context'?: string;
  public readonly '@id': string;
  public abstract readonly '@type': string;
}
