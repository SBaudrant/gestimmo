import { Address } from './address.class';
import { Entity } from './entity.class';
import { User } from './user.class';
import { Lease } from './lease.class';

export class RentalProperty extends Entity {
  '@type' = 'RentalProperty';
  label: string;
  address: Address;

  proposedRentBase: number;
  proposedRentFees: number;
  proposedPaymentDay: number;

  owners: User[];
  currentLeases: Lease[];
  leases: Lease[];
}
