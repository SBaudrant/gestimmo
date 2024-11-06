import { Entity } from '../entity/entity.class';

export interface ListOrder<T extends Entity> {
  property: keyof T | string;
  direction: 'asc' | 'desc';
}

