import { Injectable } from '@angular/core';
import { EntityDataSource } from '@components/entity-list/entity-data-source.service';
import { Property } from '@entity/property.class';
import { PropertyService } from '@services/property.service';

@Injectable({
  providedIn: 'root',
})
export class PropertiesListDataSource extends EntityDataSource<Property> {
  constructor(
    propertyService: PropertyService,
  ) {
    super(propertyService);
  }
}
