// Angular core
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// Our modules
import { PropertiesRoutingModule } from './properties-routing.module';

// Our components
import { PropertyFormDialogComponent } from './property-form-dialog/property-form-dialog.component';
import { PropertiesListComponent } from './properties-list/properties-list.component';
import { PropertyAccountComponent } from './property-account/property-account.component';
import { SharedModule } from '../shared.module';

@NgModule({
  imports: [
    CommonModule,
    SharedModule,
    PropertiesRoutingModule,
  ],
  declarations: [
    PropertyFormDialogComponent,
    PropertiesListComponent,
    PropertyAccountComponent,
  ],
})
export class PropertiesModule { }
