import { AbstractFilters } from './abstract-filters.class';
import { User } from '@entity/user.class';

export class UserFilters extends AbstractFilters<User> {
  search: string | null = null;
  role: string | null = null;
}
