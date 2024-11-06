import { Role } from '../enum/role.enum';
import { Entity } from './entity.class';

export class User extends Entity {
  '@type' = 'User';
  email: string;
  firstName: string;
  lastName: string;
  active: boolean;

  /**
   * Role as set in the database.
   */
  role: Role;

  /**
   * Computed available roles with the hierarchy.
   * Value cannot be edited.
   */
  readonly roles: Role[];
}
