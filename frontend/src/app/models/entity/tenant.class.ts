import { Entity } from './entity.class';
import { Lease } from './lease.class';

export class Tenant extends Entity {
  '@type' = 'Lease';
  firstName: string;
  lastName: string;
  email: string;
  phone: string;
  leases: Lease[];
}
