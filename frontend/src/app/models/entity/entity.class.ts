import { EntityContext } from '../hydra/entity-context.class';

export abstract class Entity extends EntityContext {
  public readonly id: string;
}
