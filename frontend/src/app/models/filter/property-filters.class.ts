import { AbstractFilters } from './abstract-filters.class';
import { RentalProperty } from '@entity/property.class';

export class RentalPropertyFilters extends AbstractFilters<RentalProperty> {
  search: string | null = null;
  role: string | null = null;
}
