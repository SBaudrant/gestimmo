import { Entity } from '../models/entity/entity.class';
import { ElementOrArrayType } from '../models/type/element-or-array.type';

function getEntityIri(e: Entity): string | undefined {
  return e ? e['@id'] : undefined;
}

export function entityIri(e: Entity | Entity[]): ElementOrArrayType<string | undefined> {
  if (Array.isArray(e)) {
    return e.map(getEntityIri);
  }

  return getEntityIri(e);
}
