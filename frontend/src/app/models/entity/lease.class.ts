import { LocationTypeEnum } from '@enum/location-type.enum';
import { Entity } from './entity.class';
import { RentalProperty } from './property.class';
import { Tenant } from './tenant.class';

export class Lease extends Entity {
  '@type' = 'Lease';
  startDate: Date;
  endDate: Date;
  locationType: LocationTypeEnum;
  rentalProperty: RentalProperty;
  tenants: Tenant[];
}
