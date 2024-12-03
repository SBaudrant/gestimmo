import { Entity } from './entity.class';

export class Address extends Entity {
  '@type' = 'Address';
  city: string;
  street: string;
  postalCode: string;
}
