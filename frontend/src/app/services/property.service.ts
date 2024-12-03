import { Injectable } from '@angular/core';

import { HttpService } from './http.service';
import { PropertyFilters } from '@filter/property-filters.class';
import { Property } from '@entity/property.class';
import { Clazz } from '@models/type/clazz.type';

@Injectable({
  providedIn: 'root',
})
export class PropertyService extends HttpService<Property, PropertyFilters> {
  public getClass(): Clazz<Property> {
    return Property;
  }

  public resourcePath(): string {
    return '/rental_properties';
  }

}
